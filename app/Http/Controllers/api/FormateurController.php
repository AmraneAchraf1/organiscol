<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormateurResource;
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
        ]);
        $formateur = Formateur::find($id);
        if($formateur){
            if($formateur->update($data)){
                return response()->json(["success"=>true,$formateur]);
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
