<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserVerification extends FormRequest
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
            'email' => 'required|email',
            'verification_code' => 'required|min:4'
        ];
    }

    public function messages()
    {
        return[
        'email.required' => 'Required fields cannot be left empty',
        'verification_code.required' => 'Required fields cannot be left empty'
        ];
    }

    public function attributes()
    {
        return[
            'email' => 'Email Address',
            'verification_code' => 'Verification Code'
        ];
    }

    public function failedValidation(Validator $validation)
    {
        return response()->json([
            'success' => false,
            'status'  => 400,
            'message' => "User Validation Failed"
        ],400);
    }

}
