<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'filiere_id');
    }
}
