<?php

namespace App\Models;

use App\Models\Relations\BelongsToCidade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medico extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BelongsToCidade;

    protected $fillable = [
        'nome',
        'especialidade'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function pacientes(): BelongsToMany
    {
        return $this->belongsToMany(Paciente::class)
                    ->using(MedicoPaciente::class)
                    ->withTimestamps();
    }
}
