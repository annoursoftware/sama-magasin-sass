<?php

namespace App\Http\Controllers\DEV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepenseController extends Controller
{
    /* Toutes les dépenses */
    public function index() 
    {
        $entreprises = DB::table('entreprises')->get();
        return view('back.depenses.dev', ['entreprises' => $entreprises]);
    }

    /* Nouvelle dépense */
    public function nouvelle_depense() 
    {
       $beneficiaires = DB::table('beneficiaires')->get();
        $boutiques = DB::table('boutiques')->get();
        return view('back.depenses.nouvelle_depense', ['beneficiaires'=>$beneficiaires, 'boutiques'=>$boutiques]);
    }

}
