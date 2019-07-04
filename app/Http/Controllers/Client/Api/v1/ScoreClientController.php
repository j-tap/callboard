<?php

namespace App\Http\Controllers\Client\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Org\OrganizationDeal;
use App\Traits\ApiControllerTrait;
use Illuminate\Support\Facades\Auth;

class ScoreClientController extends Controller
{
    use ApiControllerTrait;

    public function generateScoreClient (Request $request) {

        if($request->params['summ']==null){
                return $this->errorResponse('Введите сумму платежа');
        }else{
            $unique_id = $request->params['unique_id'];
            $summ = number_format($request->params['summ'], 2, '.', '');
            $user = Auth::guard('api')->user();
            $modelOrgDeal=new OrganizationDeal();
            $fileName=$modelOrgDeal->score($unique_id, $summ, $user);
            return response()->json(['result' => true, 'link' => '/' . $fileName]);
        }


    }
}
