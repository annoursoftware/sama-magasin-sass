<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class EntrepriseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # code...
        $query = DB::table('entreprises as e')
            ->leftJoin('boutiques as b','b.entreprise_id','=','e.id')
            ->leftJoin('users as u','b.id','=','u.boutique_id')
            ->select('e.*', 
                DB::raw('COUNT(b.id) as total_boutiques'),
                DB::raw('COUNT(u.id) as total_users'),
            )
            ->groupBy('e.id','e.entreprise')
            ->get();

        if ($request->ajax()) {    
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('Image', function ($row) {
                if (is_null($row->logo)) {
                    return '<img class="rounded-square" width="50" height="50" src="' . asset("no-img.jpg").'" alt="">';
                } else {
                    return '<a href="' . url("/upload/Entreprises/Logos/".$row->logo).'" data-toggle="lightbox" data-title="'.$row->entreprise.'" data-footer="logo-'.$row->logo.'" data-max-width="500">
                                <img class="rounded-square" width="30" height="30" src="' . asset("/upload/Entreprises/Logos/".$row->logo).'" alt="'.$row->logo.'">
                            </a>';
                }
            })
            ->addColumn('action', function ($row) {
                $btn = '<a onclick="showData('.$row->id.')" class="show btn btn-warning btn-flat btn-sm"><i class="bi bi-eye-fill"></i></a>';
                $btn .= ' <a onclick="editData('.$row->id.')" class="edit btn btn-primary btn-flat btn-sm"><i class="bi bi-pencil-fill"></i></a>';
                $btn .= ' <a onclick="deleteData('.$row->id.')" class="delete btn btn-danger btn-flat btn-sm"><i class="bi bi-trash-fill"></i></a>';
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
            'entreprise' => 'required|unique:entreprises,entreprise',
            'email' => 'required|unique:entreprises,email|email',
            /* 'siege' => 'required', */
            'telephone' => 'required|unique:entreprises,telephone',
            'responsable' => 'required',
            'regime_juridique' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'entreprise.required' => "L'entreprise est obligatoire.",
            'entreprise.unique' => "Cet entreprise est déjà enregistré.",
            'email.required' => 'Email obligatoire !',
            'email.unique' => 'Cet email existe déjà !',
            'email.email' => 'Email non valide !',
            /* 'siege.required' => 'Siege social obligatoire !.', */
            'telephone.required' => 'N° Telephone obligatoire !',
            'telephone.unique' => 'N° Telephone existe déjà !',
            'responsable.required' => 'Responsable obligatoire !',
            'regime_juridique.required' => 'Régime juridique obligatoire !',
            'logo.image' => 'Le logo doit être une image !',
            'logo.mimes' => 'Le logo doit être de type : jpeg,png,jpg,gif,svg !',
            'logo.max' => 'La taille du logo doit être <= 2 MO',
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

        $data = new Entreprise();
        $data->entreprise = $request->entreprise;
        $data->email = $request->email;
        $data->telephone = $request->telephone;
        $data->ninea = $request->ninea;
        $data->rc = $request->rc;
        $data->responsable = $request->responsable;
        $data->siege = $request->siege;
        $data->regime_juridique = $request->regime_juridique;

        /* $data->user_id = $request->user_id; */

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $destination = public_path() . "/upload/Entreprises/Logos/";
            $file->move($destination, Str::slug($request->entreprise).'-'.time().'.'.$file->getClientOriginalExtension());
            $data->logo = Str::slug($request->entreprise).'-'.time().'.'.$file->getClientOriginalExtension();
        } else {
            $data->logo = null;
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
            'success' => 'Entreprise enregistrée avec succès !',
            'data' => $data,
            'status' => 201,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $data = DB::table('entreprises')
            ->where('id', $id)
            ->first();

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Entreprise chargée avec succès !',
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
            'entreprise' => 'required|unique:entreprises,entreprise|alpha_num'.$id,
            'email' => 'required|unique:entreprises,email|email'.$id,
            'adresse' => 'required',
            'telephone' => 'required|unique:entreprises,telephone'.$id,
            'responsable' => 'required',
            /* 'entreprise_id' => 'required' */
        ], [
            'entreprise.required' => "L'entreprise est obligatoire.",
            'entreprise.unique' => "Cet entreprise est déjà enregistré.",
            'email.required' => 'Email obligatoire !',
            'email.unique' => 'Cet email existe déjà !',
            'email.email' => 'Email non valide !',
            /* 'siege.required' => 'Siege social obligatoire !.', */
            'telephone.required' => 'N° Telephone obligatoire !',
            'telephone.unique' => 'N° Telephone existe déjà !',
            'responsable.required' => 'Responsable obligatoire !',
        ]);
           
        $data = DB::table('entreprises')
            ->where('id', $id)
            ->update([
                'entreprise' => $request->entreprise,
                /* 'siege' => $request->siege, */
                'telephone' => $request->telephone,
                'email' => $request->email,
                'responsable' => $request->responsable,
                'updated_at' => Carbon::now()
            ]);
        
        return response()->json([
            'success' => 'Entreprise modifiée avec succès !',
            'data' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('entreprises')->where('id', $id)->delete();
        return response()->json(['success' => 'Entreprise supprimée avec succès !']);
    }
}
