<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class History extends BaseModel
{
    use HasFactory;

    protected $table = "history";

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
