<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserHasEventRequest extends FormRequest
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
            "idUser" => "required",
            "idEvents" => "required",
            "valuePay" => "nullable",
            "qtdTicket" => "required|min:1|max:10",
            "statusPay" => "required",
            "numberPix" => "required",
            "pathNameFile" => "required",
        ];

        if ($this->method() == "PATCH" || $this->method() == "PUT") {
            $rules["idUser"] = "nullable";
            $rules["idEvents"] = "nullable";
            $rules["qtdTicket"] = "nullable";
            $rules["statusPay"] = "nullable";
            $rules["numberPix"] = "nullable";
            $rules["pathNameFile"] = "nullable";
        }
        return $rules;
    }
}
