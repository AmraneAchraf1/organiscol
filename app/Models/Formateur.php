<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formateur extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function filieres()
    {
        return $this->belongsToMany(Filiere::class, 'formateur_filiere', 'formateur_id', 'filiere_id');
    }
}
