<?php

namespace App\Models;

use App\Models\Relations\HasManyMedicos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cidade extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasManyMedicos;
}
