<?php

namespace App\Http\Controllers\DEV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AchatController extends Controller
{
    public function index() 
    {
        $categories = DB::table('categories')->get();
        $marques = DB::table('marques')->get();
        $boutiques = DB::table('boutiques')->get();
        return view('back.achats.dev', ['categories'=> $categories, 'marques'=>$marques, 'boutiques'=>$boutiques]);
    }
        
    /* Nouvel achat */
    public function nouvel_achat() 
    {
        $fournisseurs = DB::table('fournisseurs')->get();
        $articles = DB::table('articles')->get();
        return view('back.achats.nouvel_achat', ['fournisseurs'=>$fournisseurs, 'articles'=>$articles]);
    }

    /* Toutes les opérations de vente */
    public function operations() 
    {
        return view('back.achats.operations');
    }
    
    /* Details d'une vente */
    public function details($id) 
    {
        $achat = DB::table('achats as a')
                ->join('fournisseurs as f', 'f.id', 'a.fournisseur_id')
                ->join('users as u', 'u.id', 'a.user_id')
                ->select(
                    'a.*',
                    'u.name',
                    'f.fournisseur',
                    'f.adresse',
                    'f.telephone as telephone_primaire',
                )
                ->where('a.id', $id)
                ->first();

            $achats = DB::table('detail_achats as da')
                ->join('achats as a', 'a.id', 'da.achat_id')
                ->join('articles as art', 'art.id', 'da.article_id')
                ->select('da.*', 'art.article')
                ->where('a.id', $id)
                ->get();

            $nbre = DB::table('detail_achats')->where('achat_id', $id)->count();

            $montant = DB::table('detail_achats')->where('achat_id', $id)->sum(DB::raw('montant*quantite'));
            $mt_remise = $montant * ($achat->remise / 100);

            $decaissement = DB::table('achats as a')
                ->join('decaissements as d', 'd.achat_id', 'a.id')
                ->join('detail_decaissements as dd', 'dd.decaissement_id', 'd.id')
                ->where('a.id', $id)
                ->sum('dd.montant');

        return view('back.achats.details', ['achat'=>$achat, 'achats'=>$achats, 'nbre'=>$nbre, 'montant'=>$montant, 'mt_remise'=>$mt_remise, 'decaissement'=>$decaissement]);
    }
    
    /* Modification d'une vente */
    public function modification($id) 
    {
        $articles = DB::table('articles')->get();
        $fournisseurs = DB::table('fournisseurs')->get();

        $achat = DB::table('achats as a')
                ->join('fournisseurs as f', 'f.id', 'a.fournisseur_id')
                ->join('users as u', 'u.id', 'a.user_id')
                ->select(
                    'a.*',
                    'u.name',
                    'f.fournisseur',
                    'f.adresse',
                    'f.telephone',
                )
                ->where('a.id', $id)
                ->first();

        $achats = DB::table('detail_achats as da')
            ->join('achats as a', 'a.id', 'da.achat_id')
            ->join('articles as art', 'art.id', 'da.article_id')
            ->select('da.*', 'art.article')
            ->where('a.id', $id)
            ->get();

        $nbre = DB::table('detail_achats')->where('achat_id', $id)->count();

        $montant = DB::table('detail_achats')->where('achat_id', $id)->sum(DB::raw('montant*quantite'));
        $mt_remise = $montant * ($achat->remise / 100);

        $decaissement = DB::table('achats as a')
            ->join('decaissements as d', 'd.achat_id', 'a.id')
            ->join('detail_decaissements as dd', 'dd.decaissement_id', 'd.id')
            ->where('a.id', $id)
            ->sum('dd.montant');

        return view('back.achats.edition', [
            'fournisseurs'=>$fournisseurs,
            'articles'=>$articles,
            'achat'=>$achat,
            'achats'=>$achats,
            'nbre'=>$nbre,
            'montant'=>$montant,
            'mt_remise'=>$mt_remise,
            'decaissement'=>$decaissement
        ]);
    }
}
