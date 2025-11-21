<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # code...
        $query = DB::table('users as u')
            ->leftJoin('roles as r','r.id','=','u.role_id')
            ->leftJoin('boutiques as b','b.id','=','u.boutique_id')
            ->select('u.*', 'r.role', 'b.boutique')
            ->get();

        if ($request->ajax()) {    
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a onclick="showData('.$row->id.')" class="show btn btn-warning btn-flat btn-sm"><i class="bi bi-eye-fill"></i></a>';
                $btn .= ' <a onclick="editData('.$row->id.')" class="edit btn btn-primary btn-flat btn-sm"><i class="bi bi-pencil-fill"></i></a>';
                $btn .= ' <a onclick="deleteData('.$row->id.')" class="delete btn btn-danger btn-flat btn-sm"><i class="bi bi-trash-fill"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5|max:100',
            'email' => 'required|unique:users,email|email',
            'sexe' => 'required',
            'username' => 'required|unique:users,username|alpha_num',
            'telephone' => 'required|unique:users,telephone',
            'adresse' => 'required',
            'role_id' => 'required',
            'boutique_id' => 'required',
            'password' => [
                'required', 
                'confirmed',
                Password::min(12)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'Email obligatoire !',
            'email.unique' => 'Cet email existe déjà !',
            'sexe.required' => 'Sexe obligatoire !.',
            'username.required' => 'Username obligatoire !',
            'username.unique' => 'Ce username existe déjà !',
            'telephone.required' => 'Téléphone obligatoire !',
            'telephone.unique' => 'Ce N° Telephone existe déjà !',
            'adresse.required' => 'Adresse obligatoire !',
            'role_id.required' => 'Role obligatoire !',
            'boutique_id.required' => 'Boutique obligatoire !',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.confirmed' => 'Le mot de passe doit être confirmé !',
            'password.min' => 'Le mot de passe doit être >= 12 caractéres !',
            'password.letters' => 'Le mot de passe doit contenir au moins une lettre !',
            'password.mixedCase' => 'Le mot de passe doit contenir au moins une lettre majuscule et une lettre minuscule !',
            'password.numbers' => 'Le mot de passe doit contenir au moins un nombre !',
            'password.symbols' => 'Le mot de passe doit contenir au moins un caractére spécial !',
        ]);
           
        $data = DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'sexe' => $request->sexe,
            'role_id' => $request->role_id,
            'boutique_id' => $request->boutique_id,
            'adresse' => $request->adresse,
            'indicatif' => $request->indicatif,
            'telephone' => $request->telephone,
            'telephone_secondaire' => $request->telephone_secondaire,
            'responsable' => isset($request->responsable) ? 1 : 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
      
        return response()->json([
            'success' => 'Utilisateur enregistré avec succès !',
            'data' => $data,
            'status' => 201,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $data = DB::table('users')
            ->where('id', $id)
            ->first();

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Utilisateur chargé avec succès !',
                'data' => $data,
                'status' => 200,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:5|max:100|alpha_num',
            'email' => 'required|unique:users,email|email'.$id,
            'sexe' => 'required',
            'username' => 'required|unique:users,username'.$id,
            'role_id' => 'required',
            'boutique_id' => 'required',
            'password' => [
                'required', 
                'confirmed',
                Password::min(12)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ], params: [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'Email obligatoire !',
            'email.unique' => 'Cet email existe déjà !',
            'sexe.required' => 'Sexe obligatoire !.',
            'username.required' => 'Username obligatoire !',
            'username.unique' => 'Ce username existe déjà !',
            'role_id.required' => 'Role obligatoire !',
            'boutique_id.required' => 'Boutique obligatoire !',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.confirmed' => 'Le mot de passe doit être confirmé !',
        ]);
           
        $data = DB::table('users')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'sexe' => $request->sexe,
                'role_id' => $request->role_id,
                'boutique_id' => $request->boutique_id,
                'adresse' => $request->adresse,
                'indicatif' => $request->indicatif,
                'telephone' => $request->telephone,
                'telephone_secondaire' => $request->telephone_secondaire,
                'responsable' => $request->responsable,
                'updated_at' => Carbon::now()
            ]);
        
        return response()->json([
            'success' => 'Utilisateur modifié avec succès !',
            'data' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('users')->where('id', $id)->delete();
        return response()->json(['success' => 'Utilisateur supprimé avec succès !']);
    }

    /* Check unique Email */
    public function checkEmail(Request $request){
        $email = $request->input('email');
        $user = DB::table('users')->where('email', $email)->first();

        if ($user) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    /* Check unique Username */
    public function checkUsername(Request $request){
        $username = $request->input('username');
        $user = DB::table('users')->where('username', $username)->first();

        if ($user) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    /* Check unique Username */
    public function checkTelephone(Request $request){
        $telephone = $request->input('telephone');
        $user = DB::table('users')->where('telephone', $telephone)->first();

        if ($user) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
}
