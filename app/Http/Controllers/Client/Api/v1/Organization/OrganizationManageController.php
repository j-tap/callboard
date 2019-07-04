<?php

namespace App\Http\Controllers\Client\Api\v1\Organization;

use App\Formatter\Api\v1\OrganizationItemFormatter;
use App\Http\Requests\Client\Api\v1\Organization\OfficeStoreRequest;
use App\Http\Requests\Client\Api\v1\Organization\OrganizationStoreRequest;
use App\Http\Requests\Client\Api\v1\Organization\OrganizationEditRequest;
//use App\Http\Requests\Client\Api\v1\Organization\OrganizationCategoriesEditRequest;
use App\Http\Requests\Client\Api\v1\Organization\StoreStoreRequest;
use App\Http\Requests\Client\Api\v1\Organization\UserStoreRequest;
use App\Http\Requests\Client\Api\v1\Organization\UserUpdateRequest;
use App\Models\Org\Organization;
use App\Repositories\OrganizationRepository;
use App\Traits\ApiControllerTrait;
use App\Traits\ModelFileUpload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Hash;
use Validator;

class OrganizationManageController extends Controller
{

    use ApiControllerTrait;
    use ModelFileUpload;

    // Manage Organization users

    public function permissions()
    {
        return $this->successResponse(
            config('b2b.permissions_site')
        );
    }

    public function users()
    {
        return $this->successResponse(
            Auth::guard('api')->user()->organization->users()->workers()->select(['id', 'name', 'email', 'role', 'status'])->get()
        );
    }

    public function user($id)
    {
        if (!$user = Auth::guard('api')->user()->organization->users()->workers()->select(['id', 'name', 'email', 'role', 'status'])->find($id)) {
            return $this->errorResponse();
        }

        return $this->successResponse([
            'user' => $user,
            'permissions' => collect($user->getPermissionsStruct())
                ->only(collect(config('b2b.permissions_site'))->keys())
        ]);
    }

    public function usersDelete(Request $request, $user)
    {
        if (!$user = Auth::guard('api')->user()->organization->users()->find($user))
            return $this->errorResponse();

        if ($user->role == User::ROLE_CLIENT)
            return $this->errorResponse(['message' => 'Can\'t delete administrator user.']);

        $user->delete();

        return $this->successResponse();
    }

    public function usersStore(UserStoreRequest $request)
    {
        $user = OrganizationRepository::createOrganizationWorker(
            Auth::guard('api')->user()->organization,
            $request->user['name'],
            $request->user['password'],
            $request->user['email']
        );

        $userPermissions = $request->extractPermission();
        $user->syncPermissions($userPermissions);

        return $this->successResponse();
    }

    public function usersUpdate(UserUpdateRequest $request, $user)
    {
        if (!$user = Auth::guard('api')->user()->organization->users()->find($user))
            return $this->errorResponse();

        $updateUser = $request->user;

        if (isset($updateUser['password'])) {
            $updateUser['password'] = Hash::make($updateUser['password']);
        }

        $user->update(collect($updateUser)->only(['name', 'email', 'password'])->toArray());

        $userPermissions = $request->extractPermission();
        $user->syncPermissions($userPermissions);

        return $this->successResponse();
    }

    //  mvp-tamtem  new  --------Список складов компании  ---------------------------------------------------------
    public function stores()
    {
        return $this->successResponse(
            Auth::guard('api')->user()->organization->stores()->select(['id', 'address', 'geo_lat', 'geo_lon'])->get()
        );
    }

    //  mvp-tamtem  new  -------- Удаление склада компании  ---------------------------------------------------------
    public function storesDelete(Request $request, $store)
    {
        if (!$store = Auth::guard('api')->user()->organization->stores()->find($store))
            return $this->errorResponse();

        $store->delete();

        return $this->successResponse();
    }

    //  mvp-tamtem  new  -------- Создание склада компании  ---------------------------------------------------------
    public function storesStore(StoreStoreRequest $request)
    {
        $store = Auth::guard('api')->user()->organization->stores()->create($request->all());

        return $this->successResponse(['id' => $store->id]);
    }

    //  mvp-tamtem  new  -------- Список офисов компании  ---------------------------------------------------------
    public function offices()
    {
        return $this->successResponse(
            Auth::guard('api')->user()->organization->offices()->select(['id', 'phone', 'email', 'address', 'geo_lat', 'geo_lon'])->get()
        );
    }

    //  mvp-tamtem  new  -------- Создать офис компании  ---------------------------------------------------------
    public function officesStore(OfficeStoreRequest $request)
    {
        $office = Auth::guard('api')->user()->organization->offices()->create($request->all());
        return $this->successResponse(['id' => $office->id]);
    }

    public function officeView($id)
    {
        if (!$office = Auth::guard('api')->user()->organization->offices()->select(['id', 'phone', 'email', 'address', 'geo_lat', 'geo_lon'])->find($id)) {
            return $this->errorResponse();
        }

        return $this->successResponse(
            $office
        );
    }

    public function officesUpdate(OfficeStoreRequest $request, $office)
    {
        $office = Auth::guard('api')->user()->organization->offices()->find($office);

        $office->update(
            $request->all()
        );

        return $this->successResponse();
    }

    public function officesDelete(Request $request, $office)
    {
        if (!$office = Auth::guard('api')->user()->organization->offices()->find($office))
            return $this->errorResponse();

        $office->delete();

        return $this->successResponse();
    }



    //  mvp-tamtem  new  -------- Данные организации пользователя  ---------------------------------------------------------
    public function organization()
    {
        $organization = Auth::guard('api')->user()->organization()->with('categories', 'stores', 'offices', 'city.region.country')->first();
        return $this->successResponse(OrganizationItemFormatter::format($organization));
    }

  

    // public function categoriesEdit(OrganizationCategoriesEditRequest $request)
    // {
    //     $organization = Auth::guard('api')->user()->organization;
    //     $organization->categories()->sync($request->categories);

    //     return $this->successResponse();
    // }


    // mvp-tamtem  new  -------- Создание организации  ---------------------------------------------------------
    public function store(OrganizationStoreRequest $request)
    {    
        try{

            $update = collect($request->all())->only(collect($request->rules())->keys());
            if (empty($update)) {
                return $this->errorResponse('Ошибка входных данных');
            }

            $update = $update->toArray();

            $user = Auth::guard('api')->user();
            $organization = $user->organization;
            if(!$organization){
                $organization = $user->company()->create();
                $user->organization()->associate($organization);  // Этот метод обновит отношения belongsTo() и установит внешний ключ на дочерней модели, в частности owner_id = users.id
                $user->save();
                //return $this->errorResponse("Ошибка создания организации. Обраб");
            }
            $isUpdate =  $organization->update($update);
           
            if($isUpdate){

                // просинхроним категории организации
                $organization->categories()->sync($request->categories);
                
                // Upload files
                $isUploadedFiles = $organization->uploadFiles($request, config('b2b.images.resizeValMaxPx'));
                if($isUploadedFiles !== true){
                    return $this->errorResponse("Ошибка в загрузке изображений для организации " . __FUNCTION__);
                }

                // склады 
                $stores = isset( $update['stores']) ?  $update['stores'] : null;
                if($stores !== null and is_array($stores)){
                   
                    $storesToDB = null;
                    foreach($stores as $store){

                        if(!empty($store)){
                            $store = \json_decode($store, true);

                            if(!is_array($store))  $store = []; // фикс для валидатора, если иде не валиндная json строка

                            $validator = Validator::make($store, [
                                'address'   => 'required|max:191',      
                                'geo_lat'   => 'sometimes|max:9',
                                'geo_lon'   => 'sometimes|max:9',
                            ]);
                            if ($validator->fails()) {
                                return response()->json($validator->messages(), 200);
                            }

                            $storesToDB[] = $store;
                        }            
                    }
                    if(!empty($storesToDB)){
                        $organization->stores()->delete(); // на данный момент должны передаваться все склады, а значит перед этим можно почистить , если вдруг сдуру что есть
                        foreach ($storesToDB as $storeToDB) {
                            $organization->stores()->create($storeToDB);
                        }
                    }
                }

                // офисы 
                $offices = isset( $update['offices']) ?  $update['offices'] : null;

                if($offices !== null and is_array($offices)){
                   
                    $officesToDB = null;
                    foreach($offices as $office){
 
                        if(!empty($office)){
                            $office = \json_decode($office, true);
 
                            $validator = Validator::make($office, [
                                'address'   => 'required|max:191',      
                                'phone'     => 'sometimes|max:11|regex:/^[\d]+$/i',
                                'email'     => 'sometimes|email|max:191',
                                'geo_lat'   => 'sometimes|max:9',
                                'geo_lon'   => 'sometimes|max:9',
                            ]);
                            if ($validator->fails()) {
                                return response()->json($validator->messages(), 200);
                            }
 
                            $officesToDB[] = $office;
                        }            
                    }
                    if(!empty($officesToDB)){
                        $organization->offices()->delete(); // на данный момент должны передаваться все офисы, а значит перед этим можно почистить , если вдруг сдуру что есть
                        foreach ($officesToDB as $officeToDB) {
                            $organization->offices()->create($officeToDB);
                        }
                    }
                }

                $user->is_org_created = 1 ;
                $user->save();
    
                return $this->successResponse(['organization_id'=>$organization->id]);
            }
            else{
                return $this->errorResponse("Ошибка создания организации");
            }
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }


    // mvp-tamtem  new  -------- Редактирование организации  ---------------------------------------------------------
    public function update(OrganizationEditRequest $request)
    {
        try{

            $update = collect($request->all())->only(collect($request->rules())->keys());
            if (empty($update)) {
                return $this->errorResponse('Ошибка входных данных');
            }

            $update = $update->toArray();

            $user = Auth::guard('api')->user();
            $organization = $user->organization;

            $isUpdate =  $organization->update($update);

            // Upload files
            //$isUploadedFiles = $organization->uploadFiles($request);
            $isUploadedFiles = $this->storeImage($request, true);

            if($isUploadedFiles !== 'emptyRequestImageRow'){
                if($isUploadedFiles !== true){
                    return $this->errorResponse("Ошибка в загрузке изображений для организации update");
                }
            }


            if($isUpdate){

                // просинхроним категории организации
                $organization->categories()->sync($request->categories);

                return $this->successResponse($organization);
            }
            else{
                return $this->errorResponse("Ошибка обновления организации");
            }
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    
    // mvp-tamtem  new  -------- Удаление изображения у организации по его пути  ---------------------------------------------------------
    public function deleteImage(Request $request)
    {
        try{

            $organization = Auth::guard('api')->user()->organization;
            $path = $request->input('path', null);
            if($path === null){
                return $this->errorResponse("Вы не можете удалять фото с путем: " . $path);
            }
            $rowImage = $organization::select('image_1','image_2','image_3','logo')->
                                        where('image_1' , $path)->
                                        orWhere('image_2' , $path)->
                                        orWhere('image_3' , $path)->
                                        orWhere('logo' , $path)->first();
            if(!$rowImage ){
                return $this->errorResponse("Изображение не найдено, с путем: " . $path);
            }

            $rows = $rowImage->toArray();
            $rowName = array_search($path, $rows);

            if(!$this->deleteImageFromStore($path)){
                return $this->errorResponse("Ошибка удаления файла");
            }
            $organization->$rowName = null;
            $organization->save();

            return $this->successResponse();
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
		}

    }

     // mvp-tamtem  new  -------- Загрузка картинки для организации  ---------------------------------------------------------
     public function storeImage(Request $request, $isLocalRequest = false)
     {
         try{

            $images =  $request->only('logo', 'image_1','image_2','image_3');
     
            if(empty($images) ){
                if(!$isLocalRequest){
                    return $this->errorResponse("Ошибка в загрузке изображений для организации localRequest -> " . __FUNCTION__);
                }
                else{
                    return "emptyRequestImageRow";
                }
            }
            $organization = Auth::guard('api')->user()->organization;
          //  $images = $request->all();
            $max_size = (int)ini_get('upload_max_filesize') * 1000;
            $validator = Validator::make( $images, [
                'logo'              => 'sometimes|required|mimes:jpeg,bmp,png|max:' . $max_size,
                'image_1'           => 'sometimes|required|mimes:jpeg,bmp,png|max:' . $max_size,
                'image_2'           => 'sometimes|required|mimes:jpeg,bmp,png|max:' . $max_size,
                'image_3'           => 'sometimes|required|mimes:jpeg,bmp,png|max:' . $max_size,
              //  'video'             => 'sometimes|required|required|mimes:mp4|max:25600',     
            ]);
            if ($validator->fails()) {
                
                if(!$isLocalRequest){
                    return response()->json($validator->messages(), 200);
                }
                else{
                    return false;
                }
            }

            // удалим физически картинку
            foreach($images as $rowName =>$val){
                $curPathImage = $organization->$rowName;

                if($curPathImage !== null and file_exists( public_path($curPathImage))){
                    if(!$this->deleteImageFromStore($curPathImage)){
                        if(!$isLocalRequest){
                            return $this->errorResponse("Ошибка удаления файла");
                        }
                        else{
                            return false;
                        }        
                    }
                    $organization->$rowName = null;
                    $organization->save();
                }
            }

            // Upload files
            $isUploadedFiles = $organization->uploadFiles($request, config('b2b.images.resizeValMaxPx'));
            if($isUploadedFiles !== true){
                if(!$isLocalRequest){
                    return $this->errorResponse("Ошибка в загрузке изображений для организации " . __FUNCTION__);
                }
                else{
                    return false;
                }         
            }
 
            if(!$isLocalRequest){
                return $this->successResponse();
            }
            else{
                return true;
            }
            
         }
         catch(\Exception $e){
            if(!$isLocalRequest){
                return $this->errorResponse($e->getMessage());
            }
            else{
                return true;
            }
         }
 
     }
}
