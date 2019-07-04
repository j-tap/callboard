<?php

namespace App\Http\Requests\Client\Api\v1;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'deal_id' => 'sometimes|required|exists:organizations_deals,id,deleted_at,NULL',
            'news_id' => 'sometimes|required|exists:news,id',
            'org_id' => 'sometimes|required|exists:organizations,id,deleted_at,NULL',
            'message_id' => 'sometimes|required|exists:messages,id',
            'theme' => 'required|min:6|max:255',
            'description' => 'required|min:6|max:2048',
        ];
    }
}
