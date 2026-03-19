<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Beneficiaire;
use App\Models\Decaissement;
use App\Models\Depense;
use App\Models\DetailEncaissement;
use App\Models\DetailPrestation;
use App\Models\Encaissement;
use App\Models\Prestation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PrestationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # code...
        $query = DB::table('prestations as p')
            ->join('clients as c', 'c.id', '=', 'p.client_id')
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->join('boutiques as b', 'b.id', '=', 'p.boutique_id')
            ->join('entreprises as entrep', 'entrep.id', '=', 'b.entreprise_id')
            ->leftJoin('encaissements as e', 'e.prestation_id', '=', 'p.id')
            ->leftJoin('detail_encaissements as d', 'd.encaissement_id', '=', 'e.id')
            ->select('p.*', 'c.client', 'u.name as gestionnaire', 'b.boutique', 'entrep.entreprise', DB::raw('SUM(d.montant) as encaissements'))
            ->groupBy('p.id', 'p.code_prestation', 'p.montant', 'p.remise', 'p.created_at', 'p.etat')
            ->get();
        /* dd($query); */
        if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $calcul = $row->montant * ($row->remise / 100);
                    if ($calcul == $row->encaissements) {
                        # code...
                        $btn =  '<div class="btn-group">';
                        $btn .= '<button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>';
                        $btn .= '<div class="dropdown-menu" style="">';
                        $btn .= '<a onclick="showData(' . $row->id . ')" class="dropdown-item" href="#"><i class="bi bi-eye-fill"></i> Détails</a>';
                        $btn .= '<a onclick="editData(' . $row->id . ')" class="dropdown-item" href="#"><i class="bi bi-pencil-fill"></i> Edition</a>';
                        $btn .= '</div>';
                        $btn .= '</div>';
                    } else {
                        # code...
                        $btn =  '<div class="btn-group">';
                        $btn .= '<button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>';
                        $btn .= '<div class="dropdown-menu" style="">';
                        $btn .= '<a onclick="impression(' . $row->id . ')" class="dropdown-item" href="#"><i class="bi bi-printer-fill"></i> Impression</a>';
                        $btn .= '<a onclick="showData(' . $row->id . ')" class="dropdown-item" href="#"><i class="bi bi-eye-fill"></i> Détails</a>';
                        $btn .= '<a onclick="editData(' . $row->id . ')" class="dropdown-item" href="#"><i class="bi bi-pencil-fill"></i> Edition</a>';
                        $btn .= '<a onclick="deleteData(' . $row->id . ')" class="dropdown-item" href="#"><i class="bi bi-trash-fill"></i> Suppression</a>';
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
        $query = DB::table('taches as t')
            ->join('activites as a', 'a.id', '=', 't.activite_id')
            ->join('prestations as p', 'p.id', '=', 't.prestation_id')
            ->join('clients as c', 'c.id', '=', 'p.client_id')
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->join('boutiques as b', 'b.id', '=', 'p.boutique_id')
            ->join('entreprises as entrep','entrep.id','=','b.entreprise_id')
            ->select('t.*', 'a.activite', 'p.code_prestation', 'p.status_prestation', 'c.client', 'b.boutique', 'entrep.entreprise')
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
        $query = DB::table('prestations as p')
            ->join('clients as c','c.id','=','p.client_id')
            ->join('users as u','u.id','=','p.user_id')
            ->join('boutiques as b','b.id','=','p.boutique_id')
            ->join('entreprises as entrep','entrep.id','=','b.entreprise_id')
            ->select('p.*', 'c.client', 'u.name as gestionnaire', 'b.boutique', 'entrep.entreprise')
            ->where('status_prestation', 'd')
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
            'type_vente.required' => 'Le status de prestation est obligatoire.',
            'client_id.required' => 'Le client est obligatoire.',
            'client_id.integer' => 'Le client_id doit être un nombre !',
        ]);

        DB::beginTransaction();

        try {

            /************** Debut Vente *******************/
            $code_prestation = DB::table('prestations')->max('code_prestation');
            $code_prestation == "" || is_null($code_prestation) ? $code_prestation = str_pad(1, 6, "0", STR_PAD_LEFT) : $code_prestation = str_pad($code_prestation + 1, 6, "0", STR_PAD_LEFT);

            $prestation = DB::table('prestations')->insert([
                'status_prestation' => $request->type_vente,
                'code_prestation' => $code_prestation,
                'etat' => 1,
                'client_id' => $request->client_id,
                'user_id' => /* $request->user_id */ 1,
                'boutique_id' => /* $request->user_id */ 1,
                'montant' => $request->montants,
                'remise' => $request->remise,
                /* 'montants_apres_remise' => $request->type_vente=='f' ? $request->montants_apres_remise : 0,
                'montants_apres_remise' => $request->montants_apres_remise, */
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            /************** Fin Vente *******************/

            /************** Debut Section Detail_Vente *******************/
            $idActivite = $request->id_produit;
            $montant = $request->montant;
            /* $quantite = $request->quantite; */

            $cont = 0;

            $actuel_prestation = DB::table('prestations')->where('code_prestation', $code_prestation)->first();

            while ($cont < count($idActivite)) {
                DB::table('taches')->insert([
                    'prestation_id' => $actuel_prestation->id,
                    'activite_id' => $idActivite[$cont],
                    'montant' => $montant[$cont],
                    /* 'quantite' => $quantite[$cont], */
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                $cont = $cont + 1;
            }

            if ($actuel_prestation->status_prestation == 'f') {
                /*** Etapes d'encaissement de la vente ***/
                $numero_encaissement = DB::table('encaissements')->max('num_encaissement');
                $numero_encaissement == "" || is_null($numero_encaissement) ? $numero_encaissement = str_pad(1, 5, "0", STR_PAD_LEFT) : $numero_encaissement = str_pad($numero_encaissement + 1, 5, "0", STR_PAD_LEFT);

                $encaissement = DB::table('encaissements')->insert([
                    'num_encaissement' => $numero_encaissement,
                    /* 'etat' => 1, */
                    'user_id' => /* $request->user_id */ 1,
                    'prestation_id' => $actuel_prestation->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                $actuel_encaissement = DB::table('encaissements')->where('num_encaissement', $numero_encaissement)->first();
                $d_encaissement = DB::table('detail_encaissements')->insert([
                    'mode_encaissement' => $request->systeme_encaissement,
                    'lieu_encaissement' => $request->mode_encaissement,
                    'ref_encaissement' => $request->systeme_encaissement == 'banque' ? $request->moyen_bancaire . '- N°' . $request->ref_encaissement : $request->ref_encaissement,
                    'montant' => $request->encaissement,
                    'user_id' => /* $request->user_id */ 1,
                    'encaissement_id' => $actuel_encaissement->id,
                    /* 'etat' => 1, */
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                /*** Etapes d'encaissement de la vente ***/
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
        DB::table('prestations')->where('id', $id)->delete();
        return response()->json(['success' => 'Prestation supprimée avec succès !']);
    }

    public function modification_client_prestation(Request $request, string $id)
    {
        DB::table('prestations')
            ->where('id', $id)
            ->update([
                'client_id' => $request->client,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'client modifié avec succès !']);
    }

    public function validation_etat_prestation(Request $request, string $id)
    {
        DB::table('prestations')
            ->where('id', $id)
            ->update([
                'etat' => $request->etat,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'Etat de la prestation modifié avec succès !']);
    }

    public function validation_statut_prestation(string $id)
    {
        DB::table('prestations')
            ->where('id', $id)
            ->update([
                'status_prestation' => 'f',
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'Statut prestation modifié avec succès !']);
    }
    
    /* Annulation de la prestation ou du devis */
    public function annulation_prestation(string $id)
    {
        DB::beginTransaction();

        try {

            /************** Debut Prestation *******************/
            $prestation = Prestation::findOrFail($id);
            $prestation->etat = 0;
            $prestation->update();
            /************** Fin Prestation *******************/

            /************** Debut Section Detail_Prestation *******************/
            if ($prestation->status_prestation=='f') {
                # code...
                $detail_prestations = DB::table('detail_prestations')->where('prestation_id', $prestation->id)->get();

                $lignes_encaissements = DB::table('detail_encaissements as d')
                    ->join('encaissements as e', 'd.encaissement_id', 'e.id')
                    ->where('e.prestation_id', $prestation->id)
                    ->get();
                $encaissement = DB::table('encaissements')->where('prestation_id', $prestation->id)->first();
                
                /* En cas de detection de ligne de prestations existants */
                foreach ($detail_prestations as $d) {
                    /* Retour au stock */
                    $produit = Article::find($d->article_id);
                    $produit->increment('stock', $d->quantite);

                    /* desactivation lignes prestations */
                    $ligne = DetailPrestation::find($d->id);
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
                $client = DB::table('clients')->where('id', $prestation->client_id)->first();
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
                $depense->libelle = 'Ristourne prestation N°'.$prestation->num_prestation;
                $depense->numero_facture_benef = 'Prest N°'.$prestation->num_prestation;
                $depense->montant = ($prestation->montant - ($prestation->montant * ($prestation->remise / 100)));
                $depense->type = 'dir';
                $depense->effet = Carbon::now();
                $depense->limite = Carbon::now();
                $depense->boutique_id = $prestation->boutique_id;
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
            
            /************** Fin Section Detail_Prestation *******************/

            DB::commit();

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function ajout_activites_into_taches(Request $request, string $id)
    {
        $actuel_prestation = DB::table('prestations')->where('id', $id)->first();

        $prestation = DB::table('prestations')
            ->where('id', $id)
            ->update([
                'montant' => $actuel_prestation->montant + $request->montants,
                'updated_at' => Carbon::now(),
            ]);
        /************** Fin Vente *******************/

        $actuel_encaissement = DB::table('encaissements')->where('prestation_id', $actuel_prestation->id)->first();

        dd($actuel_prestation, $actuel_encaissement);
        /* dd($actuel_encaissement); */

        $idproduit = $request->id_produit;
        $montant = $request->montant;

        $cont = 0;

        if ($actuel_prestation->status_prestation == 'f') {
            # code...
            while ($cont < count($idproduit)) {
                DB::table('taches')->insert([
                    'prestation_id' => $actuel_prestation->id,
                    'activite_id' => $idproduit[$cont],
                    'montant' => $montant[$cont],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                $cont = $cont + 1;
            }

            /*** Etapes d'encaissement de la vente ***/
            DB::table('detail_encaissements')->insert([
                'mode_encaissement' => $request->systeme_encaissement,
                'lieu_encaissement' => $request->mode_encaissement,
                'ref_encaissement' => $request->systeme_encaissement == 'banque' ? $request->moyen_bancaire . '- N°' . $request->ref_encaissement : $request->ref_encaissement,
                'montant' => $request->encaissement,
                'user_id' => /* $request->user_id */ 1,
                'encaissement_id' => $actuel_encaissement->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            /*** Etapes d'encaissement de la prestation ***/
        } else {
            # code...
            while ($cont < count($idproduit)) {
                DB::table('taches')->insert([
                    'prestation_id' => $actuel_prestation->id,
                    'activite_id' => $idproduit[$cont],
                    'montant' => $montant[$cont],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                $cont = $cont + 1;
            }
        }

        return response()->json(['success' => 'Activités ajoutées avec succès !']);
    }

    public function annulation_activite_into_taches(string $id)
    {
        DB::table('taches')
            ->where('id', $id)
            ->update([
                'etat' => 0,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'Ligne de vente annulée avec succès !']);
    }

    public function details_activite_into_taches(Request $request, string $id)
    {
        $data = DB::table('taches as t')
            ->join('activites as a', 'a.id', 't.activite_id')
            ->select(
                't.id',
                't.activite_id',
                't.montant',
                't.etat',
                'a.activite',
                'a.montant as montant_minimal_prestation'
            )
            ->where('t.id', $id)
            ->first();

        /* dd($data); */

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Tâches chargées avec succès !',
                'data' => $data,
                'status' => 200,
            ]);
        }
    }

    public function edit_montant_into_taches(Request $request, string $id)
    {
        DB::table('taches')
            ->where('id', $id)
            ->update([
                'montant' => $request->montant,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'Montant modifié avec succès !']);
    }

    public function edit_duree_into_taches(Request $request, string $id)
    {
        DB::table('taches')
            ->where('id', $id)
            ->update([
                'duree' => $request->duree,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['success' => 'Durée modifiée avec succès !']);
    }
}
