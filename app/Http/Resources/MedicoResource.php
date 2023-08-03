<?php

namespace App\Http\Resources;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicoResource extends JsonResource
{
    public ?Paciente $newPaciente = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'especialidade' => $this->especialidade,
            'cidade' => $this->cidade->nome,
            'pacientes' => PacienteResource::collection($this->whenLoaded('pacientes')),
            'paciente' => $this->when($this->newPaciente, new PacienteResource($this->newPaciente)),
        ];
    }
}
