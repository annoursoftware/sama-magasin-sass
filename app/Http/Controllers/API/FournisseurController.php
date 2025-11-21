<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # code...
        $query = DB::table('fournisseurs as f')
            ->leftJoin('achats as a','f.id','=','a.fournisseur_id')
            ->select('f.id', 'f.fournisseur', 'f.type', 'f.etat', DB::raw(value: 'SUM(a.montant) as total'), DB::raw('MAX(a.id) as m_id'))
            ->groupBy('f.id', 'f.fournisseur', 'f.type', 'f.etat')
            ->get();

        if ($request->ajax()) {    
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                
                $btn =  '<div class="btn-group">';
                $btn .= '<button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>';
                $btn .= '<div class="dropdown-menu" style="">';
                $btn .= '<a onclick="showData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-eye-fill"></i> Détails</a>';
                $btn .= '<a onclick="editData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-pencil-fill"></i> Edition</a>';
                $btn .= '<a onclick="deleteData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-trash-fill"></i> Suppression</a>';
                $btn .= '</div>';
                $btn .= '</div>';
               
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
            'fournisseur' => 'required|min:3|max:150',
            'type' => 'required',
            'telephone' => 'nullable|min:9|max:15',
            'email' => 'nullable|unique:fournisseurs,email|email',
            'adresse' => 'nullable|min:5|max:150',
            /* 'boutique_id' => 'required|integer' */
        ], [
            'fournisseur.required' => 'Le fournisseur est obligatoire.',
            'fournisseur.min' => 'Le fournisseur doit être au minimum de 3 caractéres.',
            'fournisseur.max' => 'Le fournisseur doit être au maximum de 150 caractéres.',
            'type.required' => 'Le type est obligatoire.',
            'telephone.min' => 'Le telephone doit être au minimum de 3 caractéres.',
            'telephone.max' => 'Le telephone doit être au maximum de 150 caractéres.',
            'email.unique' => 'Cet email existe déjà !',
            'email.email' => 'Saisissez une adresse mail correcte !',
            'adresse.min' => "L'adresse doit être au minimum de 3 caractéres.",
            'adresse.max' => "L'adresse doit être au maximum de 150 caractéres.",
            /* 'boutique_id.required' => 'Rattachez-vous à une boutique !',
            'boutique_id.integer' => 'boutique_id doit être un entier !' */
        ]);
           
        $data = DB::table('fournisseurs')->insert([
            'fournisseur' => $request->fournisseur,
            'type' => $request->type,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'adresse' => $request->adresse,
            'ninea' => $request->ninea,
            'rc' => $request->rc,
            'regime_juridique' => $request->regime_juridique,
            /* 'boutique_id' => $request->boutique_id, */
            /* 'user_id' => $request->user_id, */
            'boutique_id' => 1,
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
      
        return response()->json([
            'success' => 'Fournisseur enregistré avec succès !',
            'data' => $data,
            'status' => 201,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $data = DB::table('fournisseurs')
            ->where('id', $id)
            ->first();

        if ($request->ajax()) {
            return response()->json([
                'success' => 'fournisseur chargé avec succès !',
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
            'fournisseur' => 'required|min:3|max:150',
            'type' => 'required',
            'telephone' => 'nullable|min:9|max:15',
            'email' => 'nullable|unique:fournisseurs,email|email'.$id,
            'adresse' => 'nullable|min:5|max:150',
            'boutique_id' => 'required|integer'
        ], [
            'fournisseur.required' => 'Le fournisseur est obligatoire.',
            'fournisseur.min' => 'Le fournisseur doit être au minimum de 3 caractéres.',
            'fournisseur.max' => 'Le fournisseur doit être au maximum de 150 caractéres.',
            'telephone.min' => 'Le telephone doit être au minimum de 3 caractéres.',
            'telephone.max' => 'Le telephone doit être au maximum de 150 caractéres.',
            'email.unique' => 'Cet email existe déjà !',
            'email.email' => 'Saisissez une adresse mail correcte !',
            'adresse.min' => "L'adresse doit être au minimum de 3 caractéres.",
            'adresse.max' => "L'adresse doit être au maximum de 150 caractéres.",
            'boutique_id.required' => 'Rattachez-vous à une boutique !',
            'boutique_id.integer' => 'boutique_id doit être un entier !'
        ]);
           
        $data = DB::table('fournisseurs')
            ->where('id', $id)
            ->update([
                'fournisseur' => $request->fournisseur,
                'type' => $request->type,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'adresse' => $request->adresse,
                /* 'boutique_id' => $request->boutique_id, */
                /* 'user_id' => $request->user_id, */
                'entreprise_id' => 1,
                'user_id' => 1,
                'updated_at' => Carbon::now(),
            ]);
        
        return response()->json([
            'success' => 'Fournisseur modifié avec succès !',
            'data' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('fournisseurs')->where('id', $id)->delete();
        return response()->json(['success' => 'fournisseur supprimé avec succès !']);
    }

}
