<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number' => 'required|unique:users,phone_number|max:255',
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'government_id' => 'required|integer',
            'city_id' => 'required|integer',
            'user_type' => 'required|string|in:provider,handyman',
        ];
    }

    public function messages()
    {
        return [
            'phone_number.unique' => 'The phone number is already taken.',
            'government_id.exists' => 'The selected government ID is invalid.',
            'city_id.exists' => 'The selected city ID is invalid.',
        ];
    }
}
