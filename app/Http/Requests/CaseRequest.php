<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseRequest extends FormRequest
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
            'client_id'         => 'required|exists:clients,id',
            'attribute'         => 'required|string|max:255',
            'subject'           => 'required|string|max:255',
            'case_type'         => 'required|in:ح,ش,د',
            'second_party_name' => 'nullable|string|max:255',
            'court'             => 'nullable|string|max:255',
            'department'        => 'nullable|string|max:255',
            'base_number'       => 'nullable|string|max:255',

        ];
    }
}
