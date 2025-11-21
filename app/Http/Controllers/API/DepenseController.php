<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DepenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # code...
        $query = DB::table('depenses as d')
            ->join('beneficiaires as b','b.id','=','d.beneficiaire_id')
            ->join('users as u','u.id','=','d.user_id')
            ->leftJoin('decaissements as dec','dec.depense_id','=','d.id')
            ->leftJoin('detail_decaissements as dd','dd.decaissement_id','=','dec.id')
            ->select('d.*', 'b.beneficiaire', 'u.name', DB::raw('SUM(dd.montant) as decaissements'))
            ->groupBy('d.id','d.num_depense', 'd.montant', 'd.created_at', 'd.etat')
            ->get();

        if ($request->ajax()) {    
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if ($row->montant==$row->decaissements) {
                    # code...
                    $btn =  '<div class="btn-group">';
                    $btn .= '<button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>';
                    $btn .= '<div class="dropdown-menu" style="">';
                    $btn .= '<a onclick="showData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-eye-fill"></i> Détails</a>';
                    $btn .= '<a onclick="editData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-pencil-fill"></i> Edition</a>';
                    $btn .= '</div>';
                    $btn .= '</div>';
                
                } else {
                    # code...
                    $btn =  '<div class="btn-group">';
                    $btn .= '<button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>';
                    $btn .= '<div class="dropdown-menu" style="">';
                    $btn .= '<a onclick="impression('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-printer-fill"></i> Impression</a>';
                    $btn .= '<a onclick="showData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-eye-fill"></i> Détails</a>';
                    $btn .= '<a onclick="editData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-pencil-fill"></i> Edition</a>';
                    $btn .= '<a onclick="deleteData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-trash-fill"></i> Suppression</a>';
                    $btn .= '</div>';
                    $btn .= '</div>';
                
                }
               
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
            'libelle' => 'required|min:5|max:150',
            'numero_facture_benef' => 'nullable|min:9|max:20',
            'montant' => 'required|numeric',
            'type' => 'required',
            'effet' => 'nullable|date',
            'limite' => 'nullable|date',
            'boutique_id' => 'required|integer',
            'beneficiaire_id' => 'required|integer',
        ], [
            'libelle.required' => 'Le libellé est obligatoire.',
            'libelle.min' => 'Le libellé doit être au minimum de 5 caractéres.',
            'libelle.max' => 'Le libellé doit être au maximum de 150 caractéres.',
            'numero_facture_benef.min' => 'Le N° facture doit être au minimum de 9 caractéres.',
            'numero_facture_benef.max' => 'Le N° facture doit être au maximum de 20 caractéres.',
            'montant.required' => 'Le montant est obligatoire.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'type.required' => 'Le type est obligatoire !',
            'effet.date' => 'Effet exigé au format date !',
            'limite.date' => 'Limite exigée au format date !',
            'boutique_id.required' => 'Rattachez-vous à une boutique !',
            'boutique_id.integer' => 'boutique_id doit être un entier !',
            'beneficiaire_id.required' => 'Rattachez-vous à un bénéficiaire !',
            'beneficiaire_id.integer' => 'bénéficiaire_id doit être un entier !'
        ]);
        
        DB::beginTransaction();
        try {
            
            $code_depense = DB::table('depenses')->max('num_depense');
            $code_depense=="" || is_null($code_depense) ? $code_depense=str_pad(1, 6, "0", STR_PAD_LEFT) : $code_depense=str_pad($code_depense+1, 6, "0", STR_PAD_LEFT);
                
            $data = DB::table('depenses')->insert([
                'num_depense' => $code_depense,
                'libelle' => $request->libelle,
                'numero_facture_benef' => $request->numero_facture_benef,
                'montant' => $request->montant,
                'type' => $request->type,
                'effet' => $request->effet,
                'limite' => $request->limite,
                'boutique_id' => $request->boutique_id,
                'beneficiaire_id' => $request->beneficiaire_id,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $depense_actuel = DB::table('depenses')->where('num_depense', $code_depense)->first();
            
            /*** Etapes d'encaissement de la depense ***/
            $numero_decaissement = DB::table('decaissements')->max('num_decaissement');
            $numero_decaissement=="" || is_null($numero_decaissement) ? $numero_decaissement=str_pad(1, 5, "0", STR_PAD_LEFT) : $numero_decaissement=str_pad($numero_decaissement+1, 5, "0", STR_PAD_LEFT);
        
            $decaissement = DB::table('decaissements')->insert([
                'num_decaissement' => $numero_decaissement,
                /* 'etat' => 1, */
                /* 'user_id' => $request->user_id, */
                'depense_id' => $depense_actuel->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            
            if ($request->type=='dir') {
                # code...
                $actuel_decaissement = DB::table('decaissements')->where('num_decaissement', $numero_decaissement)->first();
                DB::table('detail_decaissements')->insert([
                    'mode_decaissement' => $request->systeme_decaissement,
                    'lieu_decaissement' => $request->mode_decaissement,
                    'ref_decaissement' => $request->systeme_decaissement=='banque' ? $request->moyen_bancaire.'- N°'.$request->ref_decaissement : $request->ref_decaissement,
                    'montant' => $request->decaissement,
                    'user_id' => /* $request->user_id */1,
                    'decaissement_id' => $actuel_decaissement->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            /*** Etapes d'encaissement de la depense ***/
            
            DB::commit();
            
            return response()->json([
                'success' => 'Dépense enregistrée avec succès !',
                'data' => $data,
                'status' => 201,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        /* return response()->json([
            'success' => 'Dépense enregistrée avec succès !',
            'data' => $data,
            'status' => 201,
        ]); */
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $data = DB::table('depenses')
            ->where('id', $id)
            ->first();

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Dépense chargée avec succès !',
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
            'libelle' => 'required|min:5|max:150',
            'numero_facture_benef' => 'nullable|min:9|max:20',
            'montant' => 'required|numeric',
            'type' => 'required',
            'effet' => 'nullable|date',
            'limite' => 'nullable|date',
            'boutique_id' => 'required|integer',
            'beneficiaire_id' => 'required|integer',
        ], [
            'libelle.required' => 'Le libellé est obligatoire.',
            'libelle.min' => 'Le libellé doit être au minimum de 5 caractéres.',
            'libelle.max' => 'Le libellé doit être au maximum de 150 caractéres.',
            'numero_facture_benef.min' => 'Le N° facture doit être au minimum de 9 caractéres.',
            'numero_facture_benef.max' => 'Le N° facture doit être au maximum de 20 caractéres.',
            'montant.required' => 'Le montant est obligatoire.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'type.required' => 'Le type est obligatoire !',
            'effet.date' => 'Effet exigé au format date !',
            'limite.date' => 'Limite exigée au format date !',
            'boutique_id.required' => 'Rattachez-vous à une boutique !',
            'boutique_id.integer' => 'boutique_id doit être un entier !',
            'beneficiaire_id.required' => 'Rattachez-vous à un bénéficiaire !',
            'beneficiaire_id.integer' => 'bénéficiaire_id doit être un entier !'
        ]);
        $data = DB::table('depenses')
            ->where('id', $id)
            ->update([
                'libelle' => $request->libelle,
                'numero_facture_benef' => $request->numero_facture_benef,
                'montant' => $request->montant,
                'type' => $request->type,
                'effet' => $request->effet,
                'limite' => $request->limite,
                'boutique_id' => $request->boutique_id,
                'beneficiaire_id' => $request->beneficiaire_id,
                'user_id' => 1,
                'updated_at' => Carbon::now(),
            ]);
        
        return response()->json([
            'success' => 'Dépense modifiée avec succès !',
            'data' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('depenses')->where('id', $id)->delete();
        return response()->json(['success' => 'Dépense supprimée avec succès !']);
    }

}
