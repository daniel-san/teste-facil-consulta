<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddPacienteToMedicoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'medico_id' => ['required', Rule::exists('medicos', 'id')->whereNull('deleted_at')],
            'paciente_id' => ['required', Rule::exists('pacientes', 'id')->whereNull('deleted_at')],
        ];
    }
}
