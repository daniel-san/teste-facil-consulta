<?php

namespace Tests\Feature;

use App\Models\Cidade;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class MedicoControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testItGetsAllMedicos()
    {
        $medicos = Medico::factory(10)
            ->has(Cidade::factory())
            ->create();

        $this->json('get', route('api.medicos.index'))
             ->assertOk()
             ->assertJson(
                 $medicos->map(function (Medico $medico) {
                    return [
                        'id' => $medico->id,
                        'nome' => $medico->nome,
                        'especialidade' => $medico->especialidade,
                        'cidade' => $medico->cidade->nome,
                    ];

                 })->toArray()
             )
             ->assertJsonCount($medicos->count());
    }

    public function testItRequiresAuthenticationForMedicosPacienteListing()
    {
        Cidade::factory(5)->has(
            Medico::factory(10)->has(
                Paciente::factory(3)
            )
        )->create();

        $medico = Medico::with('pacientes')->first();

        $this->json('get', route('api.medicos.pacientes', [$medico->id]))
             ->assertUnauthorized();
    }

    public function testItReturnsStatusNotFoundIfRequestingPacientesFromANonExistantMedico()
    {
        $this->user = Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        Cidade::factory(5)->has(
            Medico::factory(10)->has(
                Paciente::factory(3)
            )
        )->create();

        $medico_id = 200;

        $this->json('get', route('api.medicos.pacientes', [$medico_id]))
             ->assertNotFound();
    }

    public function testItGetsAllPacientesForAGivenMedicoWhenAuthenticated()
    {
        $this->user = Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        Cidade::factory(5)->has(
            Medico::factory(10)->has(
                Paciente::factory(3)
            )
        )->create();

        $medico = Medico::with('pacientes')->first();

        $this->json('get', route('api.medicos.pacientes', [$medico->id]))
             ->assertOk()
             ->assertJson(
                 $medico->pacientes->map(function (Paciente $paciente) {
                     return [
                        'id' => $paciente->id,
                        'nome' => $paciente->nome,
                        'cpf' => $paciente->cpf,
                        'celular' => $paciente->celular,
                    ];
                 })->toArray()
             )
             ->assertJsonCount($medico->pacientes->count());
    }

    public function testItRequiresAuthenticationToStoreNewMedico()
    {
        Cidade::factory(5)->create();
        $cidade = Cidade::first();
        $medico = Medico::factory()->raw(['nome', 'especialidade']);
        $medico['cidade_id'] = $cidade->id;

        $this->json('post', route('api.medicos.store'), $medico)
             ->assertUnauthorized();

        $this->assertDatabaseCount('medicos', 0);
    }

    public function testItStoresANewMedicoInTheDatabaseWhenAuthenticated()
    {
        $this->user = Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        Cidade::factory(5)->create();
        $cidade = Cidade::first();
        $medico = Medico::factory()->raw(['nome', 'especialidade']);
        $medico['cidade_id'] = $cidade->id;

        $this->json('post', route('api.medicos.store'), $medico)
             ->assertStatus(201)
             ->assertJson([
                 'nome' => $medico['nome'],
                 'especialidade' => $medico['especialidade'],
                 'cidade' => $cidade->nome
             ]);

        $this->assertDatabaseCount('medicos', 1);
    }

    public function testItRequiresAuthenticationToAddPacienteToMedico()
    {
        $medico = Medico::factory()->has(Cidade::factory())->create();
        $paciente = Paciente::factory()->create();

        $this->json('post', route('api.medicos.add.paciente', $medico->id), ['medico_id' => $medico->id, 'paciente_id' => $paciente->id])
              ->assertUnauthorized();

        $this->assertDatabaseCount('medico_paciente', 0);
    }

    public function testItAddsAPacienteToAMedicoWhenAuthenticated()
    {
        $this->user = Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $medico = Medico::factory()->has(Cidade::factory())->create();
        $paciente = Paciente::factory()->create();

         $this->json('post', route('api.medicos.add.paciente', $medico->id), ['medico_id' => $medico->id, 'paciente_id' => $paciente->id])
              ->assertOk()
              ->assertJson([
                  'nome' => $medico->nome,
                  'especialidade' => $medico->especialidade,
                  'cidade' => $medico->cidade->nome,
                  'paciente' => [
                      'nome' => $paciente->nome,
                      'cpf' => $paciente->cpf,
                      'celular' => $paciente->celular
                  ]
              ]);

        $this->assertDatabaseCount('medico_paciente', 1);
    }
}
