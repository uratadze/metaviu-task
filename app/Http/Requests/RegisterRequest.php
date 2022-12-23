<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'first_name' => 'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|max:30',
            'last_name' => 'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|max:30',
            'email' => 'required|email|max:30',
            'password' => 'required',
            'company_name' => 'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|max:50',
            'business_url' => 'url|max:50',
            'country_id' => 'required|integer',
            'address' => 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|max:100',
        ];
    }
}
