<?php

namespace App\Http\Requests\Admin;

use App\Rules\CategoriesRule;
use Illuminate\Foundation\Http\FormRequest;

class NewsCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $url = $this->get('url', null);
        if (!$url) {
            $url = str_slug($this->title);
            $this->merge([
                'url' => $url,
            ]);
        }

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
            'title' => 'required|min:10|max:255',
            'url' => [
                'required',
                'min:5',
                'max:255',
                'regex:/(^([a-zA-Z0-9\-]+)$)/u',
                'unique:news,url,'.$this->request->get('id', '0'),
            ],
            'status' => 'sometimes|required|in:edit,approve,canceled',
            'description' => 'required|min:10',
            'categories' => ['required', 'array', new CategoriesRule()],
            'stock' => 'sometimes|boolean'
        ];
    }
}
