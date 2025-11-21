<?php

namespace App\Http\Controllers\DEV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActiviteController extends Controller
{
    public function index() 
    {
        $categories = DB::table('categories')->get();
        $boutiques = DB::table('boutiques')->get();
        return view('back.activites.dev', ['categories'=> $categories, 'boutiques'=>$boutiques]);
    }
}
