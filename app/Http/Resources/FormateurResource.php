<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormateurResource extends JsonResource
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
            "prenom" => $this->prenom,
            "type" => $this->type,
            "date_formation" => $this->date_formation,
            "filieres" => $this->filieres,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
