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

    public static function log($data)
    {
        $model = new self;
        $model->name = $data['name']; 
        $model->nilai = $data['nilai']; 
        $model->tipe = $data['tipe']; 
        $model->keterangan = $data['keterangan']; 
        $model->updated_by = $data['updated_by'];
        return $model->save();
    }
}
