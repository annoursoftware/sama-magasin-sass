<?php

namespace App\Http\Controllers\DEV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionController extends Controller
{
    public function index() 
    {
        $categories = DB::table('categories')->get();
        $marques = DB::table('marques')->get();
        $boutiques = DB::table('boutiques')->get();
        return view('back.productions.dev', ['categories'=> $categories, 'marques'=>$marques, 'boutiques'=>$boutiques]);
    }

    /* Nouvelle production */
    public function nouvelle_production() 
    {
        $produits = DB::table('produits')->get();
        return view('back.productions.nouvelle_production', ['produits'=>$produits]);
    }
    
    /* Toutes les opérations de vente */
    public function operations() 
    {
        return view('back.productions.operations');
    }
    
    /* Details d'une vente */
    public function details($id) 
    {
        $production = DB::table('productions as p')
            ->join('users as u', 'u.id', 'p.user_id')
            ->select(
                'p.id',
                'p.num_production',
                'p.etat',
                'p.created_at',
                'u.name',
            )
            ->where('p.id', $id)
            ->first();

        $productions = DB::table('detail_productions as dp')
            ->join('productions as p', 'p.id', 'dp.production_id')
            ->join('produits as prod', 'prod.id', 'dp.produit_id')
            ->select('dp.*', 'prod.produit')
            ->where('p.id', $id)
            ->get();

        $nbre = DB::table('detail_productions')->where('production_id', $id)->count();
        $cumul = DB::table('detail_productions')->where('production_id', $id)->sum('quantite');

        return view('back.productions.details', ['production'=>$production, 'productions'=>$productions, 'nbre'=>$nbre, 'cumul'=>$cumul]);
    }
    
    /* Modification d'une vente */
    public function modification($id) 
    {
        $clients = DB::table('clients')->get();
        $articles = DB::table('articles')->get();

        $production = DB::table('productions as p')
            ->join('users as u', 'u.id', 'p.user_id')
            ->select(
                'p.*',
                'u.name',
            )
            ->where('p.id', $id)
            ->first();

        $productions = DB::table('detail_productions as dp')
            ->join('productions as p', 'p.id', 'dp.production_id')
            ->join('produits as prod', 'prod.id', 'dp.produit_id')
            ->select('dp.*', 'prod.produit')
            ->where('p.id', $id)
            ->get();

        $nbre = DB::table('detail_productions')->where('production_id', $id)->count();
        $cumul = DB::table('detail_productions')->where('production_id', $id)->sum('quantite');

        return view('back.productions.edition', [
            'clients'=>$clients,
            'articles'=>$articles,
            'production'=>$production,
            'productions'=>$productions,
            'nbre'=>$nbre,
            'cumul'=>$cumul
        ]);
    }
}