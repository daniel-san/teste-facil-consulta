<?php

namespace App\Models\Relations;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToPaciente
{
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }
}
