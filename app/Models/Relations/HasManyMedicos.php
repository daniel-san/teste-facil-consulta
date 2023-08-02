<?php

namespace App\Models\Relations;

use App\Models\Medico;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyMedicos
{
    public function medicos(): HasMany
    {
        return $this->hasMany(Medico::class);
    }
}
