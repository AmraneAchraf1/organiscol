<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeanceRequest;
use App\Http\Resources\SeanceResource;
use App\Models\Seance;
use Illuminate\Http\Request;

class SeanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Seance::all()->groupBy('jour')->map(function ($item){
            return SeanceResource::collection($item);
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SeanceRequest $request)
    {
        $data = $request->validated();

        # check if séance exist
        $seance = Seance::where([
            "periode"=>$data["periode"],
            "jour"=>$data["jour"],
        ])->where(function ($query) use ($data){
            $query->where("formateur_id",$data["formateur_id"])
                ->orWhere("groupe_id",$data["groupe_id"])
                ->orWhere("salle_id",$data["salle_id"]);
        })->first();

        if ($seance){
            return response()->json(["success"=>false,"message"=>"séance existe déjà"
                , "seance"=> new SeanceResource($seance)],400);
        }

        $seance = Seance::create([
            "periode"=>$data["periode"],
            "jour"=>$data["jour"],
            "formateur_id"=>$data["formateur_id"],
            "groupe_id"=>$data["groupe_id"],
            "salle_id"=>$data["salle_id"],
        ]);

        if ($seance){
            return response()->json(["success"=>true,"seance"=>$seance]);
        }else{
            return response()->json(["success"=>false],400);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $seance = Seance::find($id);
        if ($seance){
            return response()->json(["success"=>true,"seance"=>new SeanceResource($seance)]);
        }

        return response()->json(["success"=>false],400);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            "periode" => "sometimes|in:1,2,3,4",
            "jour" => "sometimes|in:lundi,mardi,mercredi,jeudi,vendredi,samedi",
            "salle_id" => "sometimes|exists:salles,id",
            "formateur_id" => "sometimes|exists:formateurs,id",
            "groupe_id" => "sometimes|exists:groupes,id",
            "color" => "sometimes|string|max:255",
        ]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $seance = Seance::find($id);
        if ($seance){
            $seance->delete();
            return response()->json(["success"=>true]);
        }
        return response()->json(["success"=>false],400);
    }
}
