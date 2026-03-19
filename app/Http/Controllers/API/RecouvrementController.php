<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use PDF;
class RecouvrementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # code...
        $data_1 = DB::table('vue_depenses_1')
            ->where('montant_restant_a_decaisser', '>', 0)
            //->orWhere('montant_restant_a_decaisser', 0)
            ->select('id', 'num_decaissement', 'num_contrat'/* , 'rentree_argent as transaction' */, DB::raw("CONCAT('-', montant) AS montant_facture"), 'fournisseur as intermediaire', DB::raw("CONCAT('-', montant_apres_remise) AS montant_apres_remise"), DB::raw("CONCAT('-', montant_decaisse) AS montant_compta"), DB::raw("CONCAT('-', montant_restant_a_decaisser) AS montant_restant"));

        $data_2 = DB::table('vue_encaissements_1')
            ->where('montant_restant_a_encaisser', '>', 0)
            //->orWhere('montant_restant_a_encaisser', 0)
            ->select('id', 'num_encaissement', 'num_contrat'/* , 'rentree_argent as transaction' */, 'montant as montant_facture', 'client as intermediaire', 'montant_apres_remise', 'montant_encaisse as montant_compta', 'montant_restant_a_encaisser as montant_restant');
            
        $query = $data_1->union($data_2)->orderBy('id', 'desc')->get();

        if ($request->ajax()) {    
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                
                $btn =  '<div class="btn-group">';
                $btn .= '<button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>';
                $btn .= '<div class="dropdown-menu" style="">';
                $btn .= '<a onclick="showData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-eye-fill"></i> Détails</a>';
                $btn .= '</div>';
                $btn .= '</div>';
                
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }
    
    /**
     * Display a listing of the resource.
     */
    public function creances(Request $request)
    {
        # code...
        $query = DB::table('vue_encaissements_1')->where('montant_restant_a_encaisser', '>', 0)->get();

        if ($request->ajax()) {    
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                
                $btn =  '<div class="btn-group">';
                $btn .= '<button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>';
                $btn .= '<div class="dropdown-menu" style="">';
                $btn .= '<a onclick="showData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-eye-fill"></i> Détails</a>';
                $btn .= '</div>';
                $btn .= '</div>';
                
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function dettes(Request $request)
    {
        # code...
        $query = DB::table('vue_depenses_1')
            ->where('montant_restant_a_decaisser', '>', 0)
            ->orWhere('montant_restant_a_decaisser', 0)
            ->get();

        if ($request->ajax()) {    
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                
                $btn =  '<div class="btn-group">';
                $btn .= '<button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>';
                $btn .= '<div class="dropdown-menu" style="">';
                $btn .= '<a onclick="showData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-eye-fill"></i> Détails</a>';
                $btn .= '</div>';
                $btn .= '</div>';
                
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
        //
    }

    public function Imp_creances()
    {
        $resultat = DB::table('vue_encaissements_1')
            ->where('montant_restant_a_encaisser', '>', 0)
            ->get();
        $decompte = DB::table('vue_encaissements_1')
            ->where('montant_restant_a_encaisser', '>', 0)
            ->orWhere('montant_encaisse', 0)
            ->count();
        $facture = DB::table('vue_encaissements_1')
            ->where('montant_restant_a_encaisser', '>', 0)
            ->orWhere('montant_encaisse', 0)
            ->sum('montant');
        $encaissement = DB::table('vue_encaissements_1')
            ->where('montant_restant_a_encaisser', '>', 0)
            ->orWhere('montant_encaisse', 0)
            ->sum('montant_encaisse');
        $restant = DB::table('vue_encaissements_1')
            ->where('montant_restant_a_encaisser', '>', 0)
            ->orWhere('montant_encaisse', 0)
            ->sum('montant_restant_a_encaisser');
        //dd($vente);

        $pdf = PDF::loadView('back.recouvrements.creances.rapport', [
            "resultat" => $resultat,
            "decompte" => $decompte,
            "facture" => $facture,
            "encaissement" => $encaissement,
            "restant" => $restant,
        ]);
        $pdf->setPaper('a4', 'landing'); //landscape
        return $pdf->stream();
    }
    
    public function Imp_dettes()
    {
        $resultat = DB::table('vue_depenses_1')
            ->where('montant_restant_a_decaisser', '>', 0)
            ->orWhere('montant_decaisse', 0)
            ->get();
        $decompte = DB::table('vue_depenses_1')
            ->where('montant_restant_a_decaisser', '>', 0)
            ->orWhere('montant_decaisse', 0)
            ->count();
        $achat = DB::table('vue_depenses_1')
            ->where('montant_restant_a_decaisser', '>', 0)
            ->orWhere('montant_decaisse', 0)
            ->sum('montant');
        $decaissement = DB::table('vue_depenses_1')
            ->where('montant_restant_a_decaisser', '>', 0)
            ->orWhere('montant_decaisse', 0)
            ->sum('montant_decaisse');
        $restant = DB::table('vue_depenses_1')
            ->where('montant_restant_a_decaisser', '>', 0)
            ->orWhere('montant_decaisse', 0)
            ->sum('montant_restant_a_decaisser');
        //dd($vente);

        $pdf = PDF::loadView('back.recouvrements.dettes.rapport', [
            "resultat" => $resultat,
            "decompte" => $decompte,
            "achat" => $achat,
            "decaissement" => $decaissement,
            "restant" => $restant,
        ]);
        $pdf->setPaper('a4', 'landing'); //landscape
        return $pdf->stream();
    }
    
    public function Imp_solde()
    {
        # code...
        $data_1 = DB::table('vue_depenses_1')
            ->where('montant_restant_a_decaisser', '>', 0)
            //->orWhere('montant_restant_a_decaisser', 0)
            ->select('id', 'num_decaissement', 'num_contrat'/* , 'rentree_argent as transaction' */, DB::raw("CONCAT('-', montant) AS montant_facture"), 'fournisseur as intermediaire', DB::raw("CONCAT('-', montant_apres_remise) AS montant_apres_remise"), DB::raw("CONCAT('-', montant_decaisse) AS montant_compta"), DB::raw("CONCAT('-', montant_restant_a_decaisser) AS montant_restant"));

        $data_2 = DB::table('vue_encaissements_1')
            ->where('montant_restant_a_encaisser', '>', 0)
            //->orWhere('montant_restant_a_encaisser', 0)
            ->select('id', 'num_encaissement', 'num_contrat'/* , 'rentree_argent as transaction' */, 'montant as montant_facture', 'client as intermediaire', 'montant_apres_remise', 'montant_encaisse as montant_compta', 'montant_restant_a_encaisser as montant_restant');

        $resultat = $data_1->union($data_2)->orderBy('id', 'desc')->get();

        $decompte = $data_1->union($data_2)->orderBy('id', 'desc')->count();

        $production = $data_1->union($data_2)
            ->sum('montant_facture');

        $decaissement = DB::table('vue_depenses_1')
            ->sum('montant_decaisse');

        $encaissement = DB::table('vue_encaissements_1')
            ->sum('montant_encaisse');

        $restant = $encaissement - $decaissement;
        //dd($vente);

        $pdf = PDF::loadView('back.recouvrements.soldes.rapport', [
            "resultat" => $resultat,
            "decompte" => $decompte,
            "production" => $production,
            "decaissement" => $decaissement,
            "encaissement" => $encaissement,
            "restant" => $restant,
        ]);
        $pdf->setPaper('a4', 'landing'); //landscape
        return $pdf->stream();
    }
}
