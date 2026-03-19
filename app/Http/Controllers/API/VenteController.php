<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Beneficiaire;
use App\Models\Decaissement;
use App\Models\Depense;
use App\Models\DetailDecaissement;
use App\Models\DetailVente;
use App\Models\DetailEncaissement;
use App\Models\Encaissement;
use App\Models\Vente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
                    $btn .= '</div>';
                    $btn .= '</div>';
                
                } else {
                    # code...
                    $btn =  '<div class="btn-group">';
                    $btn .= '<button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>';
                    $btn .= '<div class="dropdown-menu" style="">';
                    $btn .= '<a onclick="impression('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-printer-fill"></i> Impression</a>';
                    $btn .= '<a onclick="showData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-eye-fill"></i> Détails</a>';
                    
                    if ($row->etat==1) {
                        # code...
                        $btn .= '<a onclick="editData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-pencil-fill"></i> Edition</a>';
                        $btn .= '<a onclick="deleteData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-x-circle-fill"></i> Annuler</a>';
                    }

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
        $query = DB::table('detail_ventes as dv')
            ->join('articles as a','a.id','=','dv.article_id')
            ->join('ventes as v','v.id','=','dv.vente_id')
            ->join('clients as c','c.id','=','v.client_id')
            ->join('users as u','u.id','=','v.user_id')
            ->join('boutiques as b','b.id','=','v.boutique_id')
            ->join('entreprises as entrep','entrep.id','=','b.entreprise_id')
            ->select('dv.*', 'a.article', 'v.num_vente', 'v.status_vente', 'c.client', 'b.boutique', 'entrep.entreprise')
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
     * Display a listing of the resource.
     */
    public function tracking(Request $request)
    {
        # code...
        $query = DB::table('ventes as v')
            ->join('clients as c','c.id','=','v.client_id')
            ->join('users as u','u.id','=','v.user_id')
            ->join('boutiques as b','b.id','=','v.boutique_id')
            ->join('entreprises as entrep','entrep.id','=','b.entreprise_id')
            ->select('v.*', 'c.client', 'u.name as gestionnaire', 'b.boutique', 'entrep.entreprise')
            ->where('status_vente', 'd')
            ->get();
        /* dd($query); */
        if ($request->ajax()) {    
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                # code...
                    $btn =  '<div class="btn-group">';
                    $btn .= '<button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>';
                    $btn .= '<div class="dropdown-menu" style="">';
                    $btn .= '<a onclick="impression('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-printer-fill"></i> Impression</a>';
                    $btn .= '<a onclick="showData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-eye-fill"></i> Détails</a>';
                    $btn .= '<a onclick="editData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-pencil-fill"></i> Edition</a>';
                    if ($row->etat==1) {
                        # code...
                        $btn .= '<a onclick="deleteData('.$row->id.')" class="dropdown-item" href="#"><i class="bi bi-x-circle-fill"></i> Annuler</a>';
                    }
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
        $data = DB::table('ventes')
            ->where('id', $id)
            ->first();

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Vente chargée avec succès !',
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
    
    /* Annulation de la vente ou du devis */
    public function annulation_vente(string $id)
    {
        DB::beginTransaction();

        try {

            /************** Debut Vente *******************/
            $vente = Vente::findOrFail($id);
            $vente->etat = 0;
            $vente->update();
            /************** Fin Vente *******************/

            /************** Debut Section Detail_Vente *******************/
            if ($vente->status_vente=='f') {
                # code...
                $detail_ventes = DB::table('detail_ventes')->where('vente_id', $vente->id)->get();

                $lignes_encaissements = DB::table('detail_encaissements as d')
                    ->join('encaissements as e', 'd.encaissement_id', 'e.id')
                    ->where('e.vente_id', $vente->id)
                    ->get();
                $encaissement = DB::table('encaissements')->where('vente_id', $vente->id)->first();
                
                /* En cas de detection de ligne de ventes existants */
                foreach ($detail_ventes as $d) {
                    /* Retour au stock */
                    $produit = Article::find($d->article_id);
                    $produit->increment('stock', $d->quantite);

                    /* desactivation lignes ventes */
                    $ligne = DetailVente::find($d->id);
                    $ligne->etat = 0;
                    $ligne->update();
                }

                /* Desactivation des encaissements */
                if (($lignes_encaissements->count()) > 0) {
                    /* Desactivation des encaissements */
                    $encaissement = Encaissement::find($encaissement->id);
                    $encaissement->etat = 0;
                    $encaissement->update();

                    # code...
                    foreach ($lignes_encaissements as $le) {
                        $d_encaissement = DetailEncaissement::find($le->id);
                        $d_encaissement->etat = 0;
                        $d_encaissement->update();
                    }
                }

                /* Creation d'une depense sous forme de ristourne */  
                $client = DB::table('clients')->where('id', $vente->client_id)->first();
                $beneficiaire = DB::table('beneficiaires')->where('beneficiaire', $client->client)->first();
                if (is_null($beneficiaire)) {
                    # code...
                    $nv_benef = new Beneficiaire();
                    $nv_benef->beneficiaire = $client->client;
                    $nv_benef->adresse = $client->adresse;
                    $nv_benef->telephone = $client->telephone;
                    //$nv_benef->client_id = $client->id;
                    $nv_benef->save();
                }

                $code_depense = DB::table('depenses')->max('num_depense');
                $code_depense=="" || is_null($code_depense) ? $code_depense=str_pad(1, 6, "0", STR_PAD_LEFT) : $code_depense=str_pad($code_depense+1, 6, "0", STR_PAD_LEFT);
                
                $depense = new Depense();
                $depense->num_depense = $code_depense;
                $depense->libelle = 'Ristourne vente N°'.$vente->num_vente;
                $depense->numero_facture_benef = 'Vte N°'.$vente->num_vente;
                $depense->montant = ($vente->montant - ($vente->montant * ($vente->remise / 100)));
                $depense->type = 'dir';
                $depense->effet = Carbon::now();
                $depense->limite = Carbon::now();
                $depense->boutique_id = $vente->boutique_id;
                $depense->beneficiaire_id = $beneficiaire ? $beneficiaire->id : $nv_benef->id;
                $depense->user_id = 1;
                $depense->save();

                /*** Etapes decaissement de la depense ***/
                $numero_decaissement = DB::table('decaissements')->max('num_decaissement');
                $numero_decaissement=="" || is_null($numero_decaissement) ? $numero_decaissement=str_pad(1, 5, "0", STR_PAD_LEFT) : $numero_decaissement=str_pad($numero_decaissement+1, 5, "0", STR_PAD_LEFT);
            
                $decaissement = new Decaissement();
                $decaissement->num_decaissement = $numero_decaissement;
                /* $decaissement->etat = 1; */
                /* $decaissement->user_id = $request->user_id; */
                $decaissement->depense_id = $depense->id;
                $decaissement->save();
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
    }

    public function ajout_articles_into_details_vente_2(Request $request, string $id)
    {
        //dd($request);

        /************** Fin Recupération Vente *******************/
        $vente = Vente::find($id);
        $vente->increment('montant', $request->montants);
        /************** Fin Recupération Vente *******************/

        $idproduit = $request->id_produit;
        $montant = $request->montant;
        $quantite = $request->quantite;

        $cont = 0;

        if ($request->status_vente=='f') {
            # code...
            while ($cont < count($idproduit)) {
                DB::table('detail_ventes')->insert([
                    'vente_id' => $vente->id,
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

        } else {
            # code...
            while ($cont < count($idproduit)) {
                DB::table('detail_ventes')->insert([
                    'vente_id' => $vente->id,
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

    public function ajout_articles_into_details_vente(Request $request, string $id)
    {
        $vente = Vente::findOrFail($id);

        // Mise à jour du montant total de la vente
        $vente->increment('montant', $request->montants);

        $idproduits = $request->id_produit;
        $montants   = $request->montant;
        $quantites  = $request->quantite;

        DB::transaction(function () use ($vente, $idproduits, $montants, $quantites, $request) {
            foreach ($idproduits as $index => $idproduit) {
                // Vérifier si l'article existe déjà dans les détails 
                $detail = DetailVente::where('vente_id', $vente->id)->where('article_id', $idproduit)->first();

                if ($detail) {
                    // Si l'article existe, mettre à jour la quantité et le montant
                    $detail->increment('quantite', $quantites[$index]);
                    $detail->increment('montant', $montants[$index]);
                } else {
                    DetailVente::create([
                        'vente_id'   => $vente->id,
                        'article_id' => $idproduit,
                        'montant'    => $montants[$index],
                        'quantite'   => $quantites[$index],
                    ]);
                }

                // Décrémenter le stock uniquement si la vente est finalisée
                if ($vente->status_vente === 'f') {
                    $produit = Article::findOrFail($idproduit);
                    $produit->decrement('stock', $quantites[$index]);
                }
            }
        });

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

    
    public function impression_vente(Request $request, string $id)
    {
        $data = DB::table('ventes')
            ->where('id', $id)
            ->first();

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Vente chargée avec succès !',
                'data' => $data,
                'status' => 200,
            ]);
        }
    }
    
    public function A4(string $id)
    {
        $vente = DB::table('ventes as v')
            ->join('clients as cli', 'cli.id', 'v.client_id')
            ->join('users as u', 'u.id', 'v.user_id')
            ->select(
                'v.id',
                'v.num_vente',
                'v.status_vente',
                'v.etat',
                'v.montant',
                'v.remise',
                'v.created_at',
                'u.name',
                'cli.client',
                'cli.adresse',
                'cli.telephone as telephone_primaire',
            )
            ->where('v.id', $id)
            ->first();

        $ventes = DB::table('detail_ventes as dv')
            ->join('ventes as v', 'v.id', 'dv.vente_id')
            ->join('articles as a', 'a.id', 'dv.article_id')
            ->select('dv.*', 'a.article')
            ->where('v.id', $id)
            ->get();
        
        $pdf = PDF::loadView('back.ventes.factures.A4', [
            "vente" => $vente,
            "ventes" => $ventes,
        ]);

        // Options importantes pour le rendu
        /* $pdf->setOptions([
            'defaultFont' => 'DejaVu Sans',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => false,
            'isPhpEnabled' => false,
            'isJavascriptEnabled' => false,
            'isFontSubsettingEnabled' => true,
        ]); */
        $pdf->setOptions([
            'defaultFont' => 'DejaVu Sans',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => false, // Important : mettre à false
            'isPhpEnabled' => false,
            'isJavascriptEnabled' => false,
            'dpi' => 150,
            'defaultPaperSize' => 'a4',
            'fontHeightRatio' => 1.1
        ]);

        $pdf->setPaper('a4', 'landing'); //landscape
        return $pdf->stream();
    }

    public function A5(string $id)
    {
        $vente = DB::table('ventes as v')
            ->join('clients as cli', 'cli.id', 'v.client_id')
            ->join('users as u', 'u.id', 'v.user_id')
            ->select(
                'v.id',
                'v.num_vente',
                'v.status_vente',
                'v.etat',
                'v.montant',
                'v.remise',
                'v.created_at',
                'u.name',
                'cli.client',
                'cli.adresse',
                'cli.telephone as telephone_primaire',
            )
            ->where('v.id', $id)
            ->first();

        $ventes = DB::table('detail_ventes as dv')
            ->join('ventes as v', 'v.id', 'dv.vente_id')
            ->join('articles as a', 'a.id', 'dv.article_id')
            ->select('dv.*', 'a.article')
            ->where('v.id', $id)
            ->get();
        
        // Génération du QR Code en base64 
        $qrCode = base64_encode(QrCode::format('png')->size(120)->generate('FACTURE-'.$vente->num_vente.';MONTANT='.$vente->montant) );
    
        $pdf = PDF::loadView('back.ventes.factures.A5', [
            "vente" => $vente,
            "ventes" => $ventes,
            "qrCode" => $qrCode,
        ]);
        $pdf->setPaper('a5', 'landing'); //landscape
        return $pdf->stream();
    }
}
