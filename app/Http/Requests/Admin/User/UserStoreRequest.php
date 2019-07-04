<?php

namespace App\Http\Requests\Admin\User;

use App\Traits\PermissionsRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    use PermissionsRequestTrait;

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
            'user.name' => 'required|min:5|max:32',
            'user.email' => 'required|email|unique:users,email',
            'user.password' => 'required|min:6|max:32',
            'user.role' => 'in:administrator,moderator,client,client_worker|required',
            'user.status' => 'in:register,approve,archive|required'
        ];
    }
}
