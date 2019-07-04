<?php

namespace App\Http\Requests\Client\Api\v1\Register;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Org\Organization;

class RegisterCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $userName = trim($this->input('organization.second_name', '')
            . ' ' . $this->input('organization.first_name', '')
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
        return [
            'license_agreement' => 'required|present',

            'user_name' => 'required|min:5|max:190',
            'user.email' => 'required|email|unique:users,email',
            'user.password' => 'required|confirmed:user.password_confirmation|min:6|max:32',
            //'user.password_confirmation' => 'confirmed:user.password',

            'organization.org_type' => 'required|in:buyer',

            'organization.first_name' => 'required|max:32',
            'organization.second_name' => 'required|max:32',
            'organization.middle_name' => 'required|max:32',
            'organization.phone' => 'required|max:11|regex:/(8)[0-9]{9}/',
            'organization.org_city_id' => 'required|exists:cities,id',
            'organization.org_name' => 'required|max:255',
            'organization.org_inn' => 'required|max:12|unique:organizations,org_inn',
        ];
    }
}
