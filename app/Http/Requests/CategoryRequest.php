<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $id = request()->id;
        return [
            'name'              => 'required|unique:categories,name,'.$id,
            'image'             => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'zones'             => 'required',
            'commission' => 'nullable|numeric|min:0|max:100',
            'status'            => 'required',
        ];
    }
}
