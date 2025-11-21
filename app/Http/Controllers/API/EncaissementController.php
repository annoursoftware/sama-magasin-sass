<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Entreprise;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class EncaissementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # code...
        $query1 = DB::table('encaissements as e')
            ->leftJoin('ventes as v', 'v.id', 'e.vente_id')
            ->join('clients as c', 'c.id', 'v.client_id')
            ->leftJoin('detail_encaissements as de', 'de.encaissement_id', 'e.id')
            ->select(
                'e.id',
                DB::raw("CONCAT('Enc N° ', e.num_encaissement) AS num_encaissement"),
                'v.num_vente',
                DB::raw("CONCAT(IF(v.status_vente='d', 'Devis', 'Vente'),' N°', v.num_vente) AS num_operation"),
                'c.client',
                'v.montant',
                'v.etat', /* A changer en e.etat */
                /* DB::raw('IFNULL(SUM(de.montant), 0) AS encaissements'), */
                DB::raw('COALESCE(SUM(de.montant), 0) AS encaissements')
            )
            ->groupBy(
                'e.id', 'e.num_encaissement', 'c.client', 'v.num_vente', 'v.montant'
            );

        $query2 = DB::table('encaissements as e')
            ->leftJoin('prestations as p', 'p.id', 'e.prestation_id')
            ->join('clients as c', 'c.id', 'p.client_id')
            ->leftJoin('detail_encaissements as de', 'de.encaissement_id', 'e.id')
            ->select(
                'e.id',
                DB::raw("CONCAT('Enc N° ', e.num_encaissement) AS num_encaissement"),
                'p.code_prestation',
                DB::raw("CONCAT('Prest N° ', p.code_prestation) AS num_operation"),
                'c.client',
                'p.montant',
                'p.etat', /* A changer en e.etat */
                DB::raw('SUM(de.montant) AS encaissements')
            )
            ->groupBy(
                'e.id', 'e.num_encaissement', 'c.client', 'p.code_prestation', 'p.montant'
            );
            
        $query = $query1->union($query2)->get();
        /* $query = $query1->get(); */

        if ($request->ajax()) {    
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                if ($data->montant == $data->encaissements) {
                    
                    $btn =  '<div class="btn-group">';
                    $btn .= '<button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>';
                    $btn .= '<div class="dropdown-menu" style="">';
                    $btn .= '<a onclick="showData('.$data->id.')" class="dropdown-item" href="#"><i class="bi bi-eye-fill"></i> Détails</a>';
                    $btn .= '</div>';
                    $btn .= '</div>';

                } else {
                    $btn =  '<div class="btn-group">';
                    $btn .= '<button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>';
                    $btn .= '<div class="dropdown-menu" style="">';
                    $btn .= '<a onclick="showData('.$data->id.')" class="dropdown-item" href="#"><i class="bi bi-eye-fill"></i> Détails</a>';
                    $btn .= '<a onclick="editData('.$data->id.')" class="dropdown-item" href="#"><i class="bi bi-cash"></i> Encaissement</a>';
                    $btn .= '<a onclick="deleteData('.$data->id.')" class="dropdown-item" href="#"><i class="bi bi-trash-fill"></i> Suppression</a>';
                    $btn .= '</div>';
                    $btn .= '</div>';
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'activite' => 'required',
            'montant' => 'required|numeric',
            'categorie_id' => 'nullable|integer',
            'boutique_id' => 'nullable|integer',
        ], [
            'activite.required' => "L'activité est obligatoire.",
            'montant.required' => 'Le montant est obligatoire !',
            'montant.numeric' => 'Le montant doit être un nombre !',
            'categorie_id.required' => "La Catégorie est obligatoire.",
            'categorie_id.integer' => "La Catégorie_id doit être un nombre.",
            'boutique_id.required' => "La boutique est obligatoire.",
            'boutique_id.integer' => "La boutique_id doit être un nombre.",
        ]);
           
        $data = DB::table('activites')->insert([
            'activite' => $request->activite,
            'montant' => $request->montant,
            'categorie_id' => $request->categorie_id,
            'user_id' => $request->user_id,
            'boutique_id' => $request->boutique_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
      
        return response()->json([
            'success' => 'Prestation enregistrée avec succès !',
            'data' => $data,
            'status' => 201,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $data = DB::table('activites as a')
            ->join('categories as c','a.categorie_id','=','c.id')
            ->join('boutiques as b','a.boutique_id','=','b.id')
            ->select('a.*', 'c.categorie', 'b.boutique')
            ->where('a.id', $id)
            ->first();

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Activité chargée avec succès !',
                'data' => $data,
                'status' => 200,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'activite' => 'required',
            'montant' => 'required|numeric',
            'categorie_id' => 'nullable|integer',
            'boutique_id' => 'nullable|integer',
        ], [
            'activite.required' => "L'activité est obligatoire.",
            'montant.required' => 'Le montant est obligatoire !',
            'montant.numeric' => 'Le montant doit être un nombre !',
            'categorie_id.required' => "La Catégorie est obligatoire.",
            'categorie_id.integer' => "La Catégorie_id doit être un nombre.",
            'boutique_id.required' => "La boutique est obligatoire.",
            'boutique_id.integer' => "La boutique_id doit être un nombre.",
        ]);
           
        $data = DB::table('activites')
            ->where('id', $id)
            ->update([
                'activite' => $request->activite,
                'montant' => $request->montant,
                'categorie_id' => $request->categorie_id,
                'user_id' => $request->user_id,
                'boutique_id' => $request->boutique_id,
                'updated_at' => Carbon::now()
            ]);
        
        return response()->json([
            'success' => 'Activité modifiée avec succès !',
            'data' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('activites')->where('id', $id)->delete();
        return response()->json(['success' => 'Activité supprimée avec succès !']);
    }

    /**
     * Change state the specified resource from storage.
     */
    public function modification_etat_encaissement(Request $request, string $id) 
    {    
        DB::table('encaissements')
            ->where('id', $id)
            ->update([
                'etat' => $request->etat,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(["success" => "Etat de l'encaissement modifié avec succès !"]);
    }
    
    public function annulation_encaissement(Request $request, string $id) 
    {    
        DB::table('encaissements')
            ->where('id', $id)
            ->update([
                'etat' => 0,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(["success" => "Encaissement annulé avec succès !"]);
    }
    
    public function ajout_encaissement_into_details_encaissement(Request $request, string $id)
    {
        $request->validate([
            'systeme_encaissement' => 'required',
            'mode_encaissement' => 'required',
            'ref_encaissement' => 'required',
            'encaissement' => 'required|numeric',
        ], [
            'systeme_encaissement.required' => "Le systéme d'encaissement est obligatoire.",
            'mode_encaissement.required' => "Le mode d'encaissement est obligatoire !",
            'ref_encaissement.required' => "La Référence d'encaissement est obligatoire !",
            'encaissement.required' => "Le montant d'encaissement est obligatoire !",
            'encaissement.numeric' => "Le montant d'encaissement doit être un nombre !",
        ]);

        $data = DB::table('detail_encaissements')->insert([
            'mode_encaissement' => $request->systeme_encaissement,
            'lieu_encaissement' => $request->mode_encaissement,
            'ref_encaissement' => $request->systeme_encaissement=='banque' ? $request->moyen_bancaire.'- N°'.$request->ref_encaissement : $request->ref_encaissement,
            'montant' => $request->encaissement,
            'user_id' => /* $request->user_id */1,
            'encaissement_id' => $request->encaissement_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'success' => 'Encaissement ajouté avec succès !',
            'data' => $data,
            'status' => 200,
        ]);
    }

    public function details_encaissement(Request $request, string $id)
    {
        $data = DB::table('detail_encaissements as d')
            ->join('users as u', 'u.id', 'd.user_id')
            ->select(
                'd.id', 'd.mode_encaissement', 'd.ref_encaissement', 'd.lieu_encaissement', 'd.montant', 'd.etat', 'd.created_at',
                'u.name'
            )
            ->where('d.encaissement_id', $id)
            ->first();

        /* dd($data); */

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Détail Article chargé avec succès !',
                'data' => $data,
                'status' => 200,
            ]);
        }
    }
    
    public function annulation_details_encaissement(string $id)
    {
        DB::table('detail_encaissements')
            ->where('id', $id)
            ->update([
                'etat' => 0,
                'updated_at' => Carbon::now(),
            ]);
            
        return response()->json(['success' => "Ligne d'encaissement annulée avec succès !"]);
    }

    public function edit_montant_into_details_encaissement(Request $request, string $id){
        DB::table('detail_encaissements')
            ->where('id', $id)
            ->update([
                'montant' => $request->montant,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'Montant encaissement modifié avec succès !']);
    }

    public function edit_reference_into_details_encaissement(Request $request, string $id){
        DB::table('detail_encaissements')
            ->where('id', $id)
            ->update([
                'ref_encaissement' => $request->reference,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'Référence encaissement modifiée avec succès !']);
    }
}
