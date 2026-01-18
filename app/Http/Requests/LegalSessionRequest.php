<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LegalSessionRequest extends FormRequest
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
            'legal_case_id' => 'required',
            'palce' => 'required',
            'time' => 'required',
            'status' => 'required',
            'date' => 'required',
            'note' => 'required',
        ];
    }
}
