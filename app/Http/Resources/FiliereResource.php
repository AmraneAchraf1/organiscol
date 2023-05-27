<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FiliereResource extends JsonResource
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
            "nom" => $this->nom,
            "formateur" => [
                "id" => $this->formateur->id,
                "nom" => $this->formateur->nom,
                "prenom" => $this->formateur->prenom,
                "type" => $this->formateur->type,
                "date_formation" => $this->formateur->date_formation,
                "created_at" => $this->formateur->created_at,
                "updated_at" => $this->formateur->updated_at
            ],
            "groupes" => GroupeResource::collection($this->groupes),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
