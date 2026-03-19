<?php

namespace App\Http\Controllers\DEV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DecaissementController extends Controller
{
    public function index() 
    {
        return view('back.decaissements.dev');
    }

    public function details($id) 
    {
        $query_1 = DB::table('decaissements as d')
            ->join('achats as a', 'a.id', 'd.achat_id')
            ->join('fournisseurs as f', 'f.id', 'a.fournisseur_id')
            ->select(
                'd.id',
                'd.num_decaissement',
                'd.created_at',
                'd.etat',
                'd.achat_id',
                'd.depense_id',
                'a.num_achat as num_production',
                'a.montant',
                'a.remise',
                'a.created_at as date_etablissement',
                'f.fournisseur as beneficiaire',
                'f.telephone',
                'f.adresse'
            )
            ->where('d.id', $id)
            ->first();

        $query_2 = DB::table('decaissements as d')
            ->join('depenses as dep', 'dep.id', 'd.depense_id')
            ->join('beneficiaires as b', 'b.id', 'dep.beneficiaire_id')
            ->select(
                'd.id',
                'd.num_decaissement',
                'd.created_at',
                'd.etat',
                'd.achat_id',
                'd.depense_id',
                'dep.num_depense as num_production',
                'dep.montant',
                /* 'dep.remise', */
                'dep.created_at as date_etablissement',
                'b.beneficiaire as beneficiaire',
                'b.telephone',
                'b.adresse'
            )
            ->where('d.id', $id)
            ->first();

        if (is_null($query_1)) {
            # code...
            $decaissement = $query_2;
            
            /* Depense */
            $depense = DB::table('decaissements as d')
                ->join('depenses as dep', 'dep.id', 'd.depense_id')
                ->where('d.id', 4)
                ->sum(DB::raw('dep.montant'));

            /*
            $montant_remise_depense = $depense * ($encaissement->remise / 100);
            $montant_final = $depense - $montant_remise_depense; */
            $montant_final = $depense;
            /* Depense */
        } else {
            # code...
            $decaissement = $query_1;
            
            /* Achat */
            $achat = DB::table('decaissements as d')
                ->join('achats as a', 'a.id', 'd.achat_id')
                ->join('detail_achats as da', 'a.id', 'da.achat_id')
                ->where('d.id', 4)
                ->sum(DB::raw('da.montant*da.quantite'));

            $montant_remise_achat = $achat * ($decaissement->remise / 100);
            $montant_final = $achat - $montant_remise_achat;
            /* Achat */
        }

        $decaissements = DB::table('detail_decaissements as dd')
            ->join('decaissements as d', 'd.id', 'dd.decaissement_id')
            ->join('users as u', 'u.id', 'dd.user_id')
            ->select('dd.*',/* , 'dd.created_at', 'dd.mode_decaissement', 'dd.ref_decaissement', 'dd.montant', 'dd.etat', */ 'u.name')
            ->where('d.id', $id)
            ->get();

        $production = $montant_final;

        return view('back.decaissements.details', [
            'decaissement'=> $decaissement,
            'decaissements'=> $decaissements,
            'production'=> $production
        ]);
    }

    public function edition($id) 
    {
        $query_1 = DB::table('decaissements as d')
            ->join('achats as a', 'a.id', 'd.achat_id')
            ->join('fournisseurs as f', 'f.id', 'a.fournisseur_id')
            ->select(
                'd.id',
                'd.num_decaissement',
                'd.created_at',
                'd.etat',
                'd.achat_id',
                'd.depense_id',
                'a.num_achat as num_production',
                'a.montant',
                'a.remise',
                'a.created_at as date_etablissement',
                'f.fournisseur as beneficiaire',
                'f.telephone',
                'f.adresse'
            )
            ->where('d.id', 4)
            ->first();

        $query_2 = DB::table('decaissements as d')
            ->join('depenses as dep', 'dep.id', 'd.depense_id')
            ->join('beneficiaires as b', 'b.id', 'dep.beneficiaire_id')
            ->select(
                'd.id',
                'd.num_decaissement',
                'd.created_at',
                'd.etat',
                'd.achat_id',
                'd.depense_id',
                'dep.num_depense as num_production',
                'dep.montant',
                /* 'dep.remise', */
                'dep.created_at as date_etablissement',
                'b.beneficiaire as beneficiaire',
                'b.telephone',
                'b.adresse'
            )
            ->where('d.id', 4)
            ->first();

        if (is_null($query_1)) {
            # code...
            $decaissement = $query_2;
            
            /* Depense */
            $depense = DB::table('decaissements as d')
                ->join('depenses as dep', 'dep.id', 'd.depense_id')
                ->where('d.id', 4)
                ->sum(DB::raw('dep.montant'));

            /*
            $montant_remise_depense = $depense * ($encaissement->remise / 100);
            $montant_final = $depense - $montant_remise_depense; */
            $montant_final = $depense;
            /* Depense */
        } else {
            # code...
            $decaissement = $query_1;
            
            /* Achat */
            $achat = DB::table('decaissements as d')
                ->join('achats as a', 'a.id', 'd.achat_id')
                ->join('detail_achats as da', 'a.id', 'da.achat_id')
                ->where('d.id', 4)
                ->sum(DB::raw('da.montant*da.quantite'));

            $montant_remise_achat = $achat * ($decaissement->remise / 100);
            $montant_final = $achat - $montant_remise_achat;
            /* Achat */
        }

        $decaissements = DB::table('detail_decaissements as dd')
            ->join('decaissements as d', 'd.id', 'dd.decaissement_id')
            ->join('users as u', 'u.id', 'dd.user_id')
            ->select('dd.id', 'dd.created_at', 'dd.mode_decaissement', 'dd.ref_decaissement', 'dd.montant', 'dd.etat', 'u.name')
            ->where('d.id', 4)
            ->get();

        $production = $montant_final;
        
        return view('back.decaissements.edition', [
            'decaissement'=> $decaissement,
            'decaissements'=> $decaissements,
            'production'=> $production
        ]);
    }
}
