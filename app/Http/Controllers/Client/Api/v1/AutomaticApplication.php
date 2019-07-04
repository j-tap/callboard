<?php

namespace App\Http\Controllers\Client\Api\v1;

use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Controllers\Admin\ClientsController;
use App\Models\Org\OrganizationDeal;
use Illuminate\Support\Facades\Hash;

class AutomaticApplication extends Controller
{

    use ApiControllerTrait;


    public function __construct()
    {

    }

    public function index (Request $request) {
        $email=$request->data['email'];
        $phone=$request->data['phone'];
        $descriptionDeal=$request->data['text'];
        $type_deal='buy';


        if($this->checkAccount($email)){
            return $this->errorResponse('Данный E-mail уже зарегистрирован');
        }

        $this->storeAccount($type_deal, $phone, $email, $descriptionDeal);

        return $this->successResponse();
    }



    private function checkAccount ($email) {
        return User::where('email', $email)->first();
    }



    private function storeAccount ($type_deal, $phone,  $email,  $descriptionDeal) {

        $client=new ClientsController();

        $password = str_random(8);
        $user = new User();
        $user->name = 'Продавец';
        $user->password = Hash::make($password);
        $user->email = $email;
        $user->phone = $phone;
        $user->role = User::ROLE_CLIENT;
        $user->status = User::USER_STATUS_APPROVE;
        $user->unique_id = $client->generateUniqueUserIdNumber();
        $user->is_org_created = 1;
        $user->account_is_created = User::ACCOUNT_CREATED_FORM;
        $user->hide_email = 1;
        $user->save();

        $organization=$this->generateOrg();

        $this->createOrg($user, $organization);


        return $this->dealsStore($user, $type_deal, $descriptionDeal, [], 0);
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


    private function dealsStore($user, $type_deal, $descriptionDeal, $images, $budget_to)
    {
        try{

            $subtype_deal = OrganizationDeal::DEAL_SUBTYPE_NA;

// ============================== Платность услуги объявление о продаже ============================================================

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

            $deal->name 		= 'Наименование сделки лендинг'; // название (заголовок) заявки
            $deal->description 	= $descriptionDeal;  // описание заявки

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

            return $deal->id;
        }
        catch(Throwable $e){
            return $this->errorResponse($e->getMessage());
        }
    }
}
