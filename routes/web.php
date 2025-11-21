<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin', function () {
    return view('back.dashboard.dev');
})->name('dev.dashboard');

Route::get('admin/acl/roles', function () {
    return view('back.roles.dev');
})->name('admin.acl.roles');

Route::get('admin/acl/entreprises', function () {
    return view('back.entreprises.dev');
})->name('admin.acl.entreprises');

Route::get('admin/acl/boutiques', function () {
    return view('back.boutiques.dev');
})->name('admin.acl.boutiques');

Route::get('admin/acl/utilisateurs', function () {
    return view('back.utilisateurs.dev');
})->name('admin.acl.utilisateurs');

Route::get('admin/inventaires/categories', function () {
    return view('back.categories.dev');
})->name('admin.inventaires.categories');

Route::get('admin/inventaires/marques', function () {
    return view('back.marques.dev');
})->name('admin.inventaires.marques');

Route::get('admin/inventaires/articles', function () {
    return view('back.articles.dev');
})->name('admin.inventaires.articles');

Route::get('admin/transactions/clients', function () {
    return view('back.clients.dev');
})->name('admin.transactions.clients');

Route::get('admin/transactions/ventes', function () {
    return view('back.ventes.dev');
})->name('admin.transactions.ventes');

Route::get('admin/transactions/ventes/devis/nouveau', function () {
    return view('back.ventes.nouveau_devis');
})->name('admin.transactions.ventes.devis.nouveau');

Route::get('admin/transactions/ventes/vente/nouveau', function () {
    return view('back.ventes.nouvelle_vente');
})->name('admin.transactions.ventes.vente.nouveau');

Route::get('admin/transactions/ventes/visualisation/{id}', function () {
    return view('back.ventes.details');
})->name('admin.transactions.ventes.vente.details');
    
Route::get('admin/transactions/ventes/modification/{id}', function () {
    return view('back.ventes.edition');
})->name('admin.transactions.ventes.vente.edit');
/* Ventes */

/* Prestations */
Route::get('admin/prestations/activites', function () {
    return view('back.activites.dev');
})->name('admin.prestations.activites');

Route::get('admin/prestations/prestations', function () {
    return view('back.prestations.dev');
})->name('admin.prestations.prestations');

Route::get('admin/prestations/devis/nouveau', function () {
    return view('back.prestations.nouveau_devis');
})->name('admin.prestations.devis.nouveau');

Route::get('admin/prestations/facture/nouveau', function () {
    return view('back.prestations.nouvelle_facture');
})->name('admin.prestations.facture.nouveau');

Route::get('admin/prestations/prestation/visualisation/{id}', function () {
    return view('back.prestations.details');
})->name('admin.prestations.prestation.details');
    
Route::get('admin/prestations/prestation/modification/{id}', function () {
    return view('back.prestations.edition');
})->name('admin.prestations.prestation.edit');
/* Prestations */

/* Depenses */
Route::get('admin/depenses/achats/fournisseurs', function () {
    return view('back.fournisseurs.dev');
})->name('admin.depenses.achats.fournisseurs');

Route::get('admin/depenses/achats/achats', function () {
    return view('back.achats.dev');
})->name('admin.depenses.achats.achats');

Route::get('admin/depenses/achats/facture/nouveau', function () {
    return view('back.achats.nouvel_achat');
})->name('admin.depenses.achats.facture.nouveau');

Route::get('admin/depenses/achats/visualisation/{id}', function () {
    return view('back.achats.details');
})->name('admin.depenses.achats.details');
    
Route::get('admin/depenses/achats/modification/{id}', function () {
    return view('back.achats.edition');
})->name('admin.depenses.achats.edit');
/* Depenses */

/* Autres Depenses */
Route::get('admin/autres-depenses/beneficiaires', function () {
    return view('back.beneficiaires.dev');
})->name('admin.autres-depenses.beneficiaires');

Route::get('admin/autres-depenses/depenses', function () {
    return view('back.depenses.dev');
})->name('admin.autres-depenses.depenses');

Route::get('admin/autres-depenses/depense/nouveau', function () {
    return view('back.depenses.nouvelle_depense');
})->name('admin.autres-depenses.depense.nouveau');

/* Autres Depenses */


/* Productions */
Route::get('admin/productions/ingredients', function () {
    return view('back.ingredients.dev');
})->name('admin.productions.ingredients');

Route::get('admin/productions/produits', function () {
    return view('back.produits.dev');
})->name('admin.productions.produits');

Route::get('admin/productions/productions', function () {
    return view('back.productions.dev');
})->name('admin.productions.productions');
    
Route::get('admin/productions/productions/facture/nouveau', function () {
    return view('back.productions.nouvelle_production');
})->name('admin.productions.productions.facture.nouveau');

Route::get('admin/productions/productions/visualisation/{id}', function () {
    return view('back.achats.details');
})->name('admin.productions.productions.details');
    
Route::get('admin/productions/productions/modification/{id}', function () {
    return view('back.achats.edition');
})->name('admin.productions.productions.edit');
/* Productions */

Route::get('admin/systemes-paiements', function () {
    return view('back.systemes_paies.dev');
})->name('admin.systemes.paiements');

Route::get('admin/finances/encaissements', function () {
    return view('back.encaissements.dev');
})->name('admin.finances.encaissements');

Route::get('admin/finances/encaissements/encaissement/visualisation/{id}', function () {
    return view('back.encaissements.details');
})->name('admin.finances.encaissements.encaissement.details');

Route::get('admin/finances/encaissements/encaissement/modification/{id}', function () {
    return view('back.encaissements.edition');
})->name('admin.finances.encaissements.encaissement.edit');

Route::get('admin/finances/decaissements', function () {
    return view('back.decaissements.dev');
})->name('admin.finances.decaissements');

Route::get('admin/finances/decaissements/decaissement/visualisation/{id}', function () {
    return view('back.decaissements.details');
})->name('admin.finances.decaissements.decaissement.details');

Route::get('admin/finances/decaissements/decaissement/modification/{id}', function () {
    return view('back.decaissements.edition');
})->name('admin.finances.decaissements.decaissement.edit');

Route::prefix('authentification')->group(function () {
    /* Auth::routes(); */
    Auth::routes(['register' => true]);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*** Espace DEV ***/
/* Route::group(['as' => 'dev.', 'prefix' => 'dev', 'namespace' => 'Dev', 'middleware' => ['auth', 'dev']], function () {
    Route::get('dashboard', [App\Http\Controllers\AdminPret\DashboardController::class, 'index'])->name('dashboard');

    Route::get('profile', [App\Http\Controllers\AdminPret\ProfileController::class, 'profile'])->name('profile');
    Route::post('changePassword', [App\Http\Controllers\AdminPret\ProfileController::class, 'Passwordchanged']);

    Route::get('services', [App\Http\Controllers\AdminPret\ServiceController::class, 'index'])->name('services');
    Route::get('employes', [App\Http\Controllers\AdminPret\EmployeController::class, 'index'])->name('employes');
    Route::get('prets', [App\Http\Controllers\AdminPret\PretController::class, 'index'])->name('prets');
    Route::get('prets/visualisation/{id}', [App\Http\Controllers\AdminPret\PretController::class, 'details'])->name('prets.details');
    Route::get('prets/modification/{id}', [App\Http\Controllers\AdminPret\PretController::class, 'edition'])->name('prets.edition');
    Route::get('listings', [App\Http\Controllers\AdminPret\ListingController::class, 'index'])->name('listings');

    Route::get('users', [App\Http\Controllers\AdminPret\UserController::class, 'index'])->name('users');

    Route::get('reporting', [App\Http\Controllers\AdminPret\ReportingController::class, 'index'])->name('reporting');
}); */
/*** Espace DEV ***/
