<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'title' => 'required|min:1|max:191',
            'description' => 'required|min:1|max:300',
            'category' => 'required|numeric',
            'price' => 'required|numeric',
            // 'images' => 'required|mimes:png,jpg,jpeg'
        ];
    }
}
