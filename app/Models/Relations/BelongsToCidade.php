<?php

namespace App\Models\Relations;

use App\Models\Cidade;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToCidade
{
    public function cidade(): BelongsTo
    {
        return $this->belongsTo(Cidade::class);
    }
}
