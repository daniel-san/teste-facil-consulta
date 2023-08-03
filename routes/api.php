<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CidadeController;
use App\Http\Controllers\Api\MedicoController;
use App\Http\Controllers\Api\PacienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.auth.register');

Route::prefix('/cidades')->group(function () {
    Route::get('/', [CidadeController::class, 'index'])->name('api.cidades.index');
    Route::get('/{id_cidade}/medicos', [CidadeController::class, 'medicos'])->name('api.cidades.medicos');
});

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('/medicos')->group(function () {
        Route::withoutMiddleware('auth:api')->get('/', [MedicoController::class, 'index'])->name('api.medicos.index');
        Route::post('/', [MedicoController::class, 'store'])->name('api.medicos.store');
        Route::get('/{id_medico}/pacientes', [MedicoController::class, 'pacientes'])->name('api.medicos.pacientes');
        Route::post('/{id_medico}/pacientes', [MedicoController::class, 'addPaciente'])->name('api.medicos.add.paciente');
    });

    Route::prefix('/pacientes')->group(function () {
        Route::post('/', [PacienteController::class, 'store'])->name('api.pacientes.store');
        Route::put('/{id_paciente}', [PacienteController::class, 'update'])->name('api.pacientes.update');
    });
});
