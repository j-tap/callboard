<?php

namespace App\Http\Requests\Admin\Client;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreUserRequest extends FormRequest
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
            'user.email' => 'required|email|unique:users,email',
            'user.name' => 'required|min:2|max:32' //сделал минимум 2 символа (в каком то из Request минимум 5 то есть человек и именем Ян пролетает) :).
        ];
    }
}
