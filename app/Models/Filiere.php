<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function formateur()
    {
        return $this->belongsTo(Formateur::class, 'formateur_id');
    }
    public function groupes()
    {
        return $this->hasMany(Groupe::class, 'filiere_id');
    }

}
