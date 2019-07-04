<?php

namespace App\Http\Requests\Client\Api\v1\Deal;

use App\Rules\CategoriesRule;
use App\Rules\CitiesRule;
use App\Rules\QuestionsRule;
use Illuminate\Foundation\Http\FormRequest;
use \App\Models\Org\OrganizationDeal;

class DealStoreRequest extends FormRequest
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

   //  dd($this->all());//return var_dump();  
     
      	$rules = [
			//'image' =>  'sometimes|image|mimes:jpeg,png,jpg,gif',
			'type_deal' => 'required|in:' . OrganizationDeal::DEAL_TYPE_SELL . ','. OrganizationDeal::DEAL_TYPE_BUY,
			'subtype_deal' => 'required|in:' . OrganizationDeal::DEAL_SUBTYPE_USED . ','. OrganizationDeal::DEAL_SUBTYPE_NEW . ','. OrganizationDeal::DEAL_SUBTYPE_NA,
			'name' => 'required|min:2|max:190',
			'is_need_kp' => 'sometimes|boolean',
			//  'description' => 'sometimes|min:16|max:4000',
			//  'pay_type_cash' => 'sometimes|boolean',
			//  'pay_type_noncash' => 'sometimes|boolean',
			//  'budget_from' => 'required|lte:budget_to|integer', // todo удалить при чистке
			//  'budget_from' => 'sometimes|integer', // todo удалить при чистке
			// 'budget_to' => 'sometimes|integer',
			//  'fast_deal' => 'sometimes|boolean',
			//  'favorite_only' => 'sometimes|boolean',
			//  'deadline_deal' => 'required|date|date_format:"Y-m-d"|after:deadline_service',  // todo удалить при чистке
			//  'deadline_deal' => 'required|date|date_format:"Y-m-d"', 
			//  'deadline_service' => 'required|date|date_format:"Y-m-d"', // todo удалить при чистке
			//  'question' => 'sometimes|required|max:1024',
			'categories' => ['required', 'array', new CategoriesRule()],
			'cities' => ['required', 'array', new CitiesRule()],

			//   'categories.*' => ['required', new CategoriesRule()],
			//  'cities.*' => ['required',  new CitiesRule()],

			'images' => 'sometimes|array',
			// 'images.*' => ['sometimes', 'file', 'mimes:jpeg,bmp,png','max:' .  $max_size], // ],
			// 'questions' => ['required', 'sometimes', 'array', new QuestionsRule()], // todo удалить при чистке
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
    	// dd( $images);
    	if(is_array($images) and count($images) > 0){
        	// $images = count($images);
        	foreach($images  as $index => $val) {
            	if ($val !== null)
            		$rules['images.' . $index] = 'mimes:jpeg,bmp,png|max:' . $max_size; 
           	}
    	}

    	return $rules;
    }
}
