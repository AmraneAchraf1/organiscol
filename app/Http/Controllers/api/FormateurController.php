<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormateurResource;
use App\Models\Filiere;
use Illuminate\Http\Request;
use App\Models\Formateur;
use App\Http\Requests\FormateurRequest;

class FormateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = FormateurResource::collection(Formateur::all());
        if ($data->count() > 0) {
            return response()->json(["success" => true, "formateurs" => $data]);
        } else {
            return response()->json(["success" => false], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormateurRequest $request)
    {
        $data = $request->validated();
        $formateur = Formateur::create($data);
        # check filieres if exist
        $filieres_ids = explode(",", $data["filieres_ids"]);
        $filieres = Filiere::find($filieres_ids);
        if ($filieres) {
            $formateur->filieres()->attach($filieres);
        } else {
            return response()->json(["success" => false,
                "message" => "ne trouve pas les filieres de ids " . $data["filieres_ids"]],
                400);
        }

        if ($formateur){
            return response()->json(["success"=>true,"formateur"=>$formateur]);
        }else{
            return response()->json(["success"=>false],400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $formateur = Formateur::find($id);
        if ($formateur){
            return response()->json(["success"=>true,"formateur"=>new FormateurResource($formateur)]);
        }else{
            return response()->json(["success"=>false,
                                    "message"=>"ne trouve pas le formateur de id ".$id],
                                    400);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        # validate the data
        $data = $request->validate([
            "nom"=>"sometimes|string",
            "prenom"=>"sometimes|string",
            "type"=>"sometimes|string",
            "date_formation"=>"sometimes|date",
            "filieres_ids"=>"sometimes|string",
        ]);
        $formateur = Formateur::find($id);



        if($formateur){
            # check filieres if exist
            if (isset($data["filieres_ids"])){
                $filieres_ids = explode(",",$data["filieres_ids"]);
                $filieres = Filiere::find($filieres_ids);
                if ($filieres){
                    $formateur->filieres()->sync($filieres);
                }else{
                    return response()->json(["success"=>false,
                        "message"=>"ne trouve pas les filieres de ids ".$data["filieres_ids"]],
                        400);
                }
            }

            if($formateur->update($data)){
                return response()->json(["success"=>true,"formateur"=>$formateur]);
            }else{
                return response()->json(["success"=>false],400);
            }
        }else{
            return response()->json(["message"=>"ne trouve pas le formateur de id ".$id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $formateur = Formateur::find($id);
        if($formateur){
            if($formateur->delete()){
                return response()->json(["success"=>true]);
            }else{
                return response()->json(["success"=>false],400);
            }

        }else{
            return response()->json(["message"=>"ne trouve pas le formateur de id ".$id]);
        }
    }
}
