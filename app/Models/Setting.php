<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends BaseModel
{
    use HasFactory;

    protected $table = "setting";

    public function scopeBpjs($query)
    {
        return $query->where('nama', '=', 'bpjs');
    }

    public function scopeJamlembur($query)
    {
        return $query->where('nama', '=', 'jam-lembur');
    }
}
