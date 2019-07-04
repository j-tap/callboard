<?php

namespace App\Http\Requests\Client\Api\v1\Organization;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CategoriesRule;
use Auth;

class NewsStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Check for PATCH in news exists
        if ($this->route('news'))
            if (!Auth::guard('api')->user()->organization->news()->find($this->route('news')))
                throw new \App\Exceptions\NotFoundException();

        // Get URL
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
        if(!$news = $this->route('news')) $news = '0';
        return [
            'title' => 'required|min:10|max:255',
            'url' => [
                'required',
                'min:5',
                'max:255',
                'regex:/(^([a-zA-Z0-9\-]+)$)/u',
                'unique:news,url,'.$news,
            ],
            'description' => 'required|min:10',
            'categories' => ['required', 'array', new CategoriesRule()],
            'image_1' => 'sometimes|required|mimes:jpeg|dimensions:max_width=900,max_height=400|max:5120',
            'image_2' => 'sometimes|required|mimes:jpeg|dimensions:max_width=900,max_height=400|max:5120',
            'image_3' => 'sometimes|required|mimes:jpeg|dimensions:max_width=900,max_height=400|max:5120',
            'stock' => 'sometimes|boolean'
        ];
    }
}
