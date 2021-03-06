<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'categoryname'=>'required|min:1|max:191|unique:categories,name,NULL,id,deleted_at,NULL',
            'image'=>'required|mimes:png,jpg,jpeg'
        ];
    }
}
