<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CidadeResource;
use App\Http\Resources\MedicoResource;
use App\Models\Cidade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        CidadeResource::withoutWrapping();

        return CidadeResource::collection(Cidade::get());
    }

    public function medicos(Request $request)
    {
        $id = $request->route('id_cidade');

        try {
            $cidade = Cidade::with('medicos')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => __('messages.cidade.notfound')
            ], 404);
        }

        MedicoResource::withoutWrapping();
        return MedicoResource::collection($cidade->medicos);
    }
}
