<?php

namespace App\Http\Controllers\DEV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IngredientController extends Controller
{
    public function index() 
    {
        $categories = DB::table('categories')->get();
        $boutiques = DB::table('boutiques')->get();
        return view('back.ingredients.dev', ['categories'=> $categories, 'boutiques'=>$boutiques]);
    }
}
