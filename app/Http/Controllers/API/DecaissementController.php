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

class DecaissementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # code...
        $query1 = DB::table('decaissements as d')
            ->leftJoin('achats as a', 'a.id', 'd.achat_id')
            ->join('fournisseurs as f', 'f.id', 'a.fournisseur_id')
            ->leftJoin('detail_decaissements as dd', 'dd.decaissement_id', 'd.id')
            ->select(
                'd.id',
                DB::raw("CONCAT('Dec N° ', d.num_decaissement) AS num_decaissement"),
                'a.num_achat',
                DB::raw("CONCAT(IF(a.status_achat='d', 'Devis', 'Achat'),' N°', a.num_achat) AS num_operation"),
                'f.fournisseur',
                'a.montant',
                'a.etat', /* A changer en e.etat */
                /* DB::raw('IFNULL(SUM(de.montant), 0) AS encaissements'), */
                DB::raw('COALESCE(SUM(dd.montant), 0) AS decaissements')
            )
            ->groupBy(
                'd.id', 'd.num_decaissement', 'f.fournisseur', 'a.num_achat', 'a.montant'
            );

        $query2 = DB::table('decaissements as d')
            ->leftJoin('depenses as dep', 'dep.id', 'd.depense_id')
            ->join('beneficiaires as b', 'b.id', 'dep.beneficiaire_id')
            ->leftJoin('detail_decaissements as dd', 'dd.decaissement_id', 'd.id')
            ->select(
                'd.id',
                DB::raw("CONCAT('Dec N° ', d.num_decaissement) AS num_decaissement"),
                'dep.num_depense',
                DB::raw("CONCAT('Depense',' N°', dep.num_depense) AS num_operation"),
                'b.beneficiaire',
                'dep.montant',
                'dep.etat', /* A changer en e.etat */
                /* DB::raw('IFNULL(SUM(de.montant), 0) AS encaissements'), */
                DB::raw('COALESCE(SUM(dd.montant), 0) AS decaissements')
            )
            ->groupBy(
                'd.id', 'd.num_decaissement', 'b.beneficiaire', 'dep.num_depense', 'dep.montant'
            );
            
        $query = $query1->union($query2)->get();
        /* $query = $query1->get(); */

        if ($request->ajax()) {    
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                if ($data->montant == $data->decaissements) {
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        //
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
        DB::table('decaissements')->where('id', $id)->delete();
        return response()->json(['success' => 'Décaissement supprimé avec succès !']);
    }

    /**
     * Change state the specified resource from storage.
     */
    public function modification_etat_decaissement(Request $request, string $id) 
    {    
        DB::table('decaissements')
            ->where('id', $id)
            ->update([
                'etat' => $request->etat,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(["success" => "Etat du décaissement modifié avec succès !"]);
    }

    public function annulation_decaissement(Request $request, string $id) 
    {    
        DB::table('decaissements')
            ->where('id', $id)
            ->update([
                'etat' => 0,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(["success" => "Décaissement annulé avec succès !"]);
    }
    
    public function ajout_decaissement_into_details_decaissement(Request $request, string $id)
    {
        $request->validate([
            'systeme_decaissement' => 'required',
            'mode_decaissement' => 'required',
            'ref_decaissement' => 'required',
            'decaissement' => 'required|numeric',
        ], [
            'systeme_decaissement.required' => "Le systéme de décaissement est obligatoire.",
            'mode_decaissement.required' => 'Le mode de décaissement est obligatoire !',
            'ref_decaissement.required' => 'La Référence de décaissement obligatoire !',
            'decaissement.required' => 'Le montant de décaissement est obligatoire !',
            'decaissement.numeric' => 'Le montant de décaissement doit être un nombre !',
        ]);

        $data = DB::table('detail_decaissements')->insert([
            'mode_decaissement' => $request->systeme_decaissement,
            'lieu_decaissement' => $request->mode_decaissement,
            'ref_decaissement' => $request->systeme_decaissement=='banque' ? $request->moyen_bancaire.'- N°'.$request->ref_decaissement : $request->ref_decaissement,
            'montant' => $request->decaissement,
            'user_id' => /* $request->user_id */1,
            'decaissement_id' => $request->decaissement_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'success' => 'Décaissement ajouté avec succès !',
            'data' => $data,
            'status' => 200,
        ]);
    }

    public function details_decaissement(Request $request, string $id)
    {
        $data = DB::table('detail_decaissements as d')
            ->join('users as u', 'u.id', 'd.user_id')
            ->select(
                'd.id', 'd.mode_decaissement', 'd.ref_decaissement', 'd.lieu_decaissement', 'd.montant', 'd.etat', 'd.created_at',
                'u.name'
            )
            ->where('d.decaissement_id', $id)
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
    
    public function annulation_details_decaissement(string $id)
    {
        DB::table('detail_decaissements')
            ->where('id', $id)
            ->update([
                'etat' => 0,
                'updated_at' => Carbon::now(),
            ]);
            
        return response()->json(['success' => "Ligne de décaissement annulée avec succès !"]);
    }

    public function edit_montant_into_details_decaissement(Request $request, string $id){
        DB::table('detail_decaissements')
            ->where('id', $id)
            ->update([
                'montant' => $request->montant,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'Montant décaissement modifié avec succès !']);
    }

    public function edit_reference_into_details_decaissement(Request $request, string $id){
        DB::table('detail_decaissements')
            ->where('id', $id)
            ->update([
                'ref_decaissement' => $request->reference,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'Référence décaissement modifiée avec succès !']);
    }
}
