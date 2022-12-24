<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;
use Illuminate\Http\JsonResponse;

class RegisterRequest extends FormRequest
{
    /**
     * Error message response.
     *
     * @return JsonResponse|null
     */
    protected function errorResponse(): ?JsonResponse
    {
        return responder()
            ->error($this->statusCode(), $this->errorMessage())
            ->data(['params' => $this->validator->errors()->messages()])
            ->respond($this->statusCode());
    }

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
            'email' => 'required|email|max:30|unique:users',
            'password' => 'required',
            'company_name' => 'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|max:50',
            'business_url' => 'url|max:50',
            'country_id' => 'required|integer|exists:countries,id',
            'address' => 'string|max:100',
        ];
    }
}
