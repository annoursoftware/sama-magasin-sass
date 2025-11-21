<?php

namespace App\Http\Controllers\DEV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EncaissementController extends Controller
{
    public function index() 
    {
        $categories = DB::table('categories')->get();
        $marques = DB::table('marques')->get();
        $boutiques = DB::table('boutiques')->get();
        return view('back.achats.dev', ['categories'=> $categories, 'marques'=>$marques, 'boutiques'=>$boutiques]);
    }

    public function details() 
    {
        $query_1 = DB::table('encaissements as e')
            ->join('ventes as v', 'v.id', 'e.vente_id')
            ->join('clients as c', 'c.id', 'v.client_id')
            ->select(
                'e.id',
                'e.num_encaissement',
                'e.created_at',
                'e.etat',
                'e.vente_id',
                'e.prestation_id',
                'v.num_vente as num_production',
                'v.montant',
                'v.remise',
                'v.created_at as date_etablissement',
                'c.client',
                'c.telephone',
                'C.adresse'
            )
            ->where('e.id', operator: 4)
            ->first();

        $query_2 = DB::table('encaissements as e')
            ->join('prestations as p', 'p.id', 'e.prestation_id')
            ->join('clients as c', 'c.id', 'p.client_id')
            ->select(
                'e.id',
                'e.num_encaissement',
                'e.created_at',
                'e.etat',
                'e.vente_id',
                'e.prestation_id',
                'p.code_prestation as num_production',
                'p.montant',
                'p.remise',
                'p.created_at as date_etablissement',
                'c.client',
                'c.telephone',
                'c.adresse',
            )
            ->where('e.id', operator: 4)
            ->first();
            
        if (is_null($query_1)) {
            # code...
            $encaissement = $query_2;
            
            /* Prestation */
            $prestation = DB::table('encaissements as e')
                ->join('prestations as p', 'p.id', 'e.prestation_id')
                ->join('taches as t', 'p.id', 't.prestation_id')
                ->where('E.id', 4)
                ->sum(DB::raw('t.montant'));
                
            $montant_remise_prestation = $prestation * ($encaissement->remise / 100);
            $montant_final = $prestation - $montant_remise_prestation;
            /* Prestation */
        } else {
            # code...
            $encaissement = $query_1;
            
            /* Vente */
            $vente = DB::table('encaissements as e')
                ->join('ventes as v', 'v.id', 'e.vente_id')
                ->join('detail_ventes as dv', 'v.id', 'dv.vente_id')
                ->where('e.id', 4)
                ->sum(DB::raw('dv.montant*dv.quantite'));

            $montant_remise_vente = $vente * ($encaissement->remise / 100);
            $montant_final = $vente - $montant_remise_vente;
            /* Vente */
        }

        /* dd($encaissement); */

        $encaissements = DB::table('detail_encaissements as de')
            ->join('encaissements as e', 'e.id', 'de.encaissement_id')
            ->join('users as U', 'U.id', 'de.user_id')
            ->select('de.id', 'de.updated_at', 'de.mode_encaissement', 'de.ref_encaissement', 'de.montant', 'de.etat', 'de.created_at', 'u.name')
            ->where('e.id', 4)
            ->get();

        $production = $montant_final;
        return view('back.encaissements.details', [
            'encaissement'=> $encaissement,
            'encaissements'=> $encaissements,
            'production'=> $production
        ]);
    }

    public function edition() 
    {
        $query_1 = DB::table('encaissements as e')
            ->join('ventes as v', 'v.id', 'e.vente_id')
            ->join('clients as c', 'c.id', 'v.client_id')
            ->select(
                'e.id',
                'e.num_encaissement',
                'e.created_at',
                'e.etat',
                'e.vente_id',
                'e.prestation_id',
                'v.num_vente as num_production',
                'v.montant',
                'v.remise',
                'v.created_at as date_etablissement',
                'c.client',
                'c.telephone',
                'C.adresse'
            )
            ->where('e.id', operator: 4)
            ->first();

        $query_2 = DB::table('encaissements as e')
            ->join('prestations as p', 'p.id', 'e.prestation_id')
            ->join('clients as c', 'c.id', 'p.client_id')
            ->select(
                'e.id',
                'e.num_encaissement',
                'e.created_at',
                'e.etat',
                'e.vente_id',
                'e.prestation_id',
                'p.code_prestation as num_production',
                'p.montant',
                'p.remise',
                'p.created_at as date_etablissement',
                'c.client',
                'c.telephone',
                'c.adresse',
            )
            ->where('e.id', operator: 4)
            ->first();
            
        if (is_null($query_1)) {
            # code...
            $encaissement = $query_2;
            
            /* Prestation */
            $prestation = DB::table('encaissements as e')
                ->join('prestations as p', 'p.id', 'e.prestation_id')
                ->join('taches as t', 'p.id', 't.prestation_id')
                ->where('E.id', 4)
                ->sum(DB::raw('t.montant'));
                
            $montant_remise_prestation = $prestation * ($encaissement->remise / 100);
            $montant_final = $prestation - $montant_remise_prestation;
            /* Prestation */
        } else {
            # code...
            $encaissement = $query_1;
            
            /* Vente */
            $vente = DB::table('encaissements as e')
                ->join('ventes as v', 'v.id', 'e.vente_id')
                ->join('detail_ventes as dv', 'v.id', 'dv.vente_id')
                ->where('e.id', 4)
                ->sum(DB::raw('dv.montant*dv.quantite'));

            $montant_remise_vente = $vente * ($encaissement->remise / 100);
            $montant_final = $vente - $montant_remise_vente;
            /* Vente */
        }

        /* dd($encaissement); */

        $encaissements = DB::table('detail_encaissements as de')
            ->join('encaissements as e', 'e.id', 'de.encaissement_id')
            ->join('users as U', 'U.id', 'de.user_id')
            ->select('de.id', 'de.updated_at', 'de.mode_encaissement', 'de.ref_encaissement', 'de.montant', 'de.etat', 'de.created_at', 'u.name')
            ->where('e.id', 4)
            ->get();

        $production = $montant_final;
        return view('back.encaissements.edition', [
            'encaissement'=> $encaissement,
            'encaissements'=> $encaissements,
            'production'=> $production
        ]);
    }
}
