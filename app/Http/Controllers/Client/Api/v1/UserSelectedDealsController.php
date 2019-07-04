<?php

namespace App\Http\Controllers\Client\Api\v1;


use Illuminate\Http\Request;

use App\Traits\ApiControllerTrait;
use App\Http\Controllers\Controller;
use App\Formatter\Api\v1\DealsItemFormatter;
use Auth;
use Validator;

class UserSelectedDealsController extends Controller
{
    use ApiControllerTrait;

    
	// mvp tamtem
	// показатьвсе избранные сделки юзера  ===============================================================================
    public function favourites()
    {
        try{

            $user = Auth::guard('api')->user();

            return $this->successResponse(
                DealsItemFormatter::formatPaginator(
                        $user->favourites()
                        ->with(['organization', 'categories', 'cities', 'imagesDeals', 'user'])
                        ->simplePaginate(15)
                )
            );
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

	// mvp tamtem
	// добавть сделку в избранное  ===============================================================================
    public function store(Request $request)
    {
        try{

            $input = $request->all();

            $validator = Validator::make($input, [
                'deal_id'   => 'required|exists:organizations_deals,id',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->messages(), 200);
            }

            $user = Auth::guard('api')->user();

            // чтобы сделка не моя была, тогда в избранное
            if($user->deals()->where('id', '=' ,  $input['deal_id'])->get()->toArray()){
                return $this->errorResponse('Вы не можете добавлять в избранное свою же сделку');
            }

            if (!$user->favourites()->find($input['deal_id'])) {
                $ret = $user->favourites()->attach($input['deal_id']);
            }

            return $this->successResponse();
        }
        catch(\Exception $e){
             return $this->errorResponse($e->getMessage());
        }
     
    }

    public function delete(Request $request)
    {

        try{

            $input = $request->all();

            $validator = Validator::make($input, [
                'deal_id'   => 'required|exists:organizations_deals,id',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->messages(), 200);
            }

            $user = Auth::guard('api')->user();

            // чтобы сделка не моя была
            if($user->deals()->where('id', '=' ,  $input['deal_id'])->get()->toArray()){
                return $this->errorResponse('Вы не можете удалить из своего избранного свою же сделку');
            }
    
            if ($user->favourites()->find($input['deal_id'])) {
                $user->favourites()->detach($input['deal_id']);
            }
    
            return $this->successResponse();
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }

    }

}
