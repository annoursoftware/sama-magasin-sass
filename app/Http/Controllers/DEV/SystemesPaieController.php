<?php

namespace App\Http\Controllers\DEV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemesPaieController extends Controller
{
    public function index() 
    {
        $nombre_espece = DB::table('moyens_paiements')->where('systeme', 'espece')->count();
        return view('back.systemes_paies.dev', ['nombre_espece'=>$nombre_espece]);
    }
}
