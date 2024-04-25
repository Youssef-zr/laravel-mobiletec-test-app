<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
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
        return [
            "titre" => 'required|max:255|min:5|unique:news,titre',
            "contenu" => 'required|min:10|max:500',
            "categorie" => 'required|numeric',
            "date_debut" => 'required|date|date_format:Y-m-d H:i:s',
            "date_expiration" => 'required|date|date_format:Y-m-d H:i:s|after:date_debut',
        ];
    }

    public function attributes()
    {
        return [
            'titre' => 'title',
            'contenu' => 'content',
            'categorie' => 'category',
            'date_debut' => 'start date',
            'date_expiration' => 'end date',
        ];
    }
}
