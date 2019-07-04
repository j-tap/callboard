<?php

namespace App\Http\Controllers\Client\Api\v1;

use App\Formatter\Api\v1\DealsItemFormatter;
use App\Http\Requests\Client\Api\v1\Deal\DealStoreRequest;
use App\Http\Requests\Client\Api\v1\Deal\DealUpdateRequest;
use App\Models\DealQuestion;
use App\Models\Org\OrganizationDeal;
use App\Models\Org\Organization;
use App\Models\Org\OrganizationDealAnswer;
use App\Models\User;
use App\Models\Payment\Subscription;
use App\Models\Payment\UserSubscription;
use App\Notifications\DealComplete;
use App\Notifications\DealCreate;
use App\Notifications\DealUpdate;
use App\Notifications\DealNewMember;
use App\Notifications\DealRateWinner;
use App\Notifications\DealSetWinner;
use App\Notifications\DealWinner;
use App\Notifications\UserNewDealBuyMessage;
use App\Notifications\DealCreateToCategoriesOrgSubscription;
use App\Repositories\Filters\FilterDealsRepository;
use App\Repositories\CategoryRepository;
use App\Rules\DealAnswersRule;
use App\Traits\ApiControllerTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Client\Api\v1\PaymentServicesController;
use App\Models\Org\ImagesDeals;
use Auth;
use Throwable;

class DealController extends Controller
{
	use ApiControllerTrait;

	public $paymentService = null;

 /**
     * Create a new controller instance.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        $this->paymentService = new PaymentServicesController();
    }

	// mvp tamtem
	// список всех сделлок вообще  ===============================================================================================
	public function dealsList(Request $request)
	{
		//$user = Auth::guard('api')->user(); // todo удалить при чистке
		
		$filters = $request->all();

		$categories = $request->input('categories', null);
		$countries 	= $request->input('countries', null);
		$regions 	= $request->input('regions', null);  
		$cities 	= $request->input('cities', null); 
		$finish 	= $request->input('finish', null);
		$typeDeal 	= $request->input('type_deal', null);
		$userId 	= $request->input('user_id', null);
		if (!in_array($typeDeal, [OrganizationDeal::DEAL_TYPE_SELL, OrganizationDeal::DEAL_TYPE_BUY])){
			$typeDeal = null;
		}
		$subtypeDeal 	= $request->input('subtype_deal', null);
		if (!in_array($subtypeDeal, [OrganizationDeal::DEAL_SUBTYPE_NA, OrganizationDeal::DEAL_SUBTYPE_NEW, OrganizationDeal::DEAL_SUBTYPE_USED])){
			$subtypeDeal = null;
		}

		$status 	= $request->input('status', null);
		if (!in_array($status, [OrganizationDeal::DEAL_STATUS_MODERATION,
								OrganizationDeal::DEAL_STATUS_APPROVE,  
								OrganizationDeal::DEAL_STATUS_ARCHIVE,   
								OrganizationDeal::DEAL_STATUS_BANNED])){
			$status = null;
		}

		
		$payment_status 	= $request->input('payment_status', null);
		if (!in_array($payment_status, [OrganizationDeal::DEAL_STATUS_PAYMENT_PAID,
										OrganizationDeal::DEAL_STATUS_PAYMENT_NOT_PAID,  
										OrganizationDeal::DEAL_STATUS_PAYMENT_FREE])){
			$payment_status = null;
		}

		try{
			// dd(	FilterDealsRepository::filter($categories, $countries, $regions,  $cities, false, false, false, $finish , $typeDeal, 
			// false, false , false, false, false, false,false, $subtypeDeal, $status, $userId   )->get()->toArray());
			return $this->successResponse(
				DealsItemFormatter::formatPaginator(
					// FilterDealsRepository::getUserDeals($user)->simplePaginate() // todo удалить при чистке
					FilterDealsRepository::filter($categories, $countries, $regions,  $cities, false, false, false, $finish , $typeDeal, 
								false, false , false, false, false, false,false, $subtypeDeal, $status, $userId, $payment_status   )->simplePaginate()
				)
			);

		}
		catch(Throwable $e){
			return $this->errorResponse($e->getMessage());
		}
	}

	// mvp tamtem
	// список всех сделлок вообще  ===============================================================================================
	public function dealsListCurrentUser(Request $request)
	{
		$user = Auth::guard('api')->user();

		$filters = $request->all();

		$categories = $request->input('categories', null);
		$countries 	= $request->input('countries', null);
		$regions 	= $request->input('regions', null);  
		$cities 	= $request->input('cities', null); 
		$finish 	= $request->input('finish', null);
		$typeDeal 	= $request->input('type_deal', null);
		if (!in_array($typeDeal, [OrganizationDeal::DEAL_TYPE_SELL, OrganizationDeal::DEAL_TYPE_BUY])){
			$typeDeal = null;
		}
		$subtypeDeal 	= $request->input('subtype_deal', null);
		if (!in_array($subtypeDeal, [OrganizationDeal::DEAL_SUBTYPE_NA, OrganizationDeal::DEAL_SUBTYPE_NEW, OrganizationDeal::DEAL_SUBTYPE_USED])){
			$subtypeDeal = null;
		}
		
		$status 	= $request->input('status', null);
		if (!in_array($status, [OrganizationDeal::DEAL_STATUS_MODERATION,
								OrganizationDeal::DEAL_STATUS_APPROVE,  
								OrganizationDeal::DEAL_STATUS_ARCHIVE,   
								OrganizationDeal::DEAL_STATUS_BANNED])){
			$status = null;
		}
		      
		$payment_status 	= $request->input('payment_status', null);
		if (!in_array($payment_status, [OrganizationDeal::DEAL_STATUS_PAYMENT_PAID,
										OrganizationDeal::DEAL_STATUS_PAYMENT_NOT_PAID,  
										OrganizationDeal::DEAL_STATUS_PAYMENT_FREE])){
			$payment_status = null;
		}

		try{

			return $this->successResponse(
				DealsItemFormatter::formatPaginator(
					FilterDealsRepository::getUserDeals($user, $categories, $countries, $regions, $regions, $finish, $typeDeal, $subtypeDeal, $status, $payment_status )->simplePaginate()				
				)
		);

		}
		catch(Throwable $e){
			return $this->errorResponse($e->getMessage());
		}
	}

	public function dealsQuestions()
	{
		return $this->successResponse(
		   DealQuestion::all(['id', 'name', 'question'])
		);
	}

	// mvp tamtem
	// сздать сделку в зависимости от ее типа, sell, buy  ===============================================================================================
	public function dealsStore(DealStoreRequest $request)
	{

		try{

			$user = Auth::guard('api')->user();
			
		    $type_deal = $request->get('type_deal');
			$subtype_deal = $request->get('subtype_deal', OrganizationDeal::DEAL_SUBTYPE_NA);

			//проверим, есть ли у юзера телефон 
			if(! $user->phoneExist()){
				return $this->errorResponse("Вы не можете размещать заявки, пока не заполните номер телефона в своем личном кабинете!");
			}
			$isDealSell = ($type_deal === OrganizationDeal::DEAL_TYPE_SELL) ? true : false;
			$isProAccount = false;
			// ============================== Платность услуги объявление о продаже ===========================================
			//> проверка возможности получить услугу в принципе
			if($isDealSell){
				$paymentInfo = $this->paymentService->paymentServiceIsPossible($request, Subscription::SUBSCRIPTION_PAYMENT_ONCE_DEAL_SELL , true);
				$isProAccount = $paymentInfo['is_pro_account'];

				if($paymentInfo['is_possible'] === false){
					return $this->errorResponse($paymentInfo['message']);
				}
			}
			//< ==============================END Платность услуги ============================================================

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

			// если объявление о покупке, то это пока всегда 'na'
			if(!$isDealSell){
				$deal->subtype_deal = OrganizationDeal::DEAL_SUBTYPE_NA;
				$deal->budget_from = $request->get('budget_from', 0);
			}
			else{ // объявление о продаже
				if($isProAccount){
					$deal->payment_status = OrganizationDeal::DEAL_STATUS_PAYMENT_PAID;
				}
				else{
					$deal->payment_status = OrganizationDeal::DEAL_STATUS_PAYMENT_PAID;
				}
			}
			
			$deal->name 		= $request->get('name'); // название (заголовок) заявки
			$deal->description 	= $this->getNullIsStringNullLetters( $request->get('description', null));  // описание заявки
			//$deal->question = $request->get('question', null); // todo все куски закомментированного кода удалить при чистке
			//$deal->pay_type_cash = $request->get('pay_type_cash', 0);
			//$deal->pay_type_noncash = $request->get('pay_type_noncash', 0);
			$deal->budget_to 	= $request->get('budget_to', 0); // бюджет до (сейчас просто - бюджет)
			$deal->is_need_kp 	= $request->get('is_need_kp', 0); // надо ли коммерческое предложение требовать с другой стороны
			// $deal->fast_deal = $request->get('fast_deal', 0);
			// $deal->favorite_only = $request->get('favorite_only', 0);
			$deal->deadline_deal = $this->getNullIsStringNullLetters( $request->get('deadline_deal', null)); // срок действия заявки
			//$deal->deadline_service = $request->get('deadline_service' , null); // срок сбора предложений

			$deal->save();

			$deal->categories()->sync($request->categories);

			$deal->cities()->sync($request->cities);

			// изображения
			$images = $request->images;
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

			// ============================== Платность услуги, снимем деньги за объявление ============================================================
			//!!!!!!  рассылка писем о продаже перенесено в App\Http\Controllers\Admin\DealsController    moderateSuccess()
			if($isDealSell){
				if($isProAccount){				
					$this->paymentService->newUserSubscription($paymentInfo['subscription_id'], $user->id, $deal->id, $paymentInfo['service_name'] . ". Pro аккаунт", null, null, $isProAccount);
				}
				else{
					$user->ballance -=  $paymentInfo['cost_of_service'];// снимем сразу сумму за  услугу
					$user->save();
					$this->paymentService->newUserSubscription($paymentInfo['subscription_id'], $user->id, $deal->id, $paymentInfo['service_name'], null, null, $isProAccount);
				}
			}
			// ==============================END  Платность услуги рассылки оповещений по эмайл ============================================================

			$deal->notify(new DealCreate());

		// перенесено в App\Http\Controllers\Admin\DealsController    moderateSuccess()
		//	$deal->notify(new UserNewDealBuyMessage('added', $user, $deal)); // отправит по сокетам оповещения для юзеров

			return $this->successResponse([
				'id' => $deal->id
			 ]);

		}
		catch(Throwable $e){
			return $this->errorResponse($e->getMessage());
		}
		// if ($request->get('questions'))
		// 	$deal->questions()->sync($request->questions); //todo удалить после чистки

	}

	// mvp tamtem
	// редактировать сделку  ================================================================================================================
	public function dealsUpdate(DealUpdateRequest $request, $id)
	{

		try{

			$user = Auth::guard('api')->user();
			$id  = (int) $id;

			//проверим, есть ли у юзера телефон 
			if(! $user->phoneExist()){
				return $this->errorResponse("Вы не можете редактировать заявку, пока не заполните номер телефона в своем личном кабинете!");
			}


			$deal = OrganizationDeal::where('id', '=', $id)->first();

			if(!$deal){
				return $this->errorResponse("Нет объявления с id = " . $id);
			}
			// если это сделка юзера  то давать редактировать, иначе лесом слать!!
			if((int)$user->id !==  (int) $deal->user()->first()->id){
				return $this->errorResponse("Вы не можете редактировать заявку, вы ее не создавали");
			}

			$isDealSell = ($deal->type_deal === OrganizationDeal::DEAL_TYPE_SELL) ? true : false;
			$isNeedPayDealSell = ($isDealSell and ($deal->status === OrganizationDeal::DEAL_STATUS_ARCHIVE or $deal->status === OrganizationDeal::DEAL_STATUS_BANNED or $deal->finish === true)) ? true : false;
			$isProAccount = false;
			// ============================== Платность услуги объявление о продаже ============================================================
			//> проверка возможности получить услугу в принципе и если заявка забанена или финишировала, то надо платить
			if($isNeedPayDealSell){
				$paymentInfo = $this->paymentService->paymentServiceIsPossible($request, Subscription::SUBSCRIPTION_PAYMENT_ONCE_DEAL_SELL , true);
				$isProAccount = $paymentInfo['is_pro_account'];

				if($paymentInfo['is_possible'] === false){
					return $this->errorResponse($paymentInfo['message']);
				}
			}
			//< ==============================END Платность услуги ============================================================

			$prev_name = $deal->name;
			$prev_description = $deal->description;

			$images = $request->images; // получили фотки
			$type_deal = $request->get('type_deal');

			if($type_deal !== $deal->type_deal){
				return $this->errorResponse("Вы не можете изменять тип сделки !");
			}

			$subtype_deal = $request->get('subtype_deal', OrganizationDeal::DEAL_SUBTYPE_NA);
			$deal->subtype_deal = $subtype_deal; // подтип сделки (сейчас: новое - new, бу - used, без подтипа - na)
			// если объявление о покупке, то это пока всегда 'na'
			if(!$isDealSell){
				$deal->subtype_deal = OrganizationDeal::DEAL_SUBTYPE_NA;
				$deal->budget_from = $request->get('budget_from', 0);
			}
			else{
				$deal->payment_status = OrganizationDeal::DEAL_STATUS_PAYMENT_PAID;
			}

			// // проверим, может ли юзер давать объявление о продаже
			// if($type_deal === OrganizationDeal::DEAL_TYPE_SELL and ! ($user->is_org_created)){
			// 	return $this->errorResponse("Вы не можете давать объявления о продаже, пока не зарегистрируете организацию!");
			// }

			// организация юзера
			//$organization = $user->organization();

			// сделка
			//$deal->type_deal 	= $type_deal; // тип сделки (сейчас: покупка - buy, продажа - sell)
			$deal->name 		= $request->get('name'); // название (заголовок) заявки
			$deal->description 	= $this->getNullIsStringNullLetters( $request->get('description', null));  // описание заявки
			$deal->budget_to 	= $request->get('budget_to', 0); // бюджет до (сейчас просто - бюджет)
			$deal->deadline_deal = $this->getNullIsStringNullLetters( $request->get('deadline_deal', null)); // срок действия заявки
			$deal->is_need_kp 	= $request->get('is_need_kp', 0); // надо ли коммерческое предложение требовать с другой стороны
			// // если поменяли текст или картунку загрузили - отправляем на модерацию
			// if($prev_name !== $deal->name or  $prev_description !== $deal->description or $images !== null){
			// 	$deal->status = OrganizationDeal::DEAL_STATUS_MODERATION;
			// }

			$deal->status = OrganizationDeal::DEAL_STATUS_MODERATION;
			$deal->finish = false;

			$deal->save();

			if ($request->get('cities')){
				$deal->cities()->sync($request->cities);
			}

			$deal->categories()->sync($request->categories);

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


			// ============================== Платность услуги, снимем деньги за объявление ============================================================
			//!!!!!!  рассылка писем о продаже перенесено в App\Http\Controllers\Admin\DealsController    moderateSuccess()
			if($isNeedPayDealSell){
				if($isProAccount){				
					$this->paymentService->newUserSubscription($paymentInfo['subscription_id'], $user->id, $deal->id, $paymentInfo['service_name'] . ". Pro аккаунт. Восстановление сделки", null, null, $isProAccount);
				}
				else{
					$user->ballance -=  $paymentInfo['cost_of_service'];// снимем сразу сумму за  услугу
					$user->save();
					$this->paymentService->newUserSubscription($paymentInfo['subscription_id'], $user->id, $deal->id, $paymentInfo['service_name'] . ". Восстановление сделки", null, null, $isProAccount);
				}
			}
			// ==============================END  Платность услуги рассылки оповещений по эмайл ============================================================


			// перенесено в App\Http\Controllers\Admin\DealsController    moderateSuccess()
			$deal->notify(new UserNewDealBuyMessage('goto_moderation_with_update', $user, $deal)); // отправит по сокетам оповещения для юзеров
		//	$deal->notify(new UserNewDealBuyMessage('updated', $user, $deal)); // отправит по сокетам оповещения для юзеров
			$deal->notify(new DealUpdate());

			return $this->successResponse(
				//[$deal]
			);

		}
		catch(Throwable $e){
			return $this->errorResponse($e->getMessage());
		}
	
	}


	// mvp tamtem
	// покать сделку по ее id   ==========================================================================================================
	public function dealsShow($id)
	{
		
		try{
			$id = (int) $id;
			if (!$deal = OrganizationDeal::with(['organization', 'members', 'categories', 'cities', 'user', 'questions'])->find($id))
				throw new \App\Exceptions\NotFoundException();

			$user = Auth::guard('api')->user();

			if ($user && $deal->organization_id == $user->organization_id) {
				$deal->getAnswersByMember();
			}
			else{ // добавим просмотр к объявлению, если смотрел не сам
				$deal->increment('count_views');
			}

			return $this->successResponse(
				DealsItemFormatter::format($deal)
			);
		}
		catch(Throwable $e){
			return $this->errorResponse($e->getMessage());
		}
	}

	// mvp tamtem
	// удалить картинку по ее id   ===========================================================================================================
	public function dealsImageDelete(Request $request)
	{
		try{

			$id = $request->input('id', null);

			if($id === null){
				return $this->errorResponse("Отсутствует id");
			}
		
			$id = (int) $id;

			$user = Auth::guard('api')->user();
			$image  = ImagesDeals::findOrFail($id);
			
			// если id текущего юзера = id юзера, чья картинка, то удалять даем
			$idUserOwnerImage = $image->deal()->first()->user()->first()->id;
			if($idUserOwnerImage !== $user->id){
				$this->errorResponse("Нельзя удалить изображение, загруженное не вами!!!");
			}

			// удаляем изображение
			if(!$image->deleteImageDeal($id)){
				$this->errorResponse("Ошибка удаления изображения. Обратитесь в службу техподдержки или попробуйте повторить операцию позднее.");
			}

			// удалим строку из базы
			$image->delete();
	
			// if($images->uploadFileAndSaveToDB($image, $deal->user_id, $deal->id, config('b2b.images.resizeValMaxPx')) === false){
			return $this->successResponse();

		}
		catch(Throwable $e){
			return $this->errorResponse($e->getMessage());
		}

	}

	// заявка на участие в сделке
	public function dealsTake(Request $request, $id)
	{
		if (!$deal = OrganizationDeal::find($id))
			throw new \App\Exceptions\NotFoundException();

		$user = Auth::guard('api')->user();

		if ($deal->members()->where('organization_id', $user->organization_id)->first())
			return $this->errorResponse();

		if ($deal->organization_id == $user->organization_id)
			return $this->errorResponse();

		$request->merge(['date' => Carbon::now()]);
		$this->validate($request, [
			'answers' => ['required', 'array', new DealAnswersRule($deal)],
	   //			'date' => 'before_or_equal:' . $deal->deadline_service    // todo удалить при чистке   - это время сбора предложений
		]);

		if ($deal->favorite_only) {
			if (!$deal->organization->favorites()->where('favorite_id', $user->organization_id)->first())
				return $this->errorResponse();
		}

		foreach ($request->answers as $userAnswer) {
			$answer = new OrganizationDealAnswer();
			$answer->deal_id = $deal->id;
			$answer->organization_id = $user->organization_id;
			$answer->question_id = isset($userAnswer['id']) ? $userAnswer['id'] : null;
			$answer->answer = $userAnswer['answer'];
			$answer->save();
		}

		$deal->members()->attach($user->organization_id);

		$deal->notify(new DealNewMember($user->organization));

		return $this->successResponse();
	}

	// выбор победителя в сделке
	public function dealsSetWinner(Request $request, $id)
	{
		$user = Auth::guard('api')->user();

		if ((!$deal = OrganizationDeal::find($id)) || ($user->organization_id != $deal->organization_id))
			throw new \App\Exceptions\NotFoundException();

		if (!$request->get('winner_id') || $deal->winner_id != null)
			return $this->errorResponse();

		if (!$winner = $deal->members()->where('id', $request->get('winner_id'))->first())
			return $this->errorResponse();

		$deal->winner_id = $request->get('winner_id');
		$deal->save();

		$deal->notify(new DealWinner());
		$deal->notify(new DealSetWinner());

		return $this->successResponse();
	}

	// mvp tamtem
	//Завершение сделки - по сути это отмечаем  на удаление  =============================================================================
	public function dealsFinish(Request $request, $id)
	{

		try{

			$user = Auth::guard('api')->user();

			if ((!$deal = OrganizationDeal::find($id)) || ($user->organization_id != $deal->organization_id))
				throw new \App\Exceptions\NotFoundException();

			// если это сделка юзера  то давать редактировать, иначе лесом слать!!
			if((int)$user->id !==  (int) $deal->user()->first()->id){
				return $this->errorResponse("Вы не можете редактировать объявление, вы ее не создавали");
			}
	
			if ($deal->finish)
				return $this->errorResponse('Заявка уже помещена в завершенные');
	
			$deal->finish = true;
			$deal->finished_at = Carbon::now();
			$deal->status = OrganizationDeal::DEAL_STATUS_ARCHIVE; 
			$deal->save();

			// ============================== Платность услуги объявление о продаже ============================================================
			if($deal->type_deal === OrganizationDeal::DEAL_TYPE_SELL){
					$deal->finishPaymentAllService();
			}
			// ==============================END Платность услуги объявление о продаже ============================================================

			$deal->notify(new UserNewDealBuyMessage('deleted', $user, $deal)); // отправит по сокетам оповещения для юзеров

			return $this->successResponse();

		}
		catch(Throwable $e){
			return $this->errorResponse($e->getMessage());
		}
		
	}

	// mvp tamtem
	//Срок действия заявок - месяц, поом удаляем - по сути это отмечаем  на удаление  =============================================================================
	public function runDeleteDealsBeforeToDateWorker()
	{

		try{

			$dealsToDelete = OrganizationDeal::where('finish' , '=', false)
										 ->whereDate('created_at' , '<=' , Carbon::now()->subMonth() )
										 ->orderBy('created_at', 'DESC')
										 ->update(['finish' => true, 'finished_at' => Carbon::now(), 'status' => OrganizationDeal::DEAL_STATUS_ARCHIVE]);

			// остановим подписки
			$SubsciptionToFinished = UserSubscription::where('status' , '<>', Subscription::SUBSCRIPTION_STATUS_FINISHED)
										 ->whereRaw('duration_days <> 0')
										 ->whereRaw('started_at < (now() - interval `duration_days` day)')
										 ->orderBy('started_at', 'DESC')
										 ->update(['status' => Subscription::SUBSCRIPTION_STATUS_FINISHED, 'finished_at' => Carbon::now()]);
										 


		}
		catch(Throwable $e){
			return $this->errorResponse($e->getMessage());
		}
		
	}

	// mvp tamtem
	// список всех удаленных заявок вообще  ===============================================================================================
	public function deletedDealsList(Request $request)
	{
		$user = Auth::guard('api')->user(); // todo удалить при чистке
		$userId = $user->id;
		$status = OrganizationDeal::DEAL_STATUS_ARCHIVE;

		if($user->role === User::ROLE_ADMINISTRATOR){
			$userId = null;
			$status = $request->input('status', OrganizationDeal::DEAL_STATUS_ARCHIVE);
		}
		
		if (!in_array($status, [OrganizationDeal::DEAL_STATUS_MODERATION,
								OrganizationDeal::DEAL_STATUS_APPROVE,  
								OrganizationDeal::DEAL_STATUS_ARCHIVE,   
								OrganizationDeal::DEAL_STATUS_BANNED])){
			$status = OrganizationDeal::DEAL_STATUS_ARCHIVE;
		}

		try{

			$ret =  $this->successResponse(
				DealsItemFormatter::formatPaginator(
					FilterDealsRepository::filter(false, false, false,  false, false, false, false, 1 , null, 
								false, false , false, false, false, false,false, null, $status, $userId  )->simplePaginate()
				)
			);

			return $ret;
		}
		catch(Throwable $e){
			return $this->errorResponse($e->getMessage());
		}
	}

	// mvp tamtem
	// восстановить заявку  ===============================================================================================
	public function restoreDeal(Request $request, $id)
	{
		try{

			$user = Auth::guard('api')->user();
			$id  = (int) $id;

			$deal = OrganizationDeal::where('id', '=', $id)->first();
			$type_deal =$deal->type_deal;

			if(!$deal){
				return $this->errorResponse("Нет объявления с id = " . $id);
			}

			if($user->role !== User::ROLE_ADMINISTRATOR){
				// если это сделка юзера  то давать восстановить, иначе лесом слать!!
				if((int)$user->id !==  (int) $deal->user()->first()->id){
					return $this->errorResponse();
				}
			}
			$isDealSell = false;
			// ============================== Платность услуги объявление о продаже ============================================================
			//> проверка возможности получить услугу в принципе
			if($type_deal === OrganizationDeal::DEAL_TYPE_SELL){
				$paymentInfo = $this->paymentService->paymentServiceIsPossible($request, Subscription::SUBSCRIPTION_PAYMENT_ONCE_DEAL_SELL , true);
				$isDealSell = true;
				$isProAccount = $paymentInfo['is_pro_account'];
				if($paymentInfo['is_possible'] === false){
					return $this->errorResponse($paymentInfo['message']);
				}
			}
			//< ==============================END Платность услуги объявление о продаже ============================================================

			$deal->count_views = 0;
			$deal->finished_at = null;
			$deal->finish = false;
			$deal->status = OrganizationDeal::DEAL_STATUS_MODERATION;

			$deal->save();

			// ============================== Платность услуги объявление о продаже ============================================================
			if($isDealSell){
				if($isProAccount){
					$this->paymentService->newUserSubscription($paymentInfo['subscription_id'], $user->id, $deal->id, $paymentInfo['service_name'] . ". Восстановленная из архива. Pro аккаунт", null, null, $isProAccount);
				}
				else{
					$user->ballance -=  $paymentInfo['cost_of_service'];// снимем сразу сумму за  услугу
					$user->save();
					$this->paymentService->newUserSubscription($paymentInfo['subscription_id'], $user->id, $deal->id, $paymentInfo['service_name'] . ". Восстановленная из архива.", null, null, $isProAccount);
				}

			}

			return $this->successResponse();

		}
		catch(Throwable $e){
			return $this->errorResponse($e->getMessage());
		}
	}

}
