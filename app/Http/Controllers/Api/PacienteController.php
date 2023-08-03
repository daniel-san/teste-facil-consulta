<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePacienteRequest;
use App\Http\Requests\UpdatePacienteRequest;
use App\Http\Resources\PacienteResource;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PacienteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePacienteRequest $request)
    {
        $paciente = (new Paciente())->fill($request->validated());
        $paciente->save();

        PacienteResource::withoutWrapping();
        return new PacienteResource($paciente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePacienteRequest $request)
    {
        try {
            $paciente = Paciente::findOrFail($request->route('id_paciente'));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => __('messages.paciente.notfound')
            ], 404);
        }

        $paciente->fill($request->validated());
        $paciente->save();

        PacienteResource::withoutWrapping();
        return new PacienteResource($paciente);
    }
}
