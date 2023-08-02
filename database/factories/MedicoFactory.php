<?php

namespace Database\Factories;

use App\Models\Cidade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medico>
 */
class MedicoFactory extends Factory
{
    protected array $especialidades = [
        "Acupuntura",
        "Alergia e Imunologia",
        "Anestesiologista",
        "Angiologia",
        "Cardiologia",
        "Cirurgia Cardiovascular",
        "Cirurgia da Mão",
        "Cirurgia de Cabeça e Pescoço",
        "Cirurgia do Aparelho Digestivo",
        "Cirurgia Geral",
        "Cirurgia Oncológica",
        "Cirurgia Pediátrica",
        "Cirurgia Plástica",
        "Cirurgia Torácica",
        "Cirurgia Vascular",
        "Clínica Médica",
        "Coloproctologia",
        "Dermatologia",
        "Endocrinologia e Metabologia",
        "Endoscopia",
        "Gastroenterologia",
        "Genética Médica",
        "Geriatria",
        "Ginecologia e Obstetrícia",
        "Hematologia e Hemoterapia",
        "Homeopatia", "Infectologia",
        "Mastologia",
        "Medicina de Emergência",
        "Medicina de Família e Comunidade",
        "Medicina do Trabalho",
        "Medicina de Tráfego",
        "Medicina Esportiva",
        "Medicina Física e Reabilitação",
        "Medicina Intensiva",
        "Medicina Legal e Perícia Médica",
        "Medicina Nuclear",
        "Medicina Preventiva e Social",
        "Nefrologia",
        "Neurocirurgia",
        "Neurologia",
        "Nutrologia",
        "Oftalmologia",
        "Oncologia Clínica",
        "Ortopedia e Traumatologia",
        "Otorrinolaringologia",
        "Patologia",
        "Patologia Clínica/Medicina Laboratorial",
        "Pediatria", "Pneumologia",
        "Psiquiatria",
        "Radiologia e Diagnóstico por Imagem",
        "Radioterapia",
        "Reumatologia",
        "Urologia"
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'especialidade' => fake()->randomElement($this->especialidades),
            'cidade_id' => Cidade::factory()
        ];
    }
}
