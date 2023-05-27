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
        return $this->hasMany(Filiere::class, "formateur_id");
    }
}
