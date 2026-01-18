<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LawyerRequest extends FormRequest
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
            'email' => 'required',
            'firstName' => 'required',
            'seconedName' => 'required',
            'Nickname' => 'required',
            'phone' => 'required',
            'PlaceBirth' => 'required',
            'birthDate' => 'required',
            'secretariat' => 'required',
        ];
    }
}
