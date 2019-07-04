<?php

namespace App\Http\Requests\Admin\Client;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Org\Organization;

class ClientUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $userName = trim($this->input('first_name', '')
            . ' ' . $this->input('second_name', '')
            . ' ' . $this->input('middle_name', ''));

        $this->merge(['user_name' => $userName]);

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
            'org_type' => 'required|in:' . Organization::ORG_TYPE_BUYER . ',' . Organization::ORG_TYPE_SELLER,

            'first_name' => 'required|max:32',
            'second_name' => 'required|max:32',
            'middle_name' => 'required|max:32',
            'phone' => 'required|max:11|regex:/(8)[0-9]{9}/',
            'org_city_id' => 'required|exists:cities,id',
            'org_name' => 'required|max:255',
            'org_inn' => 'required|max:12|unique:organizations,org_inn,'.$this->request->get('id', '0'),
            'org_description' => 'max:5000',
        ];


        $rulesSeller = [
            'org_address' => 'required|max:255',
            'org_address_legal' => 'required|max:255',
            'org_legal_form_id' => 'required|exists:organizations_legal_forms,id',
            'org_director' => 'required|max:255',
            'org_site' => 'required|sometimes|url',
        ];

        if ($this->request->get('org_type', '') == Organization::ORG_TYPE_SELLER)
            $rules = array_merge($rules, $rulesSeller);

        return $rules;
    }
}
