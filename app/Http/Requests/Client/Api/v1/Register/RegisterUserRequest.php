<?php

namespace App\Http\Requests\Client\Api\v1\Register;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
        return [
            'name' => 'required|min:1|max:190',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6|max:32',
            'phone'    => 'required|regex:/(^(\d+)$)/u|min:10|max:10',
			'license_agreement' => 'accepted',
			'message_possible' => 'required_with:false',
        ];
    }
}
