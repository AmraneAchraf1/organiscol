<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormateurRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "nom"=>"required|string",
            "prenom"=>"required|string",
            "type"=>"required|in:vacataire,permanent",
            "date_formation"=>"sometimes|date",
            "filieres_ids"=>"sometimes|string",
        ];
    }
}
