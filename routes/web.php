<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/* Route::get('admin/finances/decaissements', function () {
    return view('back.decaissements.dev');
})->name('admin.finances.decaissements');

Route::get('admin/finances/decaissements/decaissement/visualisation/{id}', function () {
    return view('back.decaissements.details');
})->name('admin.finances.decaissements.decaissement.details');

Route::get('admin/finances/decaissements/decaissement/modification/{id}', function () {
    return view('back.decaissements.edition');
})->name('admin.finances.decaissements.decaissement.edit'); */

Route::prefix('authentification')->group(function () {
    /* Auth::routes(); */
    Auth::routes(['register' => true]);
    Route::get('mfa', [App\Http\Controllers\Auth\MFAController::class, 'showVerify'])->name('mfa.show');
    Route::post('mfa/send', [App\Http\Controllers\Auth\MFAController::class, 'sendCode'])->name('mfa.send');
    Route::post('mfa/verify-otp', [App\Http\Controllers\Auth\MFAController::class, 'verifyOtp'])->name('mfa.verify.otp');
    Route::post('mfa/verify-totp', [App\Http\Controllers\Auth\MFAController::class, 'verifyTotp'])->name('mfa.verify.totp');
    /* 
    Route::get('mfa/setup', [App\Http\Controllers\Auth\MFAController::class, 'setup'])->name('mfa.setup');
    Route::post('mfa/resend', [App\Http\Controllers\Auth\MFAController::class, 'resend'])->name('mfa.resend');
 */
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*** Espace DEV ***/
Route::group(['as' => 'dev.', 'prefix' => 'dev', 'namespace' => 'Dev', 'middleware' => ['auth', 'dev', 'mfa.verified']], function () {
    Route::get('dashboard', [App\Http\Controllers\Dev\DashboardController::class, 'index'])->name('dashboard');

    Route::get('inventaires/categories', [App\Http\Controllers\Dev\CategorieController::class, 'index'])->name('inventaires.categories');
    Route::get('inventaires/marques', [App\Http\Controllers\Dev\MarqueController::class, 'index'])->name('inventaires.marques');
    Route::get('inventaires/articles', [App\Http\Controllers\Dev\ArticleController::class, 'index'])->name('inventaires.articles');

    /* Transactions */
    Route::get('transactions/clients', [App\Http\Controllers\Dev\ClientController::class, 'index'])->name('transactions.clients');
    Route::get('transactions/ventes', [App\Http\Controllers\Dev\VenteController::class, 'index'])->name('transactions.ventes');
    Route::get('transactions/ventes/operations', [App\Http\Controllers\Dev\VenteController::class, 'operations'])->name('transactions.ventes.operations');
    Route::get('transactions/ventes/tracking-devis', [App\Http\Controllers\Dev\VenteController::class, 'tracking'])->name('transactions.ventes.tracking-devis');
    Route::get('transactions/ventes/devis/nouveau', [App\Http\Controllers\Dev\VenteController::class, 'nouveau_devis'])->name('transactions.ventes.devis.nouveau');
    Route::get('transactions/ventes/vente/nouveau', [App\Http\Controllers\Dev\VenteController::class, 'nouvelle_vente'])->name('transactions.ventes.vente.nouveau');
    
    Route::get('transactions/ventes/visualisation/{id}', [App\Http\Controllers\Dev\VenteController::class, 'details'])->name('transactions.ventes.vente.details');
    Route::get('transactions/ventes/modification/{id}', [App\Http\Controllers\Dev\VenteController::class, 'modification'])->name('transactions.ventes.vente.edit');
    /* Transactions */
    
    /* Productions */
    Route::get('productions/ingredients', [App\Http\Controllers\Dev\IngredientController::class, 'index'])->name('productions.ingredients');
    Route::get('productions/produits', [App\Http\Controllers\Dev\ProduitController::class, 'index'])->name('productions.produits');
    Route::get('productions/productions', [App\Http\Controllers\Dev\ProductionController::class, 'index'])->name('productions.productions');
    Route::get('productions/productions/nouveau', [App\Http\Controllers\Dev\ProductionController::class, 'nouvelle_production'])->name('productions.productions.nouveau');
    Route::get('productions/productions/operations', [App\Http\Controllers\Dev\ProductionController::class, 'operations'])->name('productions.productions.operations');
    
    Route::get('productions/productions/visualisation/{id}', [App\Http\Controllers\Dev\ProductionController::class, 'details'])->name('productions.productions.details');
    Route::get('productions/productions/modification/{id}', [App\Http\Controllers\Dev\ProductionController::class, 'modification'])->name('productions.productions.edit');
    /* Productions */

    /* Prestations */
    Route::get('prestations/activites', [App\Http\Controllers\Dev\ActiviteController::class, 'index'])->name('prestations.activites');
    Route::get('prestations/prestations', [App\Http\Controllers\Dev\PrestationController::class, 'index'])->name('prestations.prestations');
    Route::get('prestations/operations', [App\Http\Controllers\Dev\PrestationController::class, 'operations'])->name('prestations.operations');
    Route::get('prestations/prestations/tracking-devis', [App\Http\Controllers\Dev\PrestationController::class, 'tracking'])->name('prestations.prestations.tracking-devis');
    Route::get('prestations/devis/nouveau', [App\Http\Controllers\Dev\PrestationController::class, 'nouveau_devis'])->name('prestations.devis.nouveau');
    Route::get('prestations/facture/nouveau', [App\Http\Controllers\Dev\PrestationController::class, 'nouvelle_facture'])->name('prestations.facture.nouveau');
    
    Route::get('prestations/prestation/visualisation/{id}', [App\Http\Controllers\Dev\PrestationController::class, 'details'])->name('prestations.prestation.details');
    Route::get('prestations/prestation/modification/{id}', [App\Http\Controllers\Dev\PrestationController::class, 'modification'])->name('prestations.prestation.edit');
    /* Prestations */
    
    /* Depenses */
    Route::get('depenses/achats/fournisseurs', [App\Http\Controllers\Dev\FournisseurController::class, 'index'])->name('depenses.achats.fournisseurs');
    Route::get('depenses/achats/achats', [App\Http\Controllers\Dev\AchatController::class, 'index'])->name('depenses.achats.achats');
    Route::get('depenses/achats/operations', [App\Http\Controllers\Dev\AchatController::class, 'operations'])->name('depenses.achats.operations');
    Route::get('depenses/achats/facture/nouveau', [App\Http\Controllers\Dev\AchatController::class, 'nouvel_achat'])->name('depenses.achats.facture.nouveau');
    
    Route::get('depenses/achats/visualisation/{id}', [App\Http\Controllers\Dev\AchatController::class, 'details'])->name('depenses.achats.achat.details');
    Route::get('depenses/achats/modification/{id}', [App\Http\Controllers\Dev\AchatController::class, 'modification'])->name('depenses.achats.achat.edit');
    /* Depenses */

    /* Autres Depenses */
    Route::get('autres-depenses/beneficiaires', [App\Http\Controllers\Dev\BeneficiaireController::class, 'index'])->name('autres-depenses.beneficiaires');
    Route::get('autres-depenses/depenses', [App\Http\Controllers\Dev\DepenseController::class, 'index'])->name('autres-depenses.depenses');
    Route::get('autres-depenses/depenses/nouveau', [App\Http\Controllers\Dev\DepenseController::class, 'nouvelle_depense'])->name('autres-depenses.depenses.nouveau');
    /* Autres Depenses */

    /* Encaissements */
    Route::get('finances/encaissements', [App\Http\Controllers\Dev\EncaissementController::class, 'index'])->name('finances.encaissements');
    Route::get('finances/encaissements/visualisation/{id}', [App\Http\Controllers\Dev\EncaissementController::class, 'details'])->name('finances.encaissements.details');
    Route::get('finances/encaissements/modification/{id}', [App\Http\Controllers\Dev\EncaissementController::class, 'edition'])->name('finances.encaissements.edit');
    /* Encaissements */
    
    /* Decaissements */
    Route::get('finances/decaissements', [App\Http\Controllers\Dev\DecaissementController::class, 'index'])->name('finances.decaissements');
    Route::get('finances/decaissements/visualisation/{id}', [App\Http\Controllers\Dev\DecaissementController::class, 'details'])->name('finances.decaissements.details');
    Route::get('finances/decaissements/modification/{id}', [App\Http\Controllers\Dev\DecaissementController::class, 'edition'])->name('finances.decaissements.edit');
    /* Decaissements */

    /* Recouvrement */
    Route::get('finances/recouvrements/solde', [App\Http\Controllers\Dev\RecouvrementController::class, 'index'])->name('finances.recouvrements.solde');
    Route::get('finances/recouvrements/creances', [App\Http\Controllers\Dev\RecouvrementController::class, 'creances'])->name('finances.recouvrements.creances');
    Route::get('finances/recouvrements/dettes', [App\Http\Controllers\Dev\RecouvrementController::class, 'dettes'])->name('finances.recouvrements.dettes');
    /* Recouvrement */

    /* ACL */
    Route::get('acl/roles', [App\Http\Controllers\Dev\RoleController::class, 'index'])->name('acl.roles');
    Route::get('acl/entreprises', [App\Http\Controllers\Dev\EntrepriseController::class, 'index'])->name('acl.entreprises');
    Route::get('acl/boutiques', [App\Http\Controllers\Dev\BoutiqueController::class, 'index'])->name('acl.boutiques');
    Route::get('acl/utilisateurs', [App\Http\Controllers\Dev\UserController::class, 'index'])->name('acl.utilisateurs');
    /* ACL */
    
    /* Systeme de Paie */ 
    Route::get('systemes-paiements', [App\Http\Controllers\Dev\SystemesPaieController::class, 'index'])->name('systemes.paiements');

});
/*** Espace DEV ***/

/*** Espace ADMIN ***/
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    /* Route::get('profile', [App\Http\Controllers\AdminPret\ProfileController::class, 'profile'])->name('profile');
    Route::post('changePassword', [App\Http\Controllers\AdminPret\ProfileController::class, 'Passwordchanged']);

    Route::get('services', [App\Http\Controllers\AdminPret\ServiceController::class, 'index'])->name('services');
    Route::get('employes', [App\Http\Controllers\AdminPret\EmployeController::class, 'index'])->name('employes');
    Route::get('prets', [App\Http\Controllers\AdminPret\PretController::class, 'index'])->name('prets');
    Route::get('prets/visualisation/{id}', [App\Http\Controllers\AdminPret\PretController::class, 'details'])->name('prets.details');
    Route::get('prets/modification/{id}', [App\Http\Controllers\AdminPret\PretController::class, 'edition'])->name('prets.edition');
    Route::get('listings', [App\Http\Controllers\AdminPret\ListingController::class, 'index'])->name('listings');

    Route::get('users', [App\Http\Controllers\AdminPret\UserController::class, 'index'])->name('users');

    Route::get('reporting', [App\Http\Controllers\AdminPret\ReportingController::class, 'index'])->name('reporting'); */
});
/*** Espace ADMIN ***/

/*** Espace Entrepreneur ***/
Route::group(['as' => 'entrepreneur.', 'prefix' => 'entrepreneur', 'namespace' => 'Entrepreneur', 'middleware' => ['auth', 'entrepreneur']], function () {
    Route::get('dashboard', [App\Http\Controllers\Entrepreneur\DashboardController::class, 'index'])->name('dashboard');

    /* Route::get('profile', [App\Http\Controllers\AdminPret\ProfileController::class, 'profile'])->name('profile');
    Route::post('changePassword', [App\Http\Controllers\AdminPret\ProfileController::class, 'Passwordchanged']);

    Route::get('services', [App\Http\Controllers\AdminPret\ServiceController::class, 'index'])->name('services');
    Route::get('employes', [App\Http\Controllers\AdminPret\EmployeController::class, 'index'])->name('employes');
    Route::get('prets', [App\Http\Controllers\AdminPret\PretController::class, 'index'])->name('prets');
    Route::get('prets/visualisation/{id}', [App\Http\Controllers\AdminPret\PretController::class, 'details'])->name('prets.details');
    Route::get('prets/modification/{id}', [App\Http\Controllers\AdminPret\PretController::class, 'edition'])->name('prets.edition');
    Route::get('listings', [App\Http\Controllers\AdminPret\ListingController::class, 'index'])->name('listings');

    Route::get('users', [App\Http\Controllers\AdminPret\UserController::class, 'index'])->name('users');

    Route::get('reporting', [App\Http\Controllers\AdminPret\ReportingController::class, 'index'])->name('reporting'); */
});
/*** Espace Entrepreneur ***/

/*** Espace Employe ***/
Route::group(['as' => 'employe.', 'prefix' => 'employe', 'namespace' => 'Employe', 'middleware' => ['auth', 'employe']], function () {
    Route::get('dashboard', [App\Http\Controllers\Employe\DashboardController::class, 'index'])->name('dashboard');

    /* Route::get('profile', [App\Http\Controllers\AdminPret\ProfileController::class, 'profile'])->name('profile');
    Route::post('changePassword', [App\Http\Controllers\AdminPret\ProfileController::class, 'Passwordchanged']);

    Route::get('services', [App\Http\Controllers\AdminPret\ServiceController::class, 'index'])->name('services');
    Route::get('employes', [App\Http\Controllers\AdminPret\EmployeController::class, 'index'])->name('employes');
    Route::get('prets', [App\Http\Controllers\AdminPret\PretController::class, 'index'])->name('prets');
    Route::get('prets/visualisation/{id}', [App\Http\Controllers\AdminPret\PretController::class, 'details'])->name('prets.details');
    Route::get('prets/modification/{id}', [App\Http\Controllers\AdminPret\PretController::class, 'edition'])->name('prets.edition');
    Route::get('listings', [App\Http\Controllers\AdminPret\ListingController::class, 'index'])->name('listings');

    Route::get('users', [App\Http\Controllers\AdminPret\UserController::class, 'index'])->name('users');

    Route::get('reporting', [App\Http\Controllers\AdminPret\ReportingController::class, 'index'])->name('reporting'); */
});
/*** Espace Employe ***/