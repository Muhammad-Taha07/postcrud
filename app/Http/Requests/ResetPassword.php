<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ResetPassword extends FormRequest
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
        return
        [
            'email' => 'required|email',
        ];
    }

     /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return
        [
        'required' => 'Required fields cannot be left empty'
        ];
    }

    public function attributes()
    {
        return
        [
            'email' => 'Email Address'
        ];
    }

    /**
     * Response just in case of validation failed.
     *
     * @return array
     */

    public function failedValidation(Validator $valid)
    {
        $error = [
            "status" => 400,
            "success" => false,
            "error" => $valid->errors()->first()
        ];

        throw new HttpResponseException(response()->json($error, 400));
    }
}
