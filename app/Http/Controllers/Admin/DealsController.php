<?php

namespace App\Http\Controllers\Admin;

use App\Models\Org\ImagesDeals;
use App\Models\Org\Organization;
use App\Models\Org\OrganizationDeal;
use App\Models\Payment\Subscription;
use App\Models\Payment\UserSubscription;
use App\Models\User;
use App\Notifications\SendEmailModerate;
use App\Traits\ApiControllerTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Notifications\UserNewDealBuyMessage;
use App\Notifications\DealCreateToCategoriesOrgSubscription;
use App\Notifications\DealUpdateToCategoriesOrgSubscription;
use Illuminate\Support\Facades\Hash;
class DealsController extends Controller
{
    use ApiControllerTrait;

    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        if ($request->finished == 'false') {
            return OrganizationDeal::filtredData($request, ['id', 'user_id', 'name', 'budget_from', 'budget_to', 'type_deal', 'finished_at', 'finish', 'organization_id', 'deadline_deal', 'created_at'])
                ->where('finish', 0)
                ->where('status', '<>', OrganizationDeal::DEAL_STATUS_MODERATION)
                ->with('organization', 'categories', 'user')
                ->paginate($request->input('per_page', 10));
        } else {
            return OrganizationDeal::filtredData($request, ['id', 'user_id', 'name', 'budget_from', 'budget_to', 'type_deal', 'finished_at', 'finish', 'organization_id', 'deadline_deal', 'created_at'])
                ->with('organization', 'categories', 'user')
                ->where('status', '<>', OrganizationDeal::DEAL_STATUS_MODERATION)
                ->paginate($request->input('per_page', 10));
        }


    }

    public function moderateIndex(Request $request)
    {
        $query = OrganizationDeal::filtredData($request, ['id', 'user_id', 'name', 'budget_from', 'budget_to', 'type_deal', 'finish', 'organization_id', 'deadline_deal', 'created_at']);

        $query->where('status', OrganizationDeal::DEAL_STATUS_MODERATION);

        return $query->with('organization', 'categories', 'user')
            ->paginate($request->input('per_page', 10));

    }

    public function moderateSuccess(Request $request)
    {

        $deals = $this->getDeals($request->id);

        $deal = $deals;
        $user = $deal->user()->first();

        $isNewDeal = ($deal->created_at->eq($deal->updated_at)) ? true : false;

        if ($deals->finish == 0) {
            OrganizationDeal::where('id', $request->id)->update(
                [
                    'status' => OrganizationDeal::DEAL_STATUS_APPROVE
                ]
            );
        } else if ($deals->finish == 1) {
            OrganizationDeal::where('id', $request->id)->update(
                [
                    'status' => OrganizationDeal::DEAL_STATUS_APPROVE,
                    'finish' => 0,
                    'finished_at' => null
                ]
            );
        }

        $this->updateSubscribeUserDealActivate($request->id, $user->id);

        // если  created_at = updated_at - то это новая сделка, иначе - обновление
        if ($isNewDeal) {
            $deal->notify(new UserNewDealBuyMessage('added', $user, $deal)); // отправит по сокетам оповещения для юзеров, что новая сделка
        } else {
            $deal->notify(new UserNewDealBuyMessage('updated', $user, $deal)); // отправит по сокетам оповещения для юзеров на обновление
        }

        // ============================== Платность услуги рассылки оповещений по эмайл ============================================================
        // если объявление о покупке, разошлем всем письма , кто в той же категории
        if ($deal->type_deal === OrganizationDeal::DEAL_TYPE_BUY) {

            $categoriesIds = $deal->categories()->pluck('id')->toArray();

            $organizationToNotify = Organization::with(['categories' => function ($query) use ($categoriesIds) {
                $query->whereIn('category_id', $categoriesIds);
            }]);

            foreach ($organizationToNotify->get() as $key => $orgCats) {
                // пропускаем организацию разместившего заявку, зачем слать письмо самому себе или у какой оргинизации нет категорий
                if ($user->id === $orgCats->owner->id or count($orgCats->categories) < 1) {
                    continue;
                }

                // шлем письмо только тем, у кого PRO аккаунт
                if ($orgCats->owner->isProAccount()) {
                    foreach ($orgCats->categories as $orgCat) {
                        // если категория заявки есть в категории текущей в цикле организации 
                        if (in_array($orgCat->id, $categoriesIds)) {

                            if ($isNewDeal) {
                                $deal->notify(new DealCreateToCategoriesOrgSubscription($orgCats->owner->email, $orgCats->owner->name, $orgCat->name));
                            } else {
                                $deal->notify(new DealUpdateToCategoriesOrgSubscription($orgCats->owner->email, $orgCats->owner->name, $orgCat->name));
                            }

                            break;
                        }
                    }
                }
            }
        }

        $deal->notify(new SendEmailModerate('Объявление опубликовано', 'Ваша заявка одобрена администратором.'));
        return $this->successResponse();
    }



    public function moderateFails(Request $request)
    {

        $deals= $this->getDeals($request->id);
        $user = $deals->user()->first();
        OrganizationDeal::where('id', $deals->id)->update(
            [
                'status' => OrganizationDeal::DEAL_STATUS_BANNED,
                'finish' => 1,
                'finished_at' => Carbon::now()
            ]
        );

        $subscriptionUser = $this->getSubscribeUserDeal($deals->id, $user->id);

        if ($subscriptionUser){
            $this->updateSubscribeUserDealFinished($subscriptionUser->id);
            // вернуть деньги , если только объявление еще не было в публикации, т.е. started_at ===null
            if($subscriptionUser->started_at === null){
               $this->updateBalance($deals->user_id, $subscriptionUser->cost); // вернуть деньги 
            }        
        }

        $deals->notify(new SendEmailModerate('Модерация отклонена', 'Ваша заявка отклонена администратором.'));

        return $this->successResponse();

    }

    private function getDeals($id)
    {
        return OrganizationDeal::where('id', $id)->first();
    }

    private function getSubscribeUserDeal ($deal_id, $userId) {
        $model=new UserSubscription();
        $userSubscription=$model->where('deal_id', $deal_id)->where('user_id', $userId)->orderBy('created_at', 'DESC')->first();
        return $userSubscription;
    }

    private function updateSubscribeUserDealFinished($subscrId) {
        UserSubscription::where('id', $subscrId)->first()
            ->update(
                [
                    'status' => Subscription::SUBSCRIPTION_STATUS_FINISHED,
                    'finished_at' => Carbon::now(),
                    'started_at' => Carbon::now()
                ]
            );
    }

    private function updateSubscribeUserDealActivate($deal_id, $userId) {
        UserSubscription::where('deal_id', $deal_id)->where('user_id', $userId)->where('status', Subscription::SUBSCRIPTION_STATUS_PAUSE)
            ->update(
                [
                    'status'=> Subscription::SUBSCRIPTION_STATUS_ACTIVE,
                    'started_at'=>Carbon::now()
                ]
            );
    }

    private function updateBalance($user_id, $cost)
    {
        User::where('id', $user_id)->update(
            [
                'ballance' => DB::raw('ballance+' . $cost)
            ]
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $deals = OrganizationDeal::with([
            'organization',
            'user',
            'cities',
            'categories',
            'questions',
            'members',
            'winner'
        ])->find($id);

        $deals->category = $deals->categories->pluck('id');
        $deals->images=$this->getImagesDeal($deals->id);
        return $deals;
    }


    public function update(Request $request)
    {
        if (sizeof($request->data['category']) > 0) {
            $deal = OrganizationDeal::find($request->id);
            $deal->name = $request->data['name'];
            $deal->description = $request->data['description'];

            if($deal->type_deal=='sell') {
                $deal->budget_to=$request->data['budget_to'];
            }


            $deal->save();

            $deal->categories()->sync($request->data['category']);

            $deal->cities()->sync($request->data['city']);

            return $this->successResponse();
        } else {
            return $this->errorResponse('Выберите хотябы 1 категорию');
        }


    }


    public function uploadImageDeal (Request $request) {
       $images=new ImagesDeals();
       $images->uploadFileAndSaveToDB($request->file, 1, $request->deal_id, config('b2b.images.resizeValMaxPx'));
       $imgDeal=$this->getImagesDeal($request->deal_id);

        return response()->json(['images'=>$imgDeal]);
    }

    private function getImagesDeal ($id) {
        $images=ImagesDeals::where('deal_id', $id)->get();

        $imgArray=[];

        if(sizeof($images)>0){
            foreach ($images as $i){
               array_push($imgArray, $i);
            }
        }


        return $imgArray;
    }

    public function deleteImage(Request $request) {

        $image=ImagesDeals::where('id', $request->id)->first();
        $deal_id=$image->deal_id;
        $path=$image->file_full_path;
        unlink(public_path($path));
        ImagesDeals::where('id', $request->id)->delete();
        return response()->json(['images'=>$this->getImagesDeal($deal_id)]);
    }

    /**
     * @param $id
     * @return mixed
     *Заявка не удаляется а уходит в архив
     * finish 1
     * status Archive
     */
    public function delete($id)
    {
//        OrganizationDeal::find($id)->delete();
        OrganizationDeal::where('id', $id)->update(
            [
                'finish' => 1,
                'finished_at' => Carbon::now(),
                'status' => OrganizationDeal::DEAL_STATUS_ARCHIVE
            ]
        );

        return $this->successResponse();
    }


    /**
     * @param Request $request
     *
     * Создаем аккаунт, компанию, сделку.  Возращаем клиенту индентификатор сделки для переадресации на редактирование
     */
    public function storeDealManager(Request $request)
    {
        $type_deal=$request->type_deal;
        return response()->json(['id'=>$this->storeAccount($type_deal)]);
    }

    private function storeAccount ($type_deal) {

        $client=new ClientsController();

        $password = str_random(8);
        $user = new User();
        $user->name = 'Продавец';
        $user->password = Hash::make($password);
        $user->email = $user->getLastEmailAutoAccount();
        $user->phone = '9999999999';
        $user->role = User::ROLE_CLIENT;
        $user->status = User::USER_STATUS_APPROVE;
        $user->unique_id = $client->generateUniqueUserIdNumber();
        $user->is_org_created = 1;
        $user->account_is_created = User::ACCOUNT_CREATED_AUTO;
        $user->hide_email = 1;
        $user->save();

        $organization=$this->generateOrg();

        $this->createOrg($user, $organization);


       return $this->dealsStore($user, $type_deal, [], 0);
    }

    private function createOrg($user, $organization)
    {
        if ($organization === null) { // MVP версия , без заполнения организации
            $organization = $user->company()->create();
        } else {
//            dd($organization['categories']);
            $cat = $organization['categories'];
            $organization = $user->company()->create($organization);
            $organization->categories()->sync($cat);

        }
        $user->organization()->associate($organization);  // Этот метод обновит отношения belongsTo() и установит внешний ключ на дочерней модели, в частности owner_id = users.id

        $user->save();
    }

    private function generateOrg () {
        $organization=[];
        $organization['categories']=[
            "0"=>1
        ];
        $organization['offices']=[];
        $organization['org_address']="Брянск";
        $organization['org_city_id']=108;
        $organization['org_description']="";
        $organization['org_director']="Фамилия";
        $organization['org_inn']="1234567890";
        $organization['org_kpp']="123123123";
        $organization['org_legal_form_id']=1;
        $organization['org_name']="Наименование";
        $organization['org_type']="buyer";
        $organization['phone']="9999999999";
        $organization['stores']=[];
        return $organization;
    }


    private function dealsStore($user, $type_deal, $images, $budget_to)
    {

        try{


            $subtype_deal = OrganizationDeal::DEAL_SUBTYPE_NA;



// ============================== Платность услуги объявление о продаже ============================================================

            // проверка возможности получить услугу в принципе
//            if($type_deal === OrganizationDeal::DEAL_TYPE_SELL){
//                //$paymentInfo = $this->paymentService->paymentServiceIsPossible($request, Subscription::SUBSCRIPTION_PAYMENT_ONCE_DEAL_SELL , true);
//              //  $isDealSell = true;
//                //$isProAccount = $paymentInfo['is_pro_account'];
//
////                if($paymentInfo['is_possible'] === false){
////                    return $this->errorResponse($paymentInfo['message']);
////                }
//            }

            // организация юзера
            $organization = $user->organization();

            // сделка
            $deal = new OrganizationDeal();
            if($organization){
                $deal->organization_id = $organization->first()->id;
            }
            $deal->user_id 		= $user->id;
            $deal->type_deal 	= $type_deal; // тип сделки (сейчас: покупка - buy, продажа - sell)
            $deal->subtype_deal = $subtype_deal; // подтип сделки (сейчас: новое - new, бу - used, без подтипа - na)

            $isDealBuy = false; // заявка по покупку
            // если объявление о покупке, то это пока всегда 'na'
            if($type_deal === OrganizationDeal::DEAL_TYPE_BUY){
                $deal->subtype_deal = OrganizationDeal::DEAL_SUBTYPE_NA;
                $isDealBuy = true;
            }
            elseif($type_deal === OrganizationDeal::DEAL_TYPE_SELL){

                    $deal->payment_status = OrganizationDeal::DEAL_STATUS_PAYMENT_PAID;

            }

            $deal->name 		= 'Наименование сделки'; // название (заголовок) заявки
            $deal->description 	= 'Описание сделки';  // описание заявки

            $deal->budget_to 	= $budget_to; // бюджет до (сейчас просто - бюджет)

            $deal->deadline_deal = null; // срок действия заявки
            $deal->save();

            $categories=[
                '0'=>3
            ];
            $deal->categories()->sync($categories);

            $cities=[
                "0"=>40
            ];
            $deal->cities()->sync($cities);

            // изображения

            if($images){
                foreach ($images as $image) {
                    if($image !== null){
                        $images = new ImagesDeals();
                        if($images->uploadFileAndSaveToDB($image, $deal->user_id, $deal->id, config('b2b.images.resizeValMaxPx')) === false){
                            return $this->errorResponse();
                        }
                    }
                }
            }


            // ============================== Платность услуги рассылки оповещений по эмайл ============================================================
            //!!!!!!  перенесено в App\Http\Controllers\Admin\DealsController    moderateSuccess()
            // если объявление о покупке, разошлем всем письма , кто в той же категории
//            if($isDealBuy){
//
//            }
//            elseif($isDealSell){
//                if($isProAccount){
//                    //$this->paymentService->newUserSubscription($paymentInfo['subscription_id'], $user->id, $deal->id, "Новая сделка о продаже. Pro аккаунт", null, null, $isProAccount);
//                }
//                else{
//                    //$user->ballance -=  $paymentInfo['cost_of_service'];// снимем сразу сумму за  услугу
//                    //$user->save();
//                    //$this->paymentService->newUserSubscription($paymentInfo['subscription_id'], $user->id, $deal->id, "Новая сделка о продаже", null, null, $isProAccount);
//                }
//
//            }
            // ==============================END  Платность услуги рассылки оповещений по эмайл ============================================================



            return $deal->id;

        }
        catch(Throwable $e){
            return $this->errorResponse($e->getMessage());
        }


    }


    public function refundDealModerate (Request $request) {
        OrganizationDeal::where('id', $request->id)->update(
            [
                'finish' => 0,
                'finished_at' => null,
                'status' => OrganizationDeal::DEAL_STATUS_MODERATION
            ]
        );

        return $this->successResponse();
    }
}
