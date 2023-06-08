<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeanceRequest;
use App\Http\Resources\SeanceResource;
use App\Models\Salle;
use App\Models\Seance;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SeanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seances =  SeanceResource::collection(Seance::all())->groupBy("jour")->map(function ($item){
            return $item->groupBy("periode");
        });

        $seances["salles"] = Salle::all();

        return $seances;
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
            "formateur_id" => "sometimes|exists:formateurs,id",
            "groupe_id" => "sometimes|exists:groupes,id",
            "color" => "sometimes|string|max:255",
        ]);

        $seance = Seance::find($id);

        # check if séance already exist
        $seanceExist = Seance::where($data)
            ->where("id","!=",$seance->id)
            ->where("periode",$seance->periode)
            ->where("jour",$seance->jour)
            ->first();

        if ($seanceExist){
            return response()->json(["success"=>false,"message"=>"séance existe déjà"
                , "seance"=> new SeanceResource($seanceExist)],400);
        }

        if ($seance){
            $seance->update($data);
            return response()->json(["success"=>true,"seance"=>new SeanceResource($seance)]);
        }




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

    public function print_formateur_emploi(Request $request)
    {
        $data = $request->validate([
           "formateur_id" => "required|exists:formateurs,id",
            ]);

        $seances = Seance::where("formateur_id",$data['formateur_id'])->get();

        if($seances->count() == 0){
            return response()->json(["success"=>false,"message"=>"aucune séance trouvée"],400);
        }

        $pdf_data = $seances->groupBy("jour")->map(function ($item){
            return SeanceResource::collection($item)->groupBy("periode");
        });

        # get masse horaire
        $masse_horaire = $seances->count() * 2.5;

        # get formateur name
        $formateur = $seances->first()->formateur->nom . " " . $seances->first()->formateur->prenom;

        # get school year
        $satrt_school_year = date("Y") - 1;
        $end_school_year = date("Y",strtotime("+1 year")) - 1;
        $annee_formation = $satrt_school_year."/".$end_school_year;


        $pdf = Pdf::loadView("pdf.formateur",
            ["data"=>$pdf_data,
            "masse_horaire"=>$masse_horaire,
            "formateur"=>$formateur,
            "annee_formation"=>$annee_formation,
            ])->setPaper('a4', 'landscape');
        return $pdf->download("emploidutemps_formateur.pdf");
    }

    public function print_groupe_emploi (Request $request)
    {
        $data = $request->validate([
            "groupe_id" => "required|exists:groupes,id",
        ]);

        $seances = Seance::where("groupe_id",$data['groupe_id'])->get();

        if($seances->count() == 0){
            return response()->json(["success"=>false,"message"=>"aucune séance trouvée"],400);
        }

        $pdf_data = $seances->groupBy("jour")->map(function ($item){
            return SeanceResource::collection($item)->groupBy("periode");
        });

        # get masse horaire
        $masse_horaire = $seances->count() * 2.5;

        # get groupe name
        $groupe = $seances->first()->groupe->nom;

        # get formateur name
        $formateur = $seances->first()->formateur->nom . " " . $seances->first()->formateur->prenom;

        # get school year
        $satrt_school_year = date("Y") - 1;
        $end_school_year = date("Y",strtotime("+1 year")) - 1;
        $annee_formation = $satrt_school_year."/".$end_school_year;


        $pdf = Pdf::loadView("pdf.groupe",
            ["data"=>$pdf_data,
                "masse_horaire"=>$masse_horaire,
                "groupe"=>$groupe,
                "annee_formation"=>$annee_formation,
                "formateur"=>$formateur,
            ])->setPaper('a4', 'landscape');

        return $pdf->download("emploidutemps_groupe.pdf");
    }

}


