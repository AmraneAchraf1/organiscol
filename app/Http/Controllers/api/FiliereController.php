<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FiliereRequest;
use App\Http\Resources\FiliereResource;
use App\Models\Filiere;
use App\Models\Formateur;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filiere = FiliereResource::collection(Filiere::all());
        if ($filiere->count() > 0){

        return response()->json(["success"=>true,"filieres"=>$filiere]);
        }
        else{
            return response()->json(["success"=>false],400);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FiliereRequest $request)
    {
        $data = $request->validated();

        $filiere = null;
        # check formateurs if exist
        if (isset($data["formateurs_ids"])){
            $formateurs_ids = explode(',',$data["formateurs_ids"]);
            try {
                $formateurs = Formateur::findOrFail($formateurs_ids);

            }catch (\Throwable $th){
                return response()->json(["success"=>false,
                    "message"=>"ne trouve pas les formateurs de ids ".$data["formateurs_ids"]],
                    400);
            }
            if (!$formateurs){
                return response()->json(["success"=>false,
                    "message"=>"ne trouve pas les formateurs de ids ".$data["formateurs_ids"]],
                    400);
            }
        }

        $filiere = Filiere::create([
            "nom"=>$data["nom"]
        ]);
        $filiere->formateurs()->attach($formateurs);

        if ($filiere){
            return response()->json(["success"=>true,"filiere"=>$filiere]);
        }else{
            return response()->json(["success"=>false],400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $filiere = Filiere::find($id);
        if ($filiere){
            return response()->json(["success"=>true,"filiere"=>new FiliereResource($filiere)]);
        }else{
            return response()->json(["success"=>false,
                                    "message"=>"ne trouve pas la filiere de id ".$id],
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
                "formateurs_ids"=>"sometimes|string",
          ]);
          $filiere = Filiere::find($id);


          if ($filiere){
              # update formateurs
              if (isset($data["formateurs_ids"])){
                  # check if formateur exist to update filiere of formateur
                  try {
                      $formateurs = Formateur::findOrFail(explode(',',$data["formateurs_ids"]));
                      $filiere->formateurs()->sync($formateurs);
                  }catch (\Throwable $th){
                      return response()->json(["success"=>false,
                          "message"=>"ne trouve pas les formateurs de ids ".$data["formateurs_ids"]],
                          400);
                  }

              }

              $filiere->update($data);
                return response()->json(["success"=>true,"filiere"=> new FiliereResource($filiere) ]);
          }else{
                return response()->json(["success"=>false,
                                        "message"=>"ne trouve pas la filiere de id ".$id],
                                        400);
          }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $filiere = Filiere::find($id);
        if ($filiere){
            $filiere->delete();

            return response()->json(["success"=>true,"filiere"=>$filiere]);
        }else{
            return response()->json(["success"=>false,
                                    "message"=>"ne trouve pas la filiere de id ".$id],
                                    400);
        }
    }
}
