<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MarqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # code...
        $query = DB::table('marques as m')
            ->leftJoin('articles as a','m.id','=','a.marque_id')
            ->select('m.*', DB::raw('COUNT(a.id) as total_articles'))
            ->groupBy('m.id','m.marque')
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
               
                /* $btn = '<a onclick="showData('.$row->id.')" class="show btn btn-warning btn-flat btn-sm"><i class="bi bi-eye-fill"></i></a>';
                $btn .= ' <a onclick="editData('.$row->id.')" class="edit btn btn-primary btn-flat btn-sm"><i class="bi bi-pencil-fill"></i></a>';
                $btn .= ' <a onclick="deleteData('.$row->id.')" class="delete btn btn-danger btn-flat btn-sm"><i class="bi bi-trash-fill"></i></a>'; */
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
            'marque' => 'required|unique:marques,marque'
        ], [
            'marque.required' => 'La marque est obligatoire.',
            'marque.unique' => 'Cette marque existe déjà.',
        ]);
           
        $data = DB::table('marques')->insert([
            'marque' => $request->marque,
            'user_id' => /* $request->categorie */1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
      
        return response()->json([
            'success' => 'Marque enregistrée avec succès !',
            'data' => $data,
            'status' => 201,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $data = DB::table('marques')
            ->where('id', $id)
            ->first();

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Marque chargée avec succès !',
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
            'marque' => 'required|unique:marques,marque,'.$id
        ], [
            'marque.required' => 'La catégorie est obligatoire.',
            'marque.unique' => 'Cette catégorie existe déjà.',
        ]);
           
        $data = DB::table('marques')
            ->where('id', $id)
            ->update([
                'marque' => $request->marque,
                'updated_at' => Carbon::now()
            ]);
        
        return response()->json([
            'success' => 'Marque modifiée avec succès !',
            'data' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('marques')->where('id', $id)->delete();
        return response()->json(['success' => 'Marque supprimée avec succès !']);
    }
}
