<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use app\Http\Controllers\AuthController;



class userSignUp extends FormRequest
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
            'name' => 'required|max:50',
            'email' => 'required|max:50|email|unique:users',
            'password'  => 'required|min:6|regex:/^(?!.* )(?=.*[a-z])(?=.*[A-Z]).*$/',
            'current_time' => 'required|date_format:Y-m-d H:i:s'
        ];
    }

    public function messages()
    {
        return
        [
            '*.required' => 'Required fields cannot be left empty',
            'email.email' => 'Please enter a valid email',
            'email.unique' => ':attribute should be unique',
            'password.regex' => 'Password length must contain atleast 6 character and must include following: Uppercase, Lowercase, Special character & numbers',
        ];
    }

    public function attributes()
    {
            return [
                'email' => 'Email Address',
            ];
    }

    public function failedValidation(Validator $validator)
    {
        $error = [
            "status" => 400,
            "success" => false,
            "error" =>  $validator->errors()->first()
        ];

        throw new HttpResponseException(response()->json($error, 400));
    }
}
