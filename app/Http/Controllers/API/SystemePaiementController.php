<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Entreprise;
use App\Models\MoyensPaiement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class SystemePaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # code...
        $query = DB::table('moyens_paiements as m')
            ->join('users as u','m.user_id','=','u.id')
            ->select('m.*', 'u.name')
            ->get();

        if ($request->ajax()) {    
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('Image', function ($row) {
                if (is_null($row->image)) {
                    return '<img class="rounded-square" width="50" height="50" src="' . asset("no-img.jpg").'" alt="">';
                } else {
                    return '<a href="' . url("/upload/Systemes_Paie/Images/".$row->image).'" data-toggle="lightbox" data-title="'.$row->entite.'" data-footer="logo-'.$row->image.'" data-max-width="500">
                                <img class="rounded-square" width="30" height="30" src="' . asset("/upload/Systemes_Paie/Images/".$row->image).'" alt="'.$row->image.'">
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
                $btn .= '</div>';
                $btn .= '</div>';

                return $btn;
                
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
            'system_paiement' => 'required',
            'entite_paiement' => 'required|unique:moyens_paiements,entite|min:2|max:75',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,jpg,gif,svg|max:2048',
        ], [
            'system_paiement.required' => "Le systéme de paiement est obligatoire.",
            'entite_paiement.required' => "L'entité de paiement est obligatoire !",
            'entite_paiement.unique' => "L'entité de paiement doit être unique !",
            'image.image' => 'format image uniquement accepté !',
            'image.max' => 'la taille doit être < ou = 2 méga !',
        ]);

        $data = new MoyensPaiement();
        $data->systeme = $request->system_paiement;
        $data->entite = $request->entite_paiement;
        $data->user_id = /* $request->user_id */1;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $destination = public_path() . "/upload/Systemes_Paie/Images/";
            $file->move($destination, Str::slug($request->system_paiement).'-'.Str::slug($request->entite_paiement).'-'.time().'.'.$file->getClientOriginalExtension());
            $data->image = Str::slug($request->system_paiement).'-'.Str::slug($request->entite_paiement).'-'.time().'.'.$file->getClientOriginalExtension();
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
            'success' => 'Systéme de paiement enregistré avec succès !',
            'data' => $data,
            'status' => 201,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $data = DB::table('moyens_paiements as m')
            ->join('users as u','m.user_id','=','u.id')
            ->select('m.*', 'u.name')
            ->where('m.id', $id)
            ->first();

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Systéme de paiement chargé avec succès !',
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
            'system_paiement' => 'required',
            'entite_paiement' => 'required|min:2|max:75|unique:moyens_paiements,entite'.$id,
            'image' => 'nullable|image|mimes:jpeg,jpg,png,jpg,gif,svg|max:2048',
        ], [
            'system_paiement.required' => "Le systéme de paiement est obligatoire.",
            'entite_paiement.required' => "L'entité de paiement est obligatoire !",
            'entite_paiement.unique' => "L'entité de paiement doit être unique !",
            'image.image' => 'format image uniquement accepté !',
            'image.max' => 'la taille doit être < ou = 2 méga !',
        ]);
           
        $data = DB::table('moyens_paiements')
            ->where('id', $id)
            ->update([
                'systeme' => $request->system_paiement,
                'entite' => $request->entite_paiement,
                'user_id' => $request->user_id,
                'updated_at' => Carbon::now()
            ]);
        
        return response()->json([
            'success' => 'Systéme de Paiement modifié avec succès !',
            'data' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('moyens_paiements')->where('id', $id)->delete();
        return response()->json(['success' => 'Systéme de paiement supprimé avec succès !']);
    }

    /**
     * Change state the specified resource from storage.
     */
    public function modificationEtatSysteme(Request $request, string $id) {
        if ($request->etat==1) {
            # code...
            DB::table('moyens_paiements')->where('id', $id)->update(
                [
                    'etat' => 0,
                    'desactive_le' => Carbon::now(),
                ]
            );
        } else {
            # code...
            DB::table('moyens_paiements')->where('id', $id)->update(
                [
                    'etat' => 1,
                    'reactive_le' => Carbon::now(),
                ]
            );
        }
        
        
    }
}
