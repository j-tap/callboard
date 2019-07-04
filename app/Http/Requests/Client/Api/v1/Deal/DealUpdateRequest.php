<?php

namespace App\Http\Requests\Client\Api\v1\Deal;

use App\Rules\CategoriesRule;
use App\Rules\CitiesRule;
use App\Rules\QuestionsRule;
use Illuminate\Foundation\Http\FormRequest;
use \App\Models\Org\OrganizationDeal;

class DealUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
    
      	$rules = [
		//	'id' =>  'required|integer|exists:organizations_deals,id',
			'type_deal' => 'required|in:' . OrganizationDeal::DEAL_TYPE_SELL . ','. OrganizationDeal::DEAL_TYPE_BUY,
			'subtype_deal' => 'required|in:' . OrganizationDeal::DEAL_SUBTYPE_USED . ','. OrganizationDeal::DEAL_SUBTYPE_NEW . ','. OrganizationDeal::DEAL_SUBTYPE_NA,
			'name' => 'sometimes|min:6|max:190',
			'is_need_kp' => 'sometimes|boolean',
			'categories' => ['required', 'array', new CategoriesRule()],
			'cities' => ['required', 'array', new CitiesRule()],
			'images' => 'sometimes|array',
      	];

		if ($this->type_deal === OrganizationDeal::DEAL_TYPE_SELL){ // Цена обязательна только если продажа
			  $rules['budget_to'] = 'required|integer';
		}
		elseif($this->type_deal === OrganizationDeal::DEAL_TYPE_BUY){// Цены не обязательны только если куплю
			
			if($this->input('budget_from') !== null and $this->input('budget_to') !== null ){
				$rules['budget_from'] 	= 'sometimes|lte:budget_to|integer';
				$rules['budget_to'] 	= 'sometimes|integer';
			}
			else{
				$rules['budget_from'] 	= 'sometimes|integer';
				$rules['budget_to'] 	= 'sometimes|integer';
			}
		}

    	$max_size = (int)ini_get('upload_max_filesize') * 1000;
    	$images = $this->input('images');

    	if(is_array($images) and count($images) > 0){
        	foreach($images  as $index => $val) {
            	if ($val !== null)
            		$rules['images.' . $index] = 'mimes:jpeg,bmp,png|max:' . $max_size; 
           	}
    	}

    	return $rules;
    }
}
