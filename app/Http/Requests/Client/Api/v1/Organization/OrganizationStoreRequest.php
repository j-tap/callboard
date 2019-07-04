<?php

namespace App\Http\Requests\Client\Api\v1\Organization;

use App\Rules\WorkTimeRule;
use App\Rules\CategoriesRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Org\Organization;

class OrganizationStoreRequest extends FormRequest 
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
        $max_size = (int)ini_get('upload_max_filesize') * 1000;

        $rules = [
           // 'logo' => 'sometimes|required|mimes:png|dimensions:max_width=200,max_height=200|max:1024',
            'first_name'        => 'sometimes|required|max:64',
            'second_name'       => 'sometimes|required|max:64',
            'middle_name'       => 'sometimes|required|max:64',
            'phone'             => 'required|regex:/(^(\d+)$)/u|min:10|max:10',
            'org_city_id'       => 'required|exists:cities,id',
            'org_name'          => 'required|max:255',
            //'org_inn'           => 'required|min:10|max:12|unique:organizations,org_inn,'.$this->request->get('id', '0'),
            'org_inn'           => 'required|min:10|max:12|unique:organizations,org_inn',
            'org_kpp'           => 'sometimes|required|min:9|max:9',
            'org_address'       => 'sometimes|required|max:191',
            'org_address_legal' => 'sometimes|required|max:191',
            'org_legal_form_id' => 'sometimes|required|exists:organizations_legal_forms,id',
            'org_director'      => 'sometimes|required|max:64',
            'org_site'          => 'sometimes|required|url|max:64',
            'org_products'      => 'sometimes|required|max:280', // описание товаров и услуг
            'org_description'   => 'sometimes|required|max:1000', // краткое описание организации, в БД поле = 5000 !!! WTF ?
            'org_work_time'     => ['sometimes', 'array', new WorkTimeRule()],
            'logo'              => 'sometimes|required|mimes:jpeg,bmp,png|max:' . $max_size,
            'image_1'           => 'sometimes|required|mimes:jpeg,bmp,png|max:' . $max_size,
            'image_2'           => 'sometimes|required|mimes:jpeg,bmp,png|max:' . $max_size,
            'image_3'           => 'sometimes|required|mimes:jpeg,bmp,png|max:' . $max_size,
            'video'             => 'sometimes|required|required|mimes:mp4|max:25600',     
            'categories'        => ['required', 'array', new CategoriesRule()],    

            'stores'            => 'sometimes|required|array',
            'offices'            => 'sometimes|required|array',        
        ];



        //склады 
        $stores = $this->input('stores');
        if(is_array($stores) and count($stores) >0) {
            foreach($stores  as $index => $val) {
                if ($val !== null)
                    $rules['stores.' . $index] = 'required|json'; 
            }
        }

        // офисы 
        $offices = $this->input('offices');
        if(is_array($offices) and count($offices) >0) {
            foreach($offices  as $index => $val) {
                if ($val !== null)
                    $rules['offices.' . $index] = 'required|json'; 
            }
        }
        return $rules;
    }}
