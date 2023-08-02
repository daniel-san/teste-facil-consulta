<?php

namespace App\Models;

use App\Models\Relations\BelongsToMedico;
use App\Models\Relations\BelongsToPaciente;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicoPaciente extends Pivot
{
    use SoftDeletes;
    use BelongsToMedico;
    use BelongsToPaciente;
}
