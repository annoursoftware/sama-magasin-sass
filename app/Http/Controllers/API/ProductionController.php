<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Produit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # code...
        $query = DB::table('productions as p')
            ->leftJoin('detail_productions as dp','dp.production_id','=','p.id')
            /* ->leftJoin('compositions as c','c.detail_production_id','=','dp.id') */
            ->join('users as u','u.id','=','p.user_id')
            ->join('boutiques as b','b.id','=','p.boutique_id')
            ->join('entreprises as entrep','entrep.id','=','b.entreprise_id')
            ->select('p.*', 'u.name as gestionnaire', 'b.boutique', 'entrep.entreprise', DB::raw('SUM(dp.quantite) as qte_produite')/* , DB::raw('COUNT(c.id) as total_ingredients') */)
            ->groupBy('p.id','p.num_production', 'p.created_at', 'p.etat')
            ->get();
        /* dd($query); */
        if ($request->ajax()) {    
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if ($row->etat==1) {
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
     * Display a listing of the resource.
     */
    public function operations(Request $request)
    {
        # code...
        $query = DB::table('detail_productions as dp')
            ->join('produits as prod','prod.id','=','dp.produit_id')
            ->join('productions as p','p.id','=','dp.production_id')
            ->join('users as u','u.id','=','p.user_id')
            ->join('boutiques as b','b.id','=','p.boutique_id')
            ->join('entreprises as entrep','entrep.id','=','b.entreprise_id')
            ->select('dp.*', 'prod.produit', 'p.num_production', 'p.status_production', 'u.name', 'b.boutique', 'entrep.entreprise')
            ->get();
        /* dd($query); */
        if ($request->ajax()) {    
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn =  '<div class="btn-group">';
                $btn .= '<button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>';
                $btn .= '<div class="dropdown-menu" style="">';
                $btn .= '<a onclick="showData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-eye-fill"></i> Détails</a>';
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
        DB::beginTransaction();

        try {

            /************** Debut achat *******************/
            $numero_production = DB::table('productions')->max('num_production');
            $numero_production=="" || is_null($numero_production) ? $numero_production=str_pad(1, 6, "0", STR_PAD_LEFT) : $numero_production=str_pad($numero_production+1, 6, "0", STR_PAD_LEFT);
            
            $production = DB::table('productions')->insert([
                'status_production' => 'f',
                'num_production' => $numero_production,
                'etat' => 1,
                'user_id' => /* $request->user_id */1,
                'boutique_id' => /* $request->user_id */1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            /************** Fin Vente *******************/

            /************** Debut Section Detail_Vente *******************/
            $idproduit = $request->id_produit;
            $quantite = $request->quantite;

            $cont = 0;

            $actuel_production = DB::table('productions')->where('num_production', $numero_production)->first();
            
            # code...
            while ($cont < count($idproduit)) {
                DB::table('detail_productions')->insert([
                    'production_id' => $actuel_production->id,
                    'user_id' => 1,
                    'produit_id' => $idproduit[$cont],
                    'quantite' => $quantite[$cont],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                $produit = Produit::find($idproduit[$cont]);
                $produit->increment('production', $quantite[$cont]);

                $cont = $cont + 1;
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

    public function modification_fournisseur_achat(Request $request, string $id)
    {
        DB::table('achats')
            ->where('id', $id)
            ->update([
                'fournisseur_id' => $request->fournisseur,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'fournisseur modifié avec succès !']);
    }
    
    public function validation_etat_achat(Request $request, string $id)
    {
        DB::table('achats')
            ->where('id', $id)
            ->update([
                'etat' => $request->etat,
                'updated_at' => Carbon::now(),
            ]);
            
        return response()->json(['success' => "Etat de l'achat modifié avec succès !"]);
    }
    
    public function validation_statut_achat(string $id)
    {
        DB::table('achats')
            ->where('id', $id)
            ->update([
                'status_achat' => 'f',
                'updated_at' => Carbon::now(),
            ]);
        
        $actuel_achat = DB::table('achats')->where('id', $id)->first();
        $detail_achats = DB::table('detail_achats')->where('achat_id', $id)->get();
        foreach ($detail_achats as $d) {
            $produit = Article::find($d->article_id);
            $produit->increment('stock', $d->quantite);
        }
        
        /*** Enrollement de l'encaissement à la vente ***/
        $numero_decaissement = DB::table('decaissements')->max('num_decaissement');
        $numero_decaissement=="" || is_null($numero_decaissement) ? $numero_encaissement=str_pad(1, 5, "0", STR_PAD_LEFT) : $numero_decaissement=str_pad($numero_decaissement+1, 5, "0", STR_PAD_LEFT);
    
        $decaissement = DB::table('decaissements')->insert([
            'num_decaissement' => $numero_decaissement,
            /* 'etat' => 1, */
            'user_id' => /* $request->user_id */1,
            'achat_id' => $actuel_achat->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        /*** Enrollement de l'encaissement à la vente ***/

        return response()->json(['success' => "Etat de l'achat modifié avec succès !"]);
    }

    public function actualisation_remise_achat(Request $request, string $id)
    {
        DB::table('achats')
            ->where('id', $id)
            ->update([
                'remise' => $request->remise,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'Remise modifiée avec succès !']);
    }

    public function ajout_articles_into_details_achat(Request $request, string $id)
    {
        $actuel_achat = DB::table('achats')->where('id', $id)->first();
        
        $achat = DB::table('achats')
            ->where('id', $id)
            ->update([
                'montant' => $actuel_achat->montant+$request->montants,
                'updated_at' => Carbon::now(),
            ]);
        /************** Fin Vente *******************/

        $actuel_decaissement = DB::table('decaissements')->where('achat_id', $actuel_achat->id)->first();
            
        dd($actuel_achat, $actuel_decaissement);
        /* dd($actuel_encaissement); */

        $idproduit = $request->id_produit;
        $montant = $request->montant;
        $quantite = $request->quantite;

        $cont = 0;
        
        if ($actuel_achat->status_achat=='f') {
            # code...
            while ($cont < count($idproduit)) {
                DB::table('detail_achats')->insert([
                    'achat_id' => $actuel_achat->id,
                    'article_id' => $idproduit[$cont],
                    'montant' => $montant[$cont],
                    'quantite' => $quantite[$cont],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
    
                $produit = Article::find($idproduit[$cont]);
                $produit->increment('stock', $quantite[$cont]);
    
                $cont = $cont + 1;
            }
            
            /*** Etapes d'encaissement de la vente ***/
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
            /*** Etapes d'encaissement de la vente ***/

        } else {
            # code...
            while ($cont < count($idproduit)) {
                DB::table('detail_achats')->insert([
                    'achat_id' => $actuel_achat->id,
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

    public function annulation_article_into_details_achat(string $id)
    {
        DB::table('detail_achats')
            ->where('id', $id)
            ->update([
                'etat' => 0,
                'updated_at' => Carbon::now(),
            ]);
            
        return response()->json(['success' => "Ligne d'achat annulée avec succès !"]);
    }

    public function details_article_into_details_achat(Request $request, string $id)
    {
        $data = DB::table('detail_achats as d')
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

    public function edit_montant_into_details_achat(Request $request, string $id){
        DB::table('detail_achats')
            ->where('id', $id)
            ->update([
                'montant' => $request->montant,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'Montant modifié avec succès !']);
    }

    public function edit_quantite_into_details_achat(Request $request, string $id){
        DB::table('detail_achats')
            ->where('id', $id)
            ->update([
                'quantite' => $request->quantite,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'Quantité modifiée avec succès !']);
    }
}
