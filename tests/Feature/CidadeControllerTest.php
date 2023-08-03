<?php

namespace Tests\Feature;

use App\Models\Cidade;
use App\Models\Medico;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CidadeControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function testItListsAllAvailableCidades()
    {
        $cidades = Cidade::factory(10)->create();
        
        $this->json('get', route('api.cidades.index'))
            ->assertOk()
            ->assertJson(
                $cidades->map(function (Cidade $c) {
                    return [
                        'id' => $c->id,
                        'nome' => $c->nome,
                        'estado' => $c->estado,
                    ];
                })->toArray()
            )
            ->assertJsonCount(10);
    }
    
    public function testItListsAllMedicosForAGivenCidade()
    {
        $cidades = Cidade::factory(10)->has(Medico::factory(5))->create();
        
        $cidade = $cidades->first();
        
        $this->json('get', route('api.cidades.medicos', $cidade->id))
            ->assertOk()
            ->assertJson(
                $cidade->medicos->map(function (Medico $m) {
                    return [
                        'id' => $m->id,
                        'nome' => $m->nome,
                        'especialidade' => $m->especialidade,
                        'cidade' => $m->cidade->nome
                    ];
                })->toArray()
            )
            ->assertJsonCount(5);
    }
    
    public function testItReturnsStatusNotFoundIfRequestMedicosForANonExistantCidade()
    {
        $cidades = Cidade::factory(5)->has(Medico::factory(5))->create();
        
        $cidade_id = 6;
        
        $this->json('get', route('api.cidades.medicos', $cidade_id))
            ->assertNotFound();
    }
}
