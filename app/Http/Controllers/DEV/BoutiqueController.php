<?php

namespace App\Http\Controllers\DEV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoutiqueController extends Controller
{
    public function index() 
    {
        $entreprises = DB::table('entreprises')->get();
        return view('back.boutiques.dev', ['entreprises' => $entreprises]);
    }
}
