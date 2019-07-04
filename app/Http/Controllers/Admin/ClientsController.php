<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Client\ClientStoreRequest;
use App\Http\Requests\Admin\Client\ClientStoreUserRequest;
use App\Http\Requests\Admin\Client\ClientUpdateRequest;
use App\Http\Requests\Admin\Client\ClientUpdateUser;
use App\Models\LogAdmin;
use App\Models\Org\Organization;
use App\Models\Org\OrganizationDeal;
use App\Models\Org\OrganizationOffice;
use App\Models\Org\OrganizationStore;
use App\Models\ScoreDocs;
use App\Models\User;
use App\Notifications\SendScoreClient;
use App\Repositories\OrganizationRepository;
use App\Traits\ApiControllerTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Hash;
use PDF;
use Mail;


class ClientsController extends Controller
{

    use ApiControllerTrait;

    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request, $type)
    {
        $validator = Validator::make($request->route()->parameters(), [
            'type' => 'in:' . Organization::ORG_TYPE_SELLER . ',' . Organization::ORG_TYPE_BUYER,
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        return Organization::filtredData($request)
            ->where('org_type', $type)
            ->with(['owner', 'city.region.country', 'legalForm'])
            ->paginate($request->input('per_page', 10));
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function show($id)
    {
        return Organization::with([
            'owner', 'users', 'offices', 'stores', 'city.region.country', 'legalForm'
        ])->findOrFail($id);
    }

    /**
     * @param ClientStoreRequest $request
     * @return array
     */
    public function store(ClientStoreRequest $request)
    {
        if ($user = OrganizationRepository::createOrganization($request))
            return [
                'organization_id' => $user->organization->id,
            ];

        return ['result' => false];
    }

    /**
     * @param ClientUpdateRequest $request
     * @param $id
     * @return mixed
     */
    public function update(ClientUpdateRequest $request, $id)
    {
        if ($request->get('org_status', 'register') != 'register') {
            if (!Auth()->user()->can('clients.moderate')) {
                $request->merge([
                    'org_status' => 'register'
                ]);
            }
        }

        $organization = Organization::findOrFail($id);
        $organization->update($request->all());
        $organization->owner->name = $request->user_name;
        $organization->owner->save();

        dispatch((new \App\Jobs\Geo\GeoCodeOrganizationAddress($organization))->onQueue('geo'));

        return $organization;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete();
        return '';
    }

    /**
     * @param $id
     * @return mixed
     */
    public function moderate($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->on_moderate = 0;
        $organization->save();

        return $organization;
    }

    /**
     * @param $id
     * @return string
     */
    public function deleteOffice($id)
    {
        $office = OrganizationOffice::findOrFail($id);
        $office->delete();

        return $this->successResponse();
    }

    /**
     * @param $id
     * @return string
     */
    public function deleteStore($id)
    {
        $store = OrganizationStore::findOrFail($id);
        $store->delete();

        return $this->successResponse();
    }

    /*22.03.19*/

    /**
     * @param Request $request
     *
     * Методы для работы с базой прямо тут.
     *
     * @todo если все ок при тестировании перенести в репозиторий или модель запросы.
     */
    public function storeUserClient(ClientStoreUserRequest $request)
    {

//        собираю массив для создания пользователя (без организации) записываю
// в базу отдаю ответ фронту

        $password = str_random(8);
        $user = new User();
        $user->name = $request->user['name'];
        $user->password = Hash::make($password);
        $user->email = mb_strtolower($request->user['email']);
        $user->phone = $request->user['phone'];
        $user->role = User::ROLE_CLIENT;
        $user->status = User::USER_STATUS_APPROVE;
        $user->unique_id = $this->generateUniqueUserIdNumber();
        $user->save();

        $this->createOrg($user, $request->organization);

        $log = [
            'method' => __METHOD__,
            'data' => json_encode($request->all()),
            'user_id' => Auth::user()->id
        ];
        LogAdmin::create($log)->save();

        $user->notify(new \App\Notifications\SendClientPassword($request->user['email'], $password));

        return $this->successResponse();

    }


    private function createOrg($user, $organization)
    {
        if ($organization === null) { // MVP версия , без заполнения организации
            $organization = $user->company()->create();
        } else {
            $cat = $organization['categories'];
            $organization = $user->company()->create($organization);
            $organization->categories()->sync($cat);

        }
        $user->organization()->associate($organization);  // Этот метод обновит отношения belongsTo() и установит внешний ключ на дочерней модели, в частности owner_id = users.id

        $user->save();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllClients(Request $request)
    {
        $query = User::workers();
        if ($request->search) {
            $query->where('unique_id', $request->search);
        }
        if ($request->blocked == 'false') {
            $query->where('status', '<>', 'banned');
        } else {

        }
        $users = $query->paginate($request->input('per_page', 10));
        foreach ($users as $user){
            $user->makeVisible(['created_at']);
        }
        return $users;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getClient($id)
    {
        $user = User::where('id', $id)->first();
        $organization = Organization::where('owner_id', $user->id)->first();
        $organization->categories = DB::table('organizations_categories')->select('category_id')->where('organization_id', $organization->id)->get()->pluck('category_id');

        return response()->json(['user' => $user, 'organization' => $organization]);
    }

    /**
     * @param ClientUpdateUser $request
     * @param $id
     * @return array
     */
    public function updateUserClient(ClientUpdateUser $request)
    {

        $validatedDataOrg = Validator::make($request->body['organization'], [

            'phone'             => 'sometimes|required|regex:/(^(\d+)$)/u|min:5|max:11',
            'org_city_id'       => 'required|exists:cities,id',
            'org_name'          => 'required|max:255',
            'org_inn'           => 'required|min:10|max:12',
            'org_kpp'           => 'required|min:9|max:9',
            'org_legal_form_id' => 'required|exists:organizations_legal_forms,id',
            'org_director'      => 'sometimes|required|max:64'
        ]);

        if ($validatedDataOrg->fails()) {
            return response()->json($validatedDataOrg->messages(), 200);
        }

        User::where('id', $request->id)->update(
            [
                'name' => $request->body['user']['name'],
                'email' => $request->body['user']['email'],
                'phone' => $request->body['user']['phone']
            ]
        );



        $modelOrg = Organization::find($request->body['organization']['id']);
        $modelOrg->org_address = $request->body['organization']['org_address'];
        $modelOrg->org_description = $request->body['organization']['org_description'];
        $modelOrg->org_director = $request->body['organization']['org_director'];
        $modelOrg->org_inn = $request->body['organization']['org_inn'];
        $modelOrg->org_kpp = $request->body['organization']['org_kpp'];
        $modelOrg->org_legal_form_id = $request->body['organization']['org_legal_form_id'];
        $modelOrg->org_name = $request->body['organization']['org_name'];
        $modelOrg->org_type = $request->body['organization']['org_type'];
        $modelOrg->phone = $request->body['organization']['phone'];
        $modelOrg->save();

        $modelOrg->categories()->sync($request->body['organization']['categories']);

        $log = [
            'method' => __METHOD__,
            'data' => json_encode($request->all()),
            'user_id' => Auth::user()->id
        ];

        User::where('id', $request->id)->update(
            [
                'is_org_created' => 1
            ]
        );

        LogAdmin::create($log)->save();

        return $this->successResponse();
    }


    /**
     *
     */
    public function bannedClientUser(Request $request)
    {

        User::where('id', $request->id)->update(
            [
                'status' => $request->params['status']
            ]
        );

        $log = [
            'method' => __METHOD__,
            'data' => json_encode($request->all()),
            'user_id' => Auth::user()->id
        ];
        LogAdmin::create($log)->save();

        return $this->successResponse();
    }

    /**
     * Продублировал код 2 метода изи UserController. Знаю, что плохо))
     * @return int
     * @todo при рефакторинге вычистить
     */
    public static function generateUniqueUserIdNumber()
    {

        $number = mt_rand(1000000, 9999999); // better than rand()

        if (self::barcodeNumberExists($number)) {
            return self::generateUniqueUserIdNumber();
        }

        return $number;
    }

    public static function barcodeNumberExists($number)
    {
        return User::whereUniqueId($number)->exists();
    }


    public function generatePassword(Request $request)
    {
        $password = str_random(8);
        $user = User::where('unique_id', $request->params['unique_id'])->first();
        $user->password=bcrypt($password);
        $user->save();
        $user->notify(new \App\Notifications\SendClientPassword($user['email'], $password));

        return $this->successResponse();
    }


    /**
     * Генерация счета
     * @param Request $request
     */
    public function generateScore(Request $request)
    {

        $unique_id = $request->params['unique_id'];
        $summ = number_format($request->params['summ'], 2, '.', '');
        
        $modelOrgDeal=new OrganizationDeal();
        $fileName=$modelOrgDeal->score($unique_id, $summ,  Auth::user());

        return response()->json(['result' => true, 'link' => '/' . $fileName]);
    }



    public function scoreSend (Request $request) {

       $user=User::where('unique_id', $request->params['unique_id'])->first();

       $user->notify(new \App\Notifications\SendScoreClient($request->params['usermail'], $request->params['link']));

       return $this->successResponse();
    }

    public function updateBalance (Request $request) {

       $summ =  $request->params['summ'];
        $user=User::where('unique_id', $request->params['unique_id'])->first();

        User::where('unique_id', $request->params['unique_id'])->update(
            [
                'ballance'=>$user->ballance+$summ
            ]
        );

        return $this->successResponse();
    }



 


}
