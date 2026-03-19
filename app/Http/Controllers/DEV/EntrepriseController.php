<?php

namespace App\Http\Controllers\DEV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EntrepriseController extends Controller
{
    public function index() 
    {
        return view('back.entreprises.dev');
    }
}
