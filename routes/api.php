<?php

use App\Http\Controllers\API\AchatController;
use App\Http\Controllers\API\ActiviteController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\BeneficiaireController;
use App\Http\Controllers\API\BoutiqueController;
use App\Http\Controllers\API\CategorieController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\DecaissementController;
use App\Http\Controllers\API\DepenseController;
use App\Http\Controllers\API\EncaissementController;
use App\Http\Controllers\API\EntrepriseController;
use App\Http\Controllers\API\FournisseurController;
use App\Http\Controllers\API\IngredientController;
use App\Http\Controllers\API\MarqueController;
use App\Http\Controllers\API\MissionController;
use App\Http\Controllers\API\PrestationController;
use App\Http\Controllers\API\ProductionController;
use App\Http\Controllers\API\ProduitController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\SystemePaiementController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VenteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResources([
    'roles'=> RoleController::class,
    'entreprises'=> EntrepriseController::class,
    'users'=> UserController::class,
    'boutiques'=> BoutiqueController::class,

    'categories'=> CategorieController::class,
    'marques'=> MarqueController::class,
    'articles'=> ArticleController::class,
    'ingredients'=> IngredientController::class,
    'produits'=> ProduitController::class,
    'productions'=> ProductionController::class,
    'activites'=> ActiviteController::class,
    
    'clients'=> ClientController::class,
    'ventes'=> VenteController::class,
    'prestations'=> PrestationController::class,

    'fournisseurs'=> FournisseurController::class,
    'achats'=> AchatController::class,

    'beneficiaires'=> BeneficiaireController::class,
    'depenses'=> DepenseController::class,

    'encaissements'=> EncaissementController::class,
    'decaissements'=> DecaissementController::class,

    'systemes_paies'=> SystemePaiementController::class,
]);

/* Dropdown */
Route::get('json-moyens-paie', [App\Http\Controllers\API\DropdownController::class, 'mode_encaissement']);
Route::get('json-infos-client', [App\Http\Controllers\API\DropdownController::class, 'infos_client']);
Route::get('json-infos-fournisseur', [App\Http\Controllers\API\DropdownController::class, 'infos_fournisseur']);
Route::get('json-infos-beneficiaire', [App\Http\Controllers\API\DropdownController::class, 'infos_beneficiaire']);
Route::get('json-infos-article', [App\Http\Controllers\API\DropdownController::class, 'infos_article']);
Route::get('json-infos-produit', [App\Http\Controllers\API\DropdownController::class, 'infos_produit']);
Route::get('json-infos-activite', [App\Http\Controllers\API\DropdownController::class, 'infos_activite']);
/* Dropdown */


/* Checking user */
Route::post('check-email-users', [UserController::class, 'checkEmail'])->name('check-email-users');
Route::post('check-username-users', [UserController::class, 'checkUsername'])->name('check-username-users');
Route::post('check-telephone-users', [UserController::class, 'checkTelephone'])->name(name: 'check-telephone-users');
/* Checking user */

/* Edition de la vente */
Route::post('modification-client-vente/{id}', [App\Http\Controllers\API\VenteController::class, 'modification_client_vente']);
Route::post('modification-etat-vente/{id}', [App\Http\Controllers\API\VenteController::class, 'validation_etat_vente']);
Route::post('actualisation-remise-vente/{id}', [App\Http\Controllers\API\VenteController::class, 'actualisation_remise_vente']);
Route::post('modification-statut-vente/{id}', [App\Http\Controllers\API\VenteController::class, 'validation_statut_vente']);

Route::post('ajout-articles-into-details-vente/{id}', [App\Http\Controllers\API\VenteController::class, 'ajout_articles_into_details_vente']);
Route::post('annulation-article-into-details-vente/{id}', [App\Http\Controllers\API\VenteController::class, 'annulation_article_into_details_vente']);
Route::get('details-article-into-details-vente/{id}', [App\Http\Controllers\API\VenteController::class, 'details_article_into_details_vente']);

Route::post('edit-montant-into-details-vente/{id}', [App\Http\Controllers\API\VenteController::class, 'edit_montant_into_details_vente'])->name('edit-montant-into-details-vente');
Route::post('edit-quantite-into-details-vente/{id}', [App\Http\Controllers\API\VenteController::class, 'edit_quantite_into_details_vente'])->name('edit-quantite-into-details-vente');
/* Edition de la vente */

/* Edition de l'achat */
Route::post('modification-fournisseur-achat/{id}', [App\Http\Controllers\API\AchatController::class, 'modification_fournisseur_achat']);
Route::post('modification-etat-achat/{id}', [App\Http\Controllers\API\AchatController::class, 'validation_etat_achat']);
Route::post('actualisation-remise-achat/{id}', [App\Http\Controllers\API\AchatController::class, 'actualisation_remise_achat']);
Route::post('modification-statut-achat/{id}', [App\Http\Controllers\API\AchatController::class, 'validation_statut_achat']);

Route::post('ajout-articles-into-details-achat/{id}', [App\Http\Controllers\API\AchatController::class, 'ajout_articles_into_details_achat']);
Route::post('annulation-article-into-details-achat/{id}', [App\Http\Controllers\API\AchatController::class, 'annulation_article_into_details_achat']);
Route::get('details-article-into-details-achat/{id}', [App\Http\Controllers\API\AchatController::class, 'details_article_into_details_achat']);

Route::post('edit-montant-into-details-achat/{id}', [App\Http\Controllers\API\AchatController::class, 'edit_montant_into_details_achat'])->name('edit-montant-into-details-achat');
Route::post('edit-quantite-into-details-achat/{id}', [App\Http\Controllers\API\AchatController::class, 'edit_quantite_into_details_achat'])->name('edit-quantite-into-details-achat');
Route::post('edit-livraison-into-details-achat/{id}', [App\Http\Controllers\API\AchatController::class, 'edit_livraison_into_details_achat'])->name('edit-livraison-into-details-achat');
/* Edition de l'achat */

/* Edition de la prestation */
Route::post('modification-client-prestation/{id}', [App\Http\Controllers\API\PrestationController::class, 'modification_client_prestation']);
Route::post('modification-etat-prestation/{id}', [App\Http\Controllers\API\PrestationController::class, 'validation_etat_prestation']);
Route::post('modification-statut-prestation/{id}', [App\Http\Controllers\API\PrestationController::class, 'validation_statut_prestation']);

Route::post('ajout-activites-into-taches/{id}', [App\Http\Controllers\API\PrestationController::class, 'ajout_activites_into_taches']);
Route::post('annulation-activite-into-taches/{id}', [App\Http\Controllers\API\PrestationController::class, 'annulation_activite_into_taches']);
Route::get('details-activite-into-taches/{id}', [App\Http\Controllers\API\PrestationController::class, 'details_activite_into_taches']);

Route::post('edit-montant-into-taches/{id}', [App\Http\Controllers\API\PrestationController::class, 'edit_montant_into_taches'])->name('edit-montant-into-taches');
Route::post('edit-duree-into-taches/{id}', [App\Http\Controllers\API\PrestationController::class, 'edit_duree_into_taches'])->name('edit-duree-into-taches');
/* Edition de la prestation */

/* Finances */
/* Edition de l'encaissement */
Route::post('modification-etat-encaissement/{id}', [App\Http\Controllers\API\EncaissementController::class, 'modification_etat_encaissement']);
Route::post('annulation-encaissement/{id}', [App\Http\Controllers\API\EncaissementController::class, 'annulation_encaissement']);

Route::get('details-encaissement/{id}', [App\Http\Controllers\API\EncaissementController::class, 'details_encaissement']);
Route::post('annulation-details-encaissement/{id}', [App\Http\Controllers\API\EncaissementController::class, 'annulation_details_encaissement']);
Route::post('ajout-encaissement-into-details-encaissement/{id}', [App\Http\Controllers\API\EncaissementController::class, 'ajout_encaissement_into_details_encaissement']);

Route::post('edit-montant-into-details-encaissement/{id}', [App\Http\Controllers\API\EncaissementController::class, 'edit_montant_into_details_encaissement'])->name('edit-montant-into-details-encaissement');
Route::post('edit-reference-into-details-encaissement/{id}', [App\Http\Controllers\API\EncaissementController::class, 'edit_reference_into_details_encaissement'])->name('edit-duree-into-taches');
/* Edition de l'encaissement */

/* Edition du décaissement */
Route::post('modification-etat-decaissement/{id}', [App\Http\Controllers\API\DecaissementController::class, 'modification_etat_decaissement']);
Route::post('annulation-decaissement/{id}', [App\Http\Controllers\API\DecaissementController::class, 'annulation_decaissement']);

Route::get('details-decaissement/{id}', [App\Http\Controllers\API\DecaissementController::class, 'details_decaissement']);
Route::post('annulation-details-decaissement/{id}', [App\Http\Controllers\API\DecaissementController::class, 'annulation_details_decaissement']);
Route::post('ajout-decaissement-into-details-decaissement/{id}', [App\Http\Controllers\API\DecaissementController::class, 'ajout_decaissement_into_details_decaissement']);

Route::post('edit-montant-into-details-decaissement/{id}', [App\Http\Controllers\API\DecaissementController::class, 'edit_montant_into_details_decaissement'])->name('edit-montant-into-details-decaissement');
Route::post('edit-reference-into-details-decaissement/{id}', [App\Http\Controllers\API\DecaissementController::class, 'edit_reference_into_details_decaissement'])->name('edit-reference-into-details-decaissement');
/* Edition de l'encaissement */
/* Finances */