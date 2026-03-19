<?php

namespace App\Http\Controllers\DEV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index() 
    {
        $users = DB::table("users")->get();
        $boutiques = DB::table("boutiques")->get();
        $roles = DB::table("roles")->get();
        
        return view('back.utilisateurs.dev', [
            'users'=> $users, 
            'boutiques'=>$boutiques,
            'roles' => $roles
        ]);
    }
}
