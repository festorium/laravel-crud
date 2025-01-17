<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            "first_name" => "required|string|max:255",
            "last_name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users",
            "password" => "required|string|confirmed|min:8",
            "phone" => "nullable|string|max:20", // Assuming phone number is optional and has a max length
            "address" => "nullable|string|max:255",
            "state" => "nullable|string|max:255",
            "country" => "nullable|string|max:255",
            "username" => "nullable|string|unique:users", // If username is unique
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'Passwords do not match.',
            'username.unique' => 'This username is already taken.', 
        ];
    }
}
