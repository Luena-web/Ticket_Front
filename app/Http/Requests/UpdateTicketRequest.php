<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTicketRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titre'=>'sometimes|required|string',
            'description'=>'sometimes|required|string',
            'priorite' => ['sometimes', 'required', Rule::in(['faible', 'moyenne', 'elevee'])],
            'statut' => ['sometimes', 'required', Rule::in(['non resolu', 'en cours', 'resolu'])],

        ];
    }
}