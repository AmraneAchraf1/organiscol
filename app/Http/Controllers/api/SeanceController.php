<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeanceRequest;
use App\Http\Resources\FormateurResource;
use App\Http\Resources\GroupeResource;
use App\Http\Resources\SalleResource;
use App\Http\Resources\SeanceResource;
use App\Models\Filiere;
use App\Models\Formateur;
use App\Models\Groupe;
use App\Models\Salle;
use App\Models\Seance;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use function PHPSTORM_META\map;

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
            "color"=>$data["color"],
        ]);

        if ($seance){
            return response()->json(["success"=>true,"seance"=> new SeanceResource($seance)]);
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

        if(!$seance){
            return response()->json(["success"=>false,"message"=>"séance $id introuvable"],400);
        }

            # check if séance already exist
            $seanceExist = Seance::where([
                "periode"=>$seance->periode,
                "jour"=>$seance->jour,
            ])
                ->where("salle_id","!=",$seance->salle->id)
                ->where(function ($query) use ($data){
                $query->where("formateur_id",$data["formateur_id"])
                    ->orWhere("groupe_id",$data["groupe_id"]);
            })->first();



            if (!$seanceExist){
                $seance->update($data);
                return response()->json(["success"=>true,"seance"=>new SeanceResource($seance)]);
            }

            return response()->json(["success"=>false,"message"=>"séance existe déjà",
                "seance" => new SeanceResource($seanceExist)],400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $seance = Seance::find($id);
        if ($seance){
            $seance->delete();
            return response()->json(["success"=>true , "seance" => new SeanceResource($seance)]);
        }
        return response()->json(["success"=>false],400);
    }

    public function print_formateur_emploi(Request $request, string $id)
    {


        $seances = Seance::where("formateur_id",$id)->get();

        if($seances->count() == 0){
            return response()->json(["success"=>false,"message"=>"aucune séance trouvée"],400);
        }

        $pdf_data = $seances->groupBy("jour")->map(function ($item){
            return SeanceResource::collection($item)->groupBy("periode");
        });

        if (!$pdf_data) {
            return response()->json(["success"=>false,"message"=>"aucune séance trouvée"],400);
        }

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

        if(!$pdf){
            return  response()->json(["success"=>false,"message"=>"erreur lors de la génération du pdf"],400 );
        }

        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="file.blob"',
        ];

        return response()->make($pdf->output(), 200, $headers);
    }

    /**
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function print_groupe_emploi (Request $request, string $id)
    {


        $seances = Seance::where("groupe_id",$id)->get();

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

        if(!$pdf){
            return  response()->json(["success"=>false,"message"=>"erreur lors de la génération du pdf"],400 );
        }

        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="file.blob"',
        ];

        return response()->make($pdf->output(), 200, $headers);
    }


    public  function seances_analysis(){
        $seances = Seance::all();
        $salles = Salle::all();

        $total_heures_semaine = 60;
        $global_heures = $total_heures_semaine * $salles->count();
        $total_heures = $seances->count() * 2.5;
        // For all séances
        $pourcentage = ($total_heures / $global_heures) * 100;
        $pourcentage = round($pourcentage,2);

        // For each salle
        $pourcentage_salles = [];
        foreach ($salles as $salle){
            $seances_salle = $seances->where("salle_id",$salle->id);
            $total_heures_salle = $seances_salle->count() * 2.5;
            $pourcentage_salle = ($total_heures_salle / $total_heures_semaine) * 100;
            $pourcentage_salle = round($pourcentage_salle,2);

            $pourcentage_salles[] = [
                "id"=>$salle->id,
                "pourcentage"=>$pourcentage_salle,
                "total_heures"=>$total_heures_salle,
                "global_heures"=>$total_heures_semaine,
                "salle" => new SalleResource($salle),
            ];
        }

        return response()->json(["success"=>true,
            "global_analysis" => compact('total_heures', 'global_heures', 'pourcentage'),
            "analysis_by_salle"=>$pourcentage_salles,
            ]);


    }


    public function export_emploi(){
        // Export As Json File And Download It

        $seances = Seance::all();
        $salles = Salle::all();
        $formateurs = Formateur::all();
        $groupes = Groupe::all();
        $filieres = Filiere::all();


        $data = compact('seances', 'salles', 'formateurs', 'groupes', 'filieres');

        $json = json_encode($data);

        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="file.blob"',
        ];

        return response()->make($json, 200, $headers);



    }

    public function import_emploi(Request $request){

        // import json file and save it to database

        $file = $request->file("file");

        $json = file_get_contents($file);
        $data = json_decode($json);

        $filieres = $data->filieres;
        $salles = $data->salles;
        $formateurs = $data->formateurs;
        $seances = $data->seances;
        $groupes = $data->groupes;

        if(
            count($filieres) == 0 ||
            count($salles) == 0 ||
            count($formateurs) == 0 ||
            count($groupes) == 0 ||
            count($seances) == 0
        ){
            return response()->json(["success"=>false, "message"=>"aucune donnée trouvée"],400);
        }else{

            DB::statement('SET FOREIGN_KEY_CHECKS=0');


            // delete all data
            Filiere::truncate();
            Salle::truncate();
            Formateur::truncate();
            DB::table("formateur_filiere")->truncate();
            Seance::truncate();
            Groupe::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            // insert filieres
            foreach ($filieres as $filiere){
                $f = new Filiere();
                $f->nom = $filiere->nom;
                $f->save();
            }

            // insert salles
            foreach ($salles as $salle){
                $s = new Salle();
                $s->nom = $salle->nom;
                $s->status = $salle->status;
                $s->description = $salle->description;
                $s->save();
            }

            // insert formateurs
            foreach ($formateurs as $formateur){
                $f = new Formateur();
                $f->nom = $formateur->nom;
                $f->prenom = $formateur->prenom;
                $f->type = $formateur->type;
                $f->date_formation = $formateur->date_formation;
                $f->save();
            }

            // insert groupes
            foreach ($groupes as $groupe){
                $g = new Groupe();
                $g->nom = $groupe->nom;
                $g->filiere_id = $groupe->filiere_id;
                $g->save();
            }

            // insert seances
            foreach ($seances as $seance){
                $s = new Seance();
                $s->jour = $seance->jour;
                $s->periode = $seance->periode;
                $s->salle_id = $seance->salle_id;
                $s->formateur_id = $seance->formateur_id;
                $s->groupe_id = $seance->groupe_id;
                $s->color = $seance->color;
                $s->save();
            }

            return response()->json(["success"=>true, "message"=>"données importées avec succès"],200);
        }




    }



}


