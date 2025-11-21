<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BoutiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # code...
        $query = DB::table('boutiques as b')
            ->leftJoin('users as u','b.id','=','u.boutique_id')
            ->leftJoin('entreprises as e','b.entreprise_id','=','e.id')
            ->select('b.*', 'e.entreprise', DB::raw('COUNT(u.id) as total_users'))
            ->groupBy('b.id','b.boutique')
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
            'boutique' => 'required|min:3|max:100',
            'email' => 'nullable|unique:boutiques,email|email',
            'adresse' => 'required',
            'telephone' => 'required|unique:users,telephone',
            'responsable' => 'required',
            /* 'entreprise_id' => 'required' */
        ], [
            'boutique.required' => 'La boutique est obligatoire.',
            /* 'email.required' => 'Email obligatoire !', */
            'email.unique' => 'Cet email existe déjà !',
            'adresse.required' => 'Adresse obligatoire !.',
            'telephone.required' => 'N° Telephone obligatoire !',
            'telephone.unique' => 'Ce N° Telephone existe déjà !',
            'responsable.required' => 'Responsable obligatoire !',
            /* 'entreprise_id.required' => 'Rattachez-vous à une entreprise !' */
        ]);
           
        $data = DB::table('boutiques')->insert([
            'boutique' => $request->boutique,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'responsable' => $request->responsable,
            /* 'entreprise_id' => $request->entreprise_id, */
            'entreprise_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
      
        return response()->json([
            'success' => 'Boutique enregistrée avec succès !',
            'data' => $data,
            'status' => 201,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $data = DB::table('boutiques')
            ->where('id', $id)
            ->first();

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Boutique chargée avec succès !',
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
            'boutique' => 'required|min:3|max:100',
            'email' => 'required|unique:users,email|email'.$id,
            'adresse' => 'required',
            'telephone' => 'required|unique:users,telephone'.$id,
            'responsable' => 'required',
            'entreprise_id' => 'required'
        ], [
            'boutique.required' => 'La boutique est obligatoire.',
            'email.required' => 'Email obligatoire !',
            'email.unique' => 'Cet email existe déjà !',
            'adresse.required' => 'Adresse obligatoire !.',
            'telephone.required' => 'N° Telephone obligatoire !',
            'telephone.unique' => 'Ce N° Telephone existe déjà !',
            'responsable.required' => 'Responsable obligatoire !',
            'entreprise_id.required' => 'Rattachez-vous à une entreprise !'
        ]);
           
        $data = DB::table('boutiques')
            ->where('id', $id)
            ->update([
                'boutique' => $request->boutique,
                'adresse' => $request->adresse,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'responsable' => $request->responsable,
                'entreprise_id' => 1,
                'updated_at' => Carbon::now()
            ]);
        
        return response()->json([
            'success' => 'Boutique modifiée avec succès !',
            'data' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('boutiques')->where('id', $id)->delete();
        return response()->json(['success' => 'Boutique supprimée avec succès !']);
    }
}
