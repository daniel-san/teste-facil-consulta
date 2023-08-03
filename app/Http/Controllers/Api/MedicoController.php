<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPacienteToMedicoRequest;
use App\Http\Requests\StoreMedicoRequest;
use App\Http\Resources\MedicoResource;
use App\Http\Resources\PacienteResource;
use App\Models\Cidade;
use App\Models\Medico;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        MedicoResource::withoutWrapping();

        return MedicoResource::collection(Medico::get());
    }

    public function pacientes(Request $request)
    {
        $id = $request->route('id_medico');

        try {
            $medico = Medico::with('pacientes')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'medico não encontrado'
            ]);
        }

        PacienteResource::withoutWrapping();
        return PacienteResource::collection($medico->pacientes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicoRequest $request)
    {
        $medico = (new Medico())->fill($request->validated());

        $cidade = Cidade::find($request->validated('cidade_id'));

        $medico->cidade()->associate($cidade)->save();

        MedicoResource::withoutWrapping();
        return new MedicoResource($medico);
    }

    public function addPaciente(AddPacienteToMedicoRequest $request)
    {
        $medico = Medico::find($request->validated('medico_id'));
        $paciente = Paciente::find($request->validated('paciente_id'));

        $medico->pacientes()->save($paciente);

        MedicoResource::withoutWrapping();
        $resource = new MedicoResource($medico);
        $resource->newPaciente = $paciente;

        return $resource;
    }

}
