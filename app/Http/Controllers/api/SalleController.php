<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SalleRequest;
use App\Models\Salle;

class SalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Salle::all();
        if ($data->count() > 0) {
            return response()->json(["success" => true, "salles" => $data]);
        } else {
            return response()->json(["success" => false], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalleRequest $request)
    {
        $data = $request->validated();
        $salle = Salle::create($data);
        if ($salle){
            return response()->json(["success"=>true,"salle"=>$salle]);
        }else{
            return response()->json(["success"=>false],400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $salle = Salle::find($id);

        if ($salle){
            return response()->json(["success"=>true,"salle"=>$salle]);
        }else{
            return response()->json(["success"=>false,
                                    "message"=>"ne trouve pas la salle de id ".$id],
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
            "espace"=>"sometimes|integer",
            "description"=>"sometimes|string",
            "status"=>"sometimes|boolean",
        ]);
        $salle = Salle::find($id);
        if($salle){
            if($salle->update($data)){
                return response()->json(["success"=>true,"salle"=>$salle]);
            }else{
                return response()->json(["success"=>false],400);
            }
        }else{
            return response()->json(["message"=>"ne trouve pas la salle de id ".$id],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $salle = Salle::find($id);
        if($salle){
            if($salle->delete()){
                return response()->json(["success"=>true]);
            }else{
                return response()->json(["success"=>false],400);
            }

        }else{
            return response()->json(["message"=>"ne trouve pas la salle de id ".$id]);
        }
}}
