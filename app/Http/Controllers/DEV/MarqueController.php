<?php

namespace App\Http\Controllers\DEV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarqueController extends Controller
{
    public function index() 
    {
        return view('back.marques.dev');
    }
}
