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
            "formateurs" => $this->formateurs->map(function($formateur){
                return [
                    "id" => $formateur->id,
                    "nom" => $formateur->nom,
                    "prenom" => $formateur->prenom,
                    "type" => $formateur->type,
                    "date_formation" => $formateur->date_formation,
                    "created_at" => $formateur->created_at,
                    "updated_at" => $formateur->updated_at
                ];
            }) ,
            "groupes" => GroupeResource::collection($this->groupes),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
