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

    public function medicos(): BelongsToMany
    {
        return $this->belongsToMany(Medico::class)
                    ->using(MedicoPaciente::class)
                    ->withTimestamps();
    }
}
