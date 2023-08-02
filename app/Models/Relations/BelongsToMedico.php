<?php

namespace App\Models\Relations;

use App\Models\Medico;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToMedico
{
    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class);
    }
}
