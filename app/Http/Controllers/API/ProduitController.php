<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Entreprise;
use App\Models\Produit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # code...
        $query = DB::table('produits as p')
            ->join('categories as c','p.categorie_id','=','c.id')
            /* ->leftJoin('users as u','b.id','=','u.boutique_id') */
            ->select('p.*', 'c.categorie',
                /* DB::raw('COUNT(p.id) as total_categories'), */
                /* DB::raw('COUNT(u.id) as total_users'), */
            )
            ->groupBy('p.id','p.produit')
            ->get();

        if ($request->ajax()) {    
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('Image', function ($row) {
                if (is_null($row->image)) {
                    return '<img class="rounded-square" width="50" height="50" src="' . asset("no-img.jpg").'" alt="">';
                } else {
                    return '<a href="' . url("/upload/Produits/Images/".$row->image).'" data-toggle="lightbox" data-title="'.$row->produit.'" data-footer="produit-'.$row->image.'" data-max-width="500">
                                <img class="rounded-square" width="30" height="30" src="' . asset("/upload/Produits/Images/".$row->image).'" alt="'.$row->image.'">
                            </a>';
                }
            })
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
            ->rawColumns(['Image', 'action'])
            ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'produit' => 'required',
            'prix_vente_minimal' => 'required|numeric',
            'categorie_id' => 'nullable|integer',
            'boutique_id' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,jpg,gif,svg|max:2048',
        ], [
            'produit.required' => "Le produit est obligatoire.",
            'prix_vente_minimal.required' => 'Prix vente minimal obligatoire !',
            'prix_vente_minimal.numeric' => 'Prix vente minimal doit être un nombre !',
            'categorie_id.required' => "La Catégorie est obligatoire.",
            'categorie_id.integer' => "La Catégorie_id doit être un nombre.",
            'boutique_id.required' => "La boutique est obligatoire.",
            'boutique_id.integer' => "La boutique_id doit être un nombre.",
        ]);
           
        /* $data = DB::table('entreprises')->insert([
            'entreprise' => $request->entreprise,
            'siege' => $request->siege,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'responsable' => $request->responsable,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]); */

        $data = new Produit();
        $data->produit = $request->produit;
        $data->prix_vente_minimal = $request->prix_vente_minimal;
        $data->localisation = $request->localisation;
        $data->categorie_id = $request->categorie_id;
        $data->boutique_id = $request->boutique_id;
        $data->user_id = /* $request->user_id */1;

        $recherche_boutique = DB::table("boutiques")->where("id", $request->boutique_id)->first();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $destination = public_path() . "/upload/Produits/Images/";
            $file->move($destination, Str::slug($request->produit).'-'.Str::slug($recherche_boutique->boutique).'-'.time().'.'.$file->getClientOriginalExtension());
            $data->image = Str::slug($request->produit).'-'.Str::slug($recherche_boutique->boutique).'-'.time().'.'.$file->getClientOriginalExtension();
        } else {
            $data->image = null;
        }

        /* if ($request->hasFile('logo')) {
            $file = $request->file('logo');

            $originalCoverImage = Image::make($file);
            $coverImage = Image::make($file)->resize(397, 467);
            $thumbCoverImage = Image::make($file)->resize(75, 75);

            $OriginalcoverPath = public_path() . "/upload/Produit/original/";
            $coverPath = public_path() . "/upload/Produit/";
            $thumbCoverPath = public_path() . "/upload/Produit/thumbs/";

            $coverImage->save($coverPath . $file->getClientOriginalName());
            $thumbCoverImage->save($thumbCoverPath . $file->getClientOriginalName());
            $originalCoverImage->save($OriginalcoverPath . $file->getClientOriginalName());

            $produit->image = $file->getClientOriginalName();
        } else {
            $produit->image = NULL;
        } */

        $data->save();
      
        return response()->json([
            'success' => 'Produit enregistré avec succès !',
            'data' => $data,
            'status' => 201,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $data = DB::table('produits as p')
            ->join('categories as c','p.categorie_id','=','c.id')
            ->join('boutiques as b','p.boutique_id','=','b.id')
            ->select('p.*', 'c.categorie', 'b.boutique')
            ->where('p.id', $id)
            ->first();

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Produit chargé avec succès !',
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
            'produit' => 'required',
            'prix_vente_minimal' => 'required|numeric',
            'categorie_id' => 'required|integer',
            'boutique_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,jpg,gif,svg|max:2048',
        ], [
            'produit.required' => "Le produit est obligatoire.",
            'prix_vente_minimal.required' => 'Prix vente minimal obligatoire !',
            'prix_vente_minimal.numeric' => 'Prix vente minimal doit être un nombre !',
            'categorie_id.required' => "La Catégorie est obligatoire.",
            'categorie_id.integer' => "La Catégorie_id doit être un nombre.",
            'boutique_id.required' => "La boutique est obligatoire.",
            'boutique_id.integer' => "La boutique_id doit être un nombre.",
        ]);
        
        $data = DB::table('produits')
            ->where('id', $id)
            ->update([
                'produit' => $request->produit,
                'prix_vente_minimal' => $request->prix_vente_minimal,
                'categorie_id' => $request->categorie_id,
                'boutique_id' => $request->boutique_id,
                'updated_at' => Carbon::now()
            ]);
        
        return response()->json([
            'success' => 'Produit modifié avec succès !',
            'data' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('produits')->where('id', $id)->delete();
        return response()->json(['success' => 'Produit supprimé avec succès !']);
    }

    /**
     * Change state the specified resource from storage.
     */
    public function modification_etat_produit(Request $request, string $id) {
        if ($request->etat==1) {
            # code...
            DB::table('produits')->where('id', $id)->update(
                [
                    'etat' => 0,
                    'desactive_le' => Carbon::now(),
                ]
            );
        } else {
            # code...
            DB::table('produits')->where('id', $id)->update(
                [
                    'etat' => 1,
                    'reactive_le' => Carbon::now(),
                ]
            );
        }
        
        
    }
}
