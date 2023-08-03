<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable =  [
        'nome',
        'cpf',
        'celular',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function medicos(): BelongsToMany
    {
        return $this->belongsToMany(Medico::class)
                    ->using(MedicoPaciente::class)
                    ->withTimestamps();
    }
}
