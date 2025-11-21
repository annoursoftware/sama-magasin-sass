<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DropdownController extends Controller
{
    public function mode_encaissement(Request $request)
    {
        $systeme_encaissement = $request->systeme_encaissement;
        $moyens = DB::table('moyens_paiements')->where('systeme', $systeme_encaissement)->get();
        return response()->json($moyens);
    }
    
    public function infos_client(Request $request)
    {
        $client = $request->id;
        $infos = DB::table('clients as c')->where('c.id', $client)->first();
        return response()->json($infos);
    }
    
    public function infos_fournisseur(Request $request)
    {
        $fournisseur = $request->id;
        $infos = DB::table('fournisseurs as f')->where('f.id', $fournisseur)->first();
        return response()->json($infos);
    }

    public function infos_beneficiaire(Request $request)
    {
        $beneficiaire = $request->id;
        $infos = DB::table('beneficiaires as b')->where('b.id', $beneficiaire)->first();
        return response()->json($infos);
    }

    public function infos_article(Request $request)
    {
        $article = $request->id;
        $infos = DB::table('articles as a')->where('a.id', $article)->first();
        return response()->json($infos);
    }
    
    public function infos_produit(Request $request)
    {
        $produit = $request->id;
        $infos = DB::table('produits as p')->where('p.id', $produit)->first();
        return response()->json($infos);
    }

    public function infos_activite(Request $request)
    {
        $activite = $request->id;
        $infos = DB::table('activites as a')->where('a.id', $activite)->first();
        return response()->json($infos);
    }
}
