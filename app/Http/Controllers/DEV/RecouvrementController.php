<?php

namespace App\Http\Controllers\DEV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecouvrementController extends Controller
{
    public function index()
    {
        return view('back.recouvrements.soldes.dev');
    }

    public function creances()
    {
        return view('back.recouvrements.creances.dev');
    }

    public function dettes()
    {
        return view('back.recouvrements.dettes.dev');
    }

}

