<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class VenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # code...
        $query = DB::table('ventes as v')
            ->join('clients as c','c.id','=','v.client_id')
            ->join('users as u','u.id','=','v.user_id')
            ->join('boutiques as b','b.id','=','v.boutique_id')
            ->join('entreprises as entrep','entrep.id','=','b.entreprise_id')
            ->leftJoin('encaissements as e','e.vente_id','=','v.id')
            ->leftJoin('detail_encaissements as d','d.encaissement_id','=','e.id')
            ->select('v.*', 'c.client', 'u.name as gestionnaire', 'b.boutique', 'entrep.entreprise', DB::raw('SUM(d.montant) as encaissements'))
            ->groupBy('v.id','v.num_vente', 'v.montant', 'v.remise', 'v.created_at', 'v.etat')
            ->get();
        /* dd($query); */
        if ($request->ajax()) {    
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $calcul = $row->montant*($row->remise/100);
                if ($calcul==$row->encaissements) {
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
            'type_vente' => 'required|max:1|alpha',
            'client_id' => 'required|integer'
        ], [
            'type_vente.required' => 'Le type de vente est obligatoire.',
            'client_id.required' => 'Le client est obligatoire.',
            'client_id.integer' => 'Le client_id doit être un nombre !',
        ]);
           
        DB::beginTransaction();

        try {

            /************** Debut Vente *******************/
            $numero_vente = DB::table('ventes')->max('num_vente');
            $numero_vente=="" || is_null($numero_vente) ? $numero_vente=str_pad(1, 6, "0", STR_PAD_LEFT) : $numero_vente=str_pad($numero_vente+1, 6, "0", STR_PAD_LEFT);
            
            $vente = DB::table('ventes')->insert([
                'status_vente' => $request->type_vente,
                'num_vente' => $numero_vente,
                'etat' => 1,
                'client_id' => $request->client_id,
                'user_id' => /* $request->user_id */1,
                'boutique_id' => /* $request->user_id */1,
                'montant' => $request->montants,
                'remise' => $request->remise,
                /* 'montants_apres_remise' => $request->type_vente=='f' ? $request->montants_apres_remise : 0,
                'montants_apres_remise' => $request->montants_apres_remise, */
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            /************** Fin Vente *******************/

            /************** Debut Section Detail_Vente *******************/
            $idproduit = $request->id_produit;
            $montant = $request->montant;
            $quantite = $request->quantite;

            $cont = 0;

            $actuel_vente = DB::table('ventes')->where('num_vente', $numero_vente)->first();
            if ($actuel_vente->status_vente=='f') {
                # code...
                while ($cont < count($idproduit)) {
                    DB::table('detail_ventes')->insert([
                        'vente_id' => $actuel_vente->id,
                        'article_id' => $idproduit[$cont],
                        'montant' => $montant[$cont],
                        'quantite' => $quantite[$cont],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    $produit = Article::find($idproduit[$cont]);
                    $produit->decrement('stock', $quantite[$cont]);

                    $cont = $cont + 1;
                }

                /*** Etapes d'encaissement de la vente ***/
                $numero_encaissement = DB::table('encaissements')->max('num_encaissement');
                $numero_encaissement=="" || is_null($numero_encaissement) ? $numero_encaissement=str_pad(1, 5, "0", STR_PAD_LEFT) : $numero_encaissement=str_pad($numero_encaissement+1, 5, "0", STR_PAD_LEFT);
            
                $encaissement = DB::table('encaissements')->insert([
                    'num_encaissement' => $numero_encaissement,
                    /* 'etat' => 1, */
                    'user_id' => /* $request->user_id */1,
                    'vente_id' => $actuel_vente->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                $actuel_encaissement = DB::table('encaissements')->where('num_encaissement', $numero_encaissement)->first();
                DB::table('detail_encaissements')->insert([
                    'mode_encaissement' => $request->systeme_encaissement,
                    'lieu_encaissement' => $request->mode_encaissement,
                    'ref_encaissement' => $request->systeme_encaissement=='banque' ? $request->moyen_bancaire.'- N°'.$request->ref_encaissement : $request->ref_encaissement,
                    'montant' => $request->encaissement,
                    'user_id' => /* $request->user_id */1,
                    'encaissement_id' => $actuel_encaissement->id,
                    /* 'etat' => 1, */
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                /*** Etapes d'encaissement de la vente ***/

            } else {
                # code...
                while ($cont < count($idproduit)) {
                    DB::table('detail_ventes')->insert([
                        'vente_id' => $actuel_vente->id,
                        'article_id' => $idproduit[$cont],
                        'montant' => $montant[$cont],
                        'quantite' => $quantite[$cont],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    $cont = $cont + 1;
                }
            }
            
            /************** Fin Section Detail_Vente *******************/

            DB::commit();

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
      
        /* return response()->json([
            'success' => 'Catégorie enregistrée avec succès !',
            'data' => $data,
            'status' => 201,
        ]); */
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('categories')->where('id', $id)->delete();
        return response()->json(['success' => 'Catégorie supprimée avec succès !']);
    }

    public function modification_client_vente(Request $request, string $id)
    {
        DB::table('ventes')
            ->where('id', $id)
            ->update([
                'client_id' => $request->client,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'client modifié avec succès !']);
    }
    
    public function actualisation_remise_vente(Request $request, string $id)
    {
        DB::table('ventes')
            ->where('id', $id)
            ->update([
                'remise' => $request->remise,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'Remise modifiée avec succès !']);
    }

    public function validation_etat_vente(Request $request, string $id)
    {
        DB::table('ventes')
            ->where('id', $id)
            ->update([
                'etat' => $request->etat,
                'updated_at' => Carbon::now(),
            ]);
            
        return response()->json(['success' => 'Etat de la vente modifié avec succès !']);
    }
    
    public function validation_statut_vente(string $id)
    {
        DB::table('ventes')
            ->where('id', $id)
            ->update([
                'status_vente' => 'f',
                'updated_at' => Carbon::now(),
            ]);
        
        $actuel_vente = DB::table('ventes')->where('id', $id)->first();
        $detail_ventes = DB::table('detail_ventes')->where('vente_id', $id)->get();
        foreach ($detail_ventes as $d) {
            $produit = Article::find($d->article_id);
            $produit->decrement('stock', $d->quantite);
        }
        
        /*** Enrollement de l'encaissement à la vente ***/
        $numero_encaissement = DB::table('encaissements')->max('num_encaissement');
        $numero_encaissement=="" || is_null($numero_encaissement) ? $numero_encaissement=str_pad(1, 5, "0", STR_PAD_LEFT) : $numero_encaissement=str_pad($numero_encaissement+1, 5, "0", STR_PAD_LEFT);
    
        $encaissement = DB::table('encaissements')->insert([
            'num_encaissement' => $numero_encaissement,
            /* 'etat' => 1, */
            'user_id' => /* $request->user_id */1,
            'vente_id' => $actuel_vente->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        /*** Enrollement de l'encaissement à la vente ***/

        return response()->json(['success' => 'Etat de la vente modifié avec succès !']);
    }

    public function ajout_articles_into_details_vente(Request $request, string $id)
    {
        $actuel_vente = DB::table('ventes')->where('id', $id)->first();
        
        $vente = DB::table('ventes')
            ->where('id', $id)
            ->update([
                'montant' => $actuel_vente->montant+$request->montants,
                'updated_at' => Carbon::now(),
            ]);
        /************** Fin Vente *******************/

        $actuel_encaissement = DB::table('encaissements')->where('vente_id', $actuel_vente->id)->first();
            
        dd($actuel_vente, $actuel_encaissement);
        /* dd($actuel_encaissement); */

        $idproduit = $request->id_produit;
        $montant = $request->montant;
        $quantite = $request->quantite;

        $cont = 0;
        
        if ($actuel_vente->status_vente=='f') {
            # code...
            while ($cont < count($idproduit)) {
                DB::table('detail_ventes')->insert([
                    'vente_id' => $actuel_vente->id,
                    'article_id' => $idproduit[$cont],
                    'montant' => $montant[$cont],
                    'quantite' => $quantite[$cont],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
    
                $produit = Article::find($idproduit[$cont]);
                $produit->decrement('stock', $quantite[$cont]);
    
                $cont = $cont + 1;
            }
            
            /*** Etapes d'encaissement de la vente ***/
            DB::table('detail_encaissements')->insert([
                'mode_encaissement' => $request->systeme_encaissement,
                'lieu_encaissement' => $request->mode_encaissement,
                'ref_encaissement' => $request->systeme_encaissement=='banque' ? $request->moyen_bancaire.'- N°'.$request->ref_encaissement : $request->ref_encaissement,
                'montant' => $request->encaissement,
                'user_id' => /* $request->user_id */1,
                'encaissement_id' => $actuel_encaissement->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            /*** Etapes d'encaissement de la vente ***/

        } else {
            # code...
            while ($cont < count($idproduit)) {
                DB::table('detail_ventes')->insert([
                    'vente_id' => $actuel_vente->id,
                    'article_id' => $idproduit[$cont],
                    'montant' => $montant[$cont],
                    'quantite' => $quantite[$cont],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
    
                $cont = $cont + 1;
            }
        }
            
        return response()->json(['success' => 'Articles ajoutés avec succès !']);
    }

    public function annulation_article_into_details_vente(string $id)
    {
        DB::table('detail_ventes')
            ->where('id', $id)
            ->update([
                'etat' => 0,
                'updated_at' => Carbon::now(),
            ]);
            
        return response()->json(['success' => 'Ligne de vente annulée avec succès !']);
    }

    public function details_article_into_details_vente(Request $request, string $id)
    {
        $data = DB::table('detail_ventes as d')
            ->join('articles as a', 'a.id', 'd.article_id')
            ->select(
                'd.id', 'd.article_id', 'd.montant', 'd.quantite', 'd.etat',
                'a.article', 'a.stock', 'a.prix_vente_minimal'
            )
            ->where('d.id', $id)
            ->first();

        /* dd($data); */

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Détail Article chargé avec succès !',
                'data' => $data,
                'status' => 200,
            ]);
        }
    }

    public function edit_montant_into_details_vente(Request $request, string $id){
        DB::table('detail_ventes')
            ->where('id', $id)
            ->update([
                'montant' => $request->montant,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'Montant modifié avec succès !']);
    }

    public function edit_quantite_into_details_vente(Request $request, string $id){
        DB::table('detail_ventes')
            ->where('id', $id)
            ->update([
                'quantite' => $request->quantite,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'Quantité modifiée avec succès !']);
    }
}
