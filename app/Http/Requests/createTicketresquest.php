<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class createTicketresquest extends FormRequest
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
            'titre'=>'required|string|max:255',
            'description'=>'required|string|max:255',
            'priorite'=>['required', Rule::in(['faible', 'moyenne', 'elevee'])],
           'utilisateur_id' => 'sometimes|integer|exists:utilisateurs,id',        
];
    }
    public function messages(): array{
        return [
            'titre.required'=>'Le titre est obligatoire',
            'titre.max'=>'Le titre ne doit dépasser une longueur de 255 caractères ',
            'titre.string'=>'Le titre doit être une chaîne de caractères',
            'description.required'=>'La description est obligatoire',
            'description.string'=>'La description doit être une chaîne de caractères',
            'description.max'=>'La description ne doit dépasser une longueur de 255 caractères ',
            'priorite.required'=>'La priorité est requise',



        ];

    }
}
