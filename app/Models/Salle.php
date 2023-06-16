<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function seances()
    {
        return $this->hasMany(Seance::class, 'salle_id', 'id');
    }
}
