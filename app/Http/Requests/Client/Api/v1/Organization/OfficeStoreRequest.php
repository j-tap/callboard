<?php

namespace App\Http\Requests\Client\Api\v1\Organization;

use Illuminate\Foundation\Http\FormRequest;

class OfficeStoreRequest extends FormRequest
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
            'address' => 'required|max:191',
            'phone'=> 'sometimes|max:11',
            'email' => 'sometimes|email|max:255',
            'geo_lat' => 'sometimes|required|max:9|regex:/[0-9]+.[0-9]+/i',
            'geo_lon' => 'sometimes|required|max:9|regex:/[0-9]+.[0-9]+/i',
        ];
    }
}
