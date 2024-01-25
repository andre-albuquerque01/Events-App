<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            "name" => "required|min:3|max:255",
            "email" => [
                "required",
                "email",
                "max:255",
                "unique:users",
            ],
            "password" => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            "password_confirmation" => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            "cpf" => [
                "required",
                "min:11",
                "max:11",
                "unique",
            ],
        ];

        if ($this->method() == "PATCH" || $this->method() == "PUT") {
            $rules["email"] = [
                "required",
                "email",
                "max:255",
                "unique:users,email,{$this->id},id",
            ];
            $rules["password"] = [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ];
            $rules["cpf"] = "nullable|min:11|max:11";
        }
        return $rules;
    }
}
