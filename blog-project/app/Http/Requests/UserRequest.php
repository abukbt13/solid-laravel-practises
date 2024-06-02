<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            "name" => "required|string|min:3|max:20",
            "email" => "required|string|email|min:5|max:30|unique:users",
            "password" => [
                "required",
                "string",
                "min:6",
                "max:16",
                "regex:/^[A-Za-z0-9 ,%*)(_+@!&]+$/"
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json([
            'message' => 'Validation Failed',
            'errors' => $errors
        ], 422));
    }
}
