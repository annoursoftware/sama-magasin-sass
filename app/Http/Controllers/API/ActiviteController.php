<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Entreprise;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ActiviteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # code...
        $query = DB::table('activites as a')
            ->join('categories as c','a.categorie_id','=','c.id')
            /* ->leftJoin('users as u','b.id','=','u.boutique_id') */
            ->select('a.*', 'c.categorie'
                /* DB::raw('COUNT(u.id) as total_users'), */
            )
            ->groupBy('a.id','a.activite')
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
                $btn .= '<a onclick="deleteData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-hand-thumbs-down"></i> Désactivation</a>';
                $btn .= '</div>';
                $btn .= '</div>';

                $btn_1 =  '<div class="btn-group">';
                $btn_1 .= '<button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>';
                $btn_1 .= '<div class="dropdown-menu" style="">';
                $btn_1 .= '<a onclick="showData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-eye-fill"></i> Détails</a>';
                $btn_1 .= '<a onclick="editData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-pencil-fill"></i> Edition</a>';
                $btn_1 .= '<a onclick="deleteData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-trash-fill"></i> Suppression</a>';
                $btn_1 .= '<a onclick="deleteData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-hand-thumbs-up"></i> Réactivation</a>';
                $btn_1 .= '</div>';
                $btn_1 .= '</div>';

                if ($row->etat == 0) {
                    # code...
                    return $btn;
                } else {
                    # code...
                    return $btn_1;
                }
                
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
            'activite' => 'required',
            'montant' => 'required|numeric',
            'categorie_id' => 'nullable|integer',
            'boutique_id' => 'nullable|integer',
        ], [
            'activite.required' => "L'activité est obligatoire.",
            'montant.required' => 'Le montant est obligatoire !',
            'montant.numeric' => 'Le montant doit être un nombre !',
            'categorie_id.required' => "La Catégorie est obligatoire.",
            'categorie_id.integer' => "La Catégorie_id doit être un nombre.",
            'boutique_id.required' => "La boutique est obligatoire.",
            'boutique_id.integer' => "La boutique_id doit être un nombre.",
        ]);
           
        $data = DB::table('activites')->insert([
            'activite' => $request->activite,
            'montant' => $request->montant,
            'categorie_id' => $request->categorie_id,
            'user_id' => $request->user_id,
            'boutique_id' => $request->boutique_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
      
        return response()->json([
            'success' => 'Prestation enregistrée avec succès !',
            'data' => $data,
            'status' => 201,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $data = DB::table('activites as a')
            ->join('categories as c','a.categorie_id','=','c.id')
            ->join('boutiques as b','a.boutique_id','=','b.id')
            ->select('a.*', 'c.categorie', 'b.boutique')
            ->where('a.id', $id)
            ->first();

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Activité chargée avec succès !',
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
            'activite' => 'required',
            'montant' => 'required|numeric',
            'categorie_id' => 'nullable|integer',
            'boutique_id' => 'nullable|integer',
        ], [
            'activite.required' => "L'activité est obligatoire.",
            'montant.required' => 'Le montant est obligatoire !',
            'montant.numeric' => 'Le montant doit être un nombre !',
            'categorie_id.required' => "La Catégorie est obligatoire.",
            'categorie_id.integer' => "La Catégorie_id doit être un nombre.",
            'boutique_id.required' => "La boutique est obligatoire.",
            'boutique_id.integer' => "La boutique_id doit être un nombre.",
        ]);
           
        $data = DB::table('activites')
            ->where('id', $id)
            ->update([
                'activite' => $request->activite,
                'montant' => $request->montant,
                'categorie_id' => $request->categorie_id,
                'user_id' => $request->user_id,
                'boutique_id' => $request->boutique_id,
                'updated_at' => Carbon::now()
            ]);
        
        return response()->json([
            'success' => 'Activité modifiée avec succès !',
            'data' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('activites')->where('id', $id)->delete();
        return response()->json(['success' => 'Activité supprimée avec succès !']);
    }

    /**
     * Change state the specified resource from storage.
     */
    public function modificationEtatActivite(Request $request, string $id) {
        if ($request->etat==1) {
            # code...
            DB::table('activites')->where('id', $id)->update(
                [
                    'etat' => 0,
                    'desactive_le' => Carbon::now(),
                ]
            );
        } else {
            # code...
            DB::table('activites')->where('id', $id)->update(
                [
                    'etat' => 1,
                    'reactive_le' => Carbon::now(),
                ]
            );
        }
        
        
    }
}
