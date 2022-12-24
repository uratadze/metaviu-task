<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;
use Illuminate\Http\JsonResponse;

class AuthorisationRequest extends FormRequest
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
            'email' => 'required|email|max:30',
            'password' => 'required',
        ];
    }
}
