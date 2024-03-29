<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventsRequest extends FormRequest
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
            "title" => "required|min:3|max:255",
            "description" => "required|min:2|max:255",
            "price" => "required",
            "qtdParcelamento" => "required",
            "department" => "required|min:2|max:255",
            "occupation" => "required|min:1|max:255",
            "dateEvent" => "required",
            "timeEvent" => "required",
            "pathName" => "required",
        ];
        
        if ($this->method() == "PATCH" || $this->method() == "PUT") {
            $rules["title"] = "nullable|min:1|max:255";
            $rules["description"] = "nullable|min:1|max:255";
            $rules["price"] = "nullable";
            $rules["department"] = "nullable|min:1|max:255";
            $rules["occupation"] = "nullable|min:1|max:255";
            $rules["statusEvent"] = "nullable";
            $rules["dateEvent"] = "nullable|date";
            $rules["pathName"] = "nullable";
        }
        return $rules;
    }
}
