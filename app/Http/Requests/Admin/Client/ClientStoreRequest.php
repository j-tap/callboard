<?php

namespace App\Http\Requests\Admin\Client;

use App\Models\Org\Organization;
use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $userName = trim($this->input('organization.first_name', '')
            . ' ' . $this->input('organization.second_name', '')
            . ' ' . $this->input('organization.middle_name', ''));

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
            'user.email' => 'required|email|unique:users,email',
            'user.password' => 'required|min:6|max:32',

            'organization.org_type' => 'required|in:' . Organization::ORG_TYPE_BUYER . ',' . Organization::ORG_TYPE_SELLER,

            'organization.first_name' => 'required|max:32',
            'organization.second_name' => 'required|max:32',
            'organization.middle_name' => 'required|max:32',
            'organization.phone' => 'required|max:11|regex:/(8)[0-9]{9}/',
            'organization.org_city_id' => 'required|exists:cities,id',
            'organization.org_name' => 'required|max:255',
            'organization.org_inn' => 'required|max:12|unique:organizations,org_inn',
            'organization.org_description' => 'max:5000',
        ];

        $rulesSeller = [
            'organization.org_address' => 'required|max:255',
            'organization.org_address_legal' => 'required|max:255',
            'organization.org_legal_form_id' => 'required|exists:organizations_legal_forms,id',
            'organization.org_director' => 'required|max:255',
            'organization.org_site' => 'required|url',
        ];

        if ($this->request->get('organization', ['org_type' => 'buyer'])['org_type'] == Organization::ORG_TYPE_SELLER)
            $rules = array_merge($rules, $rulesSeller);

        return $rules;
    }
}
