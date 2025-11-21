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
        return view('back.roles.users', ['users'=> $users, 'boutiques'=>$boutiques]);
    }
}
