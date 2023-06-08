<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "periode" => $this->periode,
            "jour" => $this->jour,
            "salle" => [
                "id" => $this->salle->id,
                "nom" => $this->salle->nom,
            ],
            "color" => $this->color,
            "formateur" => [
                "id" => $this->formateur->id,
                "nom"=> $this->formateur->nom,
                "prenom" => $this->formateur->prenom,
                "type" => $this->formateur->type,
            ],
            "groupe" => [
                "id" => $this->groupe->id,
                "nom" => $this->groupe->nom,
                "filiere" => $this->groupe->filiere->nom,
            ],
        ];
    }
}
