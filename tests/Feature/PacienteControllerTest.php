<?php

namespace Tests\Feature;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PacienteControllerTest extends TestCase
{
    use RefreshDatabase;
    
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
    }
    
    public function testItRequiresAuthenticationToStoreNewPaciente()
    {
        $paciente = Paciente::factory()->raw(['nome', 'cpf', 'celular']);

        $this->json('post', route('api.pacientes.store'), $paciente)
            ->assertUnauthorized();

        $this->assertDatabaseCount('pacientes', 0);
    }
    
    public function testItStoresANewPacienteInTheDatabaseWhenAuthenticated()
    {
        $this->user = Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );
        
        $paciente = Paciente::factory()->raw(['nome', 'cpf', 'celular']);
        
        $this->assertDatabaseCount('pacientes', 0);
        
        $this->json('post', route('api.pacientes.store'), $paciente)
            ->assertStatus(201)
            ->assertJson([
                'nome' => $paciente['nome'],
                'cpf' => $paciente['cpf'],
                'celular' => $paciente['celular']
            ]);
        
        $this->assertDatabaseCount('pacientes', 1);
    }
    
    public function testItRequiresAuthenticationToUpdateAPaciente()
    {
        $paciente = Paciente::factory()->create();
        
        $this->json('put', route('api.pacientes.update', $paciente->id), ['nome' => 'New nome', 'celular' => '(11) 9 8432-5789'])
            ->assertUnauthorized();
    }
    
    public function testItReturnsStatusNotFoundIfTryingToUpdateNonExistantPaciente()
    {
        $this->user = Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );
        
        $paciente_id = 1;
        
        $this->json('put', route('api.pacientes.update', $paciente_id), ['nome' => 'new nome', 'celular' => '(11) 9 8432-5789'])
            ->assertNotFound();
    }
    
    public function testItUpdatesAPacienteInTheDatabaseWhenAuthenticated()
    {
        $this->user = Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );
        
        $paciente = Paciente::factory()->create();

        $this->assertDatabaseCount('pacientes', 1);

        $this->json('put', route('api.pacientes.update', $paciente->id), ['nome' => 'new nome', 'celular' => '(11) 9 8432-5789'])
            ->assertOk()
            ->assertJson([
                'nome' => 'new nome',
                'cpf' => $paciente->cpf,
                'celular' => '(11) 9 8432-5789'
            ]);

        $this->assertDatabaseCount('pacientes', 1);
    }
}
