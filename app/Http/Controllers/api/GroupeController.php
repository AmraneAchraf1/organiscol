<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupeRequest;
use App\Http\Resources\GroupeResource;
use App\Models\Groupe;
use Illuminate\Http\Request;

class GroupeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groupes = GroupeResource::collection(Groupe::all());
        if ($groupes->count() > 0){
            return response()->json(["success"=>true,"groupes"=>$groupes]);
        }
        else{
            return response()->json(["success"=>false],400);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupeRequest $request)
    {
        $data = $request->validated();
        $groupe = Groupe::create($data);
        if ($groupe){
            return response()->json(["success"=>true,"groupe"=>$groupe]);
        }else{
            return response()->json(["success"=>false],400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $groupe = Groupe::find($id);
        if ($groupe){
            return response()->json(["success"=>true,"groupe"=>new GroupeResource($groupe)]);
        }else{
            return response()->json(["success"=>false,
                                    "message"=>"ne trouve pas le groupe de id ".$id],
                                    400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
