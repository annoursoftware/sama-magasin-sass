<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $moyens_paiements = DB::table('moyens_paiements')->count();
        $moyens_paiements_via_bank = DB::table('moyens_paiements')->where('systeme', 'banque')->count();
        $moyens_paiements_via_mm = DB::table('moyens_paiements')->where('systeme', 'mobile_money')->count();

        $roles = DB::table('roles')->count();
        $users = DB::table('users')->count();
        $entrepreneurs = DB::table('users')->where('role_id', 3)->count();
        $vendeurs = DB::table('users')->where('role_id', 4)->count();
        $gestionnaires = DB::table('users')->where('role_id', 5)->count();
        $entreprises = DB::table('entreprises')->count();
        $boutiques = DB::table('boutiques')->count();
        
        $fournisseurs = DB::table('fournisseurs')->count();
        $ingredients = DB::table('ingredients')->count();
        $produits = DB::table('produits')->count();

        $beneficiaires = DB::table('beneficiaires')->count();
        $nb_depenses = DB::table('depenses')->count();
        $mt_depenses = DB::table('depenses')->sum('montant');

        $categories = DB::table('categories')->count();
        $marques = DB::table('marques')->count();
        $articles = DB::table('articles')->count();
        $activites = DB::table('activites')->count();
        $clients = DB::table('clients')->count();
        $prestations = DB::table('prestations')->count();
        $nb_ventes = DB::table('ventes')->count();
        $nb_devis = DB::table('ventes')->where('status_vente', 'd')->count();
        $mt_devis = DB::table('detail_ventes as d')
            ->join('ventes as v', 'v.id', 'd.vente_id')
            ->where('status_vente', 'd')
            ->sum(DB::raw('d.montant*d.quantite'));
        $moyenne_devis = DB::table('detail_ventes as d')
            ->join('ventes as v', 'v.id', 'd.vente_id')
            ->where('status_vente', 'd')
            ->avg(DB::raw('d.montant*d.quantite'));
        $nb_achats = DB::table('achats')->count();
        $nb_productions = DB::table('productions')->count();
        $mt_ventes = DB::table('detail_ventes')->sum(DB::raw('montant*quantite'));
        $mt_achats = DB::table('detail_achats')->sum(DB::raw('montant*quantite'));
        $moyenne_achats = DB::table('detail_achats')->avg(DB::raw('montant*quantite'));
        $cumul_quantite_detail_achats = DB::table('detail_achats')->sum('quantite');
        $cumul_article_detail_achats = DB::table('detail_achats')->count('article_id');
        $mt_prestations = DB::table('taches')->sum('montant');
        $nb_prestations = DB::table('prestations')->count();
        $nb_detail_prestations = DB::table('taches')->count();

        $nb_devis_prestations = DB::table('prestations')->where('status_prestation', 'd')->count();
        $mt_devis_prestations = DB::table('prestations')->where('status_prestation', 'd')->sum('montant');
        $moyenne_devis_prestations = DB::table('prestations')->where('status_prestation', 'd')->avg('montant');
        $best_mountant_devis = DB::table('prestations')->where('status_prestation', 'd')->max('montant');

        $moyenne_ventes = DB::table('detail_ventes')->avg(DB::raw('montant*quantite'));
        $cumul_quantite_detail_ventes = DB::table('detail_ventes')->sum('quantite');
        $cumul_article_detail_ventes = DB::table('detail_ventes')->count('article_id');
        $moyenne_prestations = DB::table('taches')->avg('montant');

        $best_seller = DB::table('detail_ventes')->max(DB::raw('montant*quantite'));
        $best_buy = DB::table('detail_achats')->max(DB::raw('montant*quantite'));
        $best_prestation = DB::table('taches')->max('montant');
        
        $nb_encaissements = DB::table('encaissements')->count();
        $mt_encaissements = DB::table('detail_encaissements')->sum('montant');
            
        $nb_decaissements = DB::table('decaissements')->count();
        $mt_decaissements = DB::table('detail_decaissements')->sum('montant');

        View::share('nb_moyens_paiements', value: $moyens_paiements);
        View::share('nb_moyens_paiements_via_bank', value: $moyens_paiements_via_bank);
        View::share('nb_moyens_paiements_via_mm', value: $moyens_paiements_via_mm);

        View::share('nb_roles', value: $roles);
        View::share('nb_entreprises', value: $entreprises);
        View::share('nb_boutiques', value: $boutiques);
        View::share('nb_users', value: $users);
        View::share('nb_entrepreneurs', value: $entrepreneurs);
        View::share('nb_vendeurs', value: $vendeurs);
        View::share('nb_gestionnaires', value: $gestionnaires);

        View::share('nb_categories', value: $categories);
        View::share('nb_marques', value: $marques);
        View::share('nb_articles', value: $articles);
        View::share('nb_produits', value: $produits);
        View::share('nb_ingredients', value: $ingredients);
        View::share('nb_activites', value: $activites);
        View::share('nb_clients', value: $clients);

        View::share('nb_devis_prestations', value: $nb_devis_prestations);
        View::share('mt_devis_prestations', value: $mt_devis_prestations);
        View::share('moyenne_devis_prestations', value: $moyenne_devis_prestations);
        View::share('best_mountant_devis', value: $best_mountant_devis);

        View::share('nb_ventes', value: $nb_ventes);
        View::share('nb_devis', value: $nb_devis);
        View::share('mt_devis', value: $mt_devis);
        View::share('mt_ventes', value: $mt_ventes);
        View::share('mt_prestations', value: $mt_prestations);
        View::share('nb_prestations', value: $nb_prestations);
        View::share('nb_detail_prestations', value: $nb_detail_prestations);
        View::share('moyenne_ventes', value: $moyenne_ventes);
        View::share('moyenne_devis', value: $moyenne_devis);
        View::share('moyenne_achats', value: $moyenne_achats);
        View::share('best_buy', value: $best_buy);
        View::share('cumul_quantite_detail_ventes', value: $cumul_quantite_detail_ventes);
        View::share('cumul_article_detail_ventes', value: $cumul_article_detail_ventes);
        View::share('cumul_quantite_detail_achats', value: $cumul_quantite_detail_achats);
        View::share('cumul_article_detail_achats', value: $cumul_article_detail_achats);
        View::share('best_seller', value: $best_seller);
        View::share('best_prestation', value: $best_prestation);
        View::share('moyenne_prestations', value: $moyenne_prestations);

        View::share('nb_fournisseurs', value: $fournisseurs);
        View::share('nb_achats', value: $nb_achats);
        View::share('mt_achats', value: $mt_achats);
        View::share('nb_productions', value: $nb_productions);

        View::share('nb_beneficiaires', value: $beneficiaires);
        View::share('nb_depenses', value: $nb_depenses);
        View::share('mt_depenses', value: $mt_depenses);

        View::share('nb_total_depenses', value: $nb_depenses+$nb_achats);
        View::share('mt_total_depenses', value: $mt_depenses+$mt_achats);

        View::share('nb_encaissements', value: $nb_encaissements);
        View::share('mt_encaissements', value: $mt_encaissements);

        View::share('nb_decaissements', value: $nb_decaissements);
        View::share('mt_decaissements', value: $mt_decaissements);
    }
}
