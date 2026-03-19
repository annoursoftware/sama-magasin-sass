<?php

namespace App\Http\Controllers\DEV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VenteController extends Controller
{
    public function index() 
    {
        $categories = DB::table('categories')->get();
        $marques = DB::table('marques')->get();
        $boutiques = DB::table('boutiques')->get();
        return view('back.ventes.dev', ['categories'=> $categories, 'marques'=>$marques, 'boutiques'=>$boutiques]);
    }

    /* Nouveau devis */
    public function nouveau_devis() 
    {
        $clients = DB::table('clients')->get();
        $articles = DB::table('articles')->get();
        return view('back.ventes.nouveau_devis', ['clients'=>$clients, 'articles'=>$articles]);
    }
        
    /* Nouvelle vente */
    public function nouvelle_vente() 
    {
        $clients = DB::table('clients')->get();
        $articles = DB::table('articles')->get();
        return view('back.ventes.nouvelle_vente', ['clients'=>$clients, 'articles'=>$articles]);
    }

    /* Toutes les opérations de vente */
    public function operations() 
    {
        return view('back.ventes.operations');
    }
    
    /* Toutes les opérations de vente */
    public function tracking() 
    {
        return view('back.ventes.tracking');
    }

    /* Details d'une vente */
    public function details($id) 
    {
        $vente = DB::table('ventes as v')
                ->join('clients as cli', 'cli.id', 'v.client_id')
                ->join('users as u', 'u.id', 'v.user_id')
                ->select(
                    'v.id',
                    'v.num_vente',
                    'v.status_vente',
                    'v.etat',
                    'v.montant',
                    'v.remise',
                    'v.created_at',
                    'u.name',
                    'cli.client',
                    'cli.adresse',
                    'cli.telephone as telephone_primaire',
                )
                ->where('v.id', $id)
                ->first();

        $ventes = DB::table('detail_ventes as dv')
            ->join('ventes as v', 'v.id', 'dv.vente_id')
            ->join('articles as a', 'a.id', 'dv.article_id')
            ->select('dv.*', 'a.article')
            ->where('v.id', $id)
            ->get();

        $nbre = DB::table('detail_ventes')->where('vente_id', $id)->count();

        $montant = DB::table('detail_ventes')->where('vente_id', $id)->sum(DB::raw('montant*quantite'));
        $mt_remise = $montant * ($vente->remise / 100);

        $encaissement = DB::table('ventes as v')
            ->join('encaissements as E', 'E.vente_id', 'v.id')
            ->join('detail_encaissements as DE', 'DE.encaissement_id', 'E.id')
            ->where('v.id', $id)
            ->sum('DE.montant');

        return view('back.ventes.details', ['vente'=>$vente, 'ventes'=>$ventes, 'nbre'=>$nbre, 'montant'=>$montant, 'mt_remise'=>$mt_remise, 'encaissement'=>$encaissement]);
    }
    
    /* Modification d'une vente */
    public function modification($id) 
    {
        $clients = DB::table('clients')->get();
        $articles = DB::table('articles')->get();

        $vente = DB::table('ventes as v')
            ->join('clients as cli', 'cli.id', 'v.client_id')
            ->join('users as u', 'u.id', 'v.user_id')
            ->select(
                'v.id',
                'v.num_vente',
                'v.etat',
                'v.montant',
                'v.remise',
                'v.created_at',
                'client_id',
                'status_vente',
                'u.name',
                'cli.client',
                'cli.adresse',
                'cli.telephone',
            )
            ->where('v.id', $id)
            ->first();

        $ventes = DB::table('detail_ventes as dv')
            ->join('ventes as v', 'v.id', 'dv.vente_id')
            ->join('articles as a', 'a.id', 'dv.article_id')
            ->select(
                'dv.*',
                'a.article'
            )
            ->where('v.id', $id)
            ->get();


        $nbre = DB::table('detail_ventes')->where('vente_id', $id)->count();

        $montant = DB::table('detail_ventes')->where('vente_id', $id)->sum(DB::raw('montant*quantite'));
        $mt_remise = $montant * ($vente->remise / 100);

        $encaissement = DB::table('ventes as v')
            ->join('encaissements as E', 'E.vente_id', 'v.id')
            ->join('detail_encaissements as DE', 'DE.encaissement_id', 'E.id')
            ->where('v.id', $id)
            ->sum('DE.montant');

        return view('back.ventes.edition', [
            'clients'=>$clients,
            'articles'=>$articles,
            'vente'=>$vente,
            'ventes'=>$ventes,
            'nbre'=>$nbre,
            'montant'=>$montant,
            'mt_remise'=>$mt_remise,
            'encaissement'=>$encaissement
        ]);
    }
}