<?php

use App\Http\Controllers\AchatChequeController;
use App\Http\Controllers\AchatController;
use App\Http\Controllers\AchatPaiementController;
use App\Http\Controllers\AchatRapportController;
use App\Http\Controllers\AvoireController;
use Illuminate\Support\Facades\Route;
// use Spatie\Permission\Models\Permission;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\FactureProduitController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CaracteristiqueController;
use App\Http\Controllers\CustomizeAchatController;
use App\Http\Controllers\CustomizeVenteController;
use App\Http\Controllers\DepotController;
use App\Http\Controllers\FactureLivraisonController;
use App\Http\Controllers\FacturePaiementController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LigneAchatController;
use App\Http\Controllers\LigneAvoireController;
use App\Http\Controllers\LigneRapportController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\ProduitCaracteristiqueController;
use App\Http\Controllers\ProduitCategorieController;
use App\Http\Controllers\ProduitFicheController;
use App\Http\Controllers\ProduitSousCategorieController;
use App\Http\Controllers\RapportAchatController;
use App\Http\Controllers\RapportClientController;
use App\Http\Controllers\RapportFournisseurController;
use App\Http\Controllers\RapportVenteController;
use App\Http\Controllers\SousCategorieController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockDepotController;
use App\Http\Controllers\StockHistoriqueController;
use App\Http\Controllers\TauxTvaController;
use App\Http\Controllers\TresorerierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TypeClientController;

Route::group(['middleware' => ['auth']], function() {
    Route::resource("/group",GroupController::class);
    Route::resource("/categorie",CategorieController::class);
    Route::resource("/facture",FactureController::class);
    Route::resource("/produitFiche",ProduitFicheController::class);


    Route::controller(StockHistoriqueController::class)->group(function(){
      Route::post('/stock-historique/{id}/augmenter','augmenter')->name("stockHistorique.augmenter");
      Route::post('/stock-historique/{id}/resign','resign')->name("stockHistorique.resign");
    });


    Route::controller(HistoriqueController::class)->group(function(){
      Route::get('/historiques','index')->name("historique.index");
      Route::get('/historiques/categorie','show')->name("historique.categories");
      Route::get('/historiques/groupes','groupes')->name("historique.groupes");
      Route::get('/historiques/entreprises','entreprises')->name("historique.entreprises");
      Route::get('/historiques/typeClients','typeClients')->name("historique.typeClients");
      Route::get('/historiques/livraisons','livraisons')->name("historique.livraisons");
      Route::get('/historiques/conditionPaiement','condition_paiements')->name("historique.conditionPaiements");
      Route::get('/historiques/taux','taux_tva')->name("historique.taux");
      Route::get('/historiques/clients','clients')->name("historique.clients");
      Route::get('/historiques/users','users')->name("historique.users");
      Route::get('/historiques/achatPaiements','achatPaiements')->name("historique.achatPaiements");
      Route::get('/historiques/achatCheques','achatCheques')->name("historique.achatCheques");
      Route::get('/historiques/facturePaiements','facturePaiements')->name("historique.facturePaiements");
      Route::get('/historiques/factureCheques','factureCheques')->name("historique.factureCheques");
    });

    Route::controller(FactureController::class)->group(function(){
      Route::put('/facture-valider/{facture}','valider')->name("facture.valider");
      Route::get('/facture/{facture}/checkDepot', 'checkDepot')->name("facture.checkDepot");
      Route::get('/factures/today', 'now')->name("facture.today");
         Route::get('facture/pdf/{facture}','showPdf')->name("facture.showPdf");
      Route::get('facture/{facture}/preforma','facturePreforma')->name("facture.preforma");
      Route::get('facture/{facture}/devis','devis')->name("facture.devis");

    });
    Route::resource("/factureProduit",FactureProduitController::class);
    Route::controller(FactureProduitController::class)->group(function(){
      Route::get('/facture/{id}/addProduits','add')->name("factureProduit.add");
    });


    Route::resource("/tauxTva",TauxTvaController::class);
    Route::resource("/entreprise",EntrepriseController::class);
    Route::resource("/typeClient",TypeClientController::class);
    Route::controller(CustomizeAchatController::class)->group(function(){
      Route::get('customize-achats','index')->name("customizeAchat.index");
      Route::post('achats/references/default','default')->name("achatReferences.default");
      Route::put('customize-achats/references/update','updateReferences')->name("customizeAchat.updateReferences");
    });

    Route::controller(CustomizeVenteController::class)->group(function(){
      Route::get('customize-ventes','index')->name("customizeVente.index");
      Route::post('ventes/references/default','default')->name("venteReferences.default");
      Route::put('customize-ventes/references/update','updateReferences')->name("customizeVente.updateReferences");
    });

    Route::resource("facturePaiement",FacturePaiementController::class)->except("create");
    Route::controller(FacturePaiementController::class)->group(function(){
      Route::get('facturePaiement/{facturePaiement}/recu','recu')->name("facturePaiement.recu");
      Route::get('facturePaiement/{facturePaiement}/info','minInfo')->name("facturePaiement.minInfo");
      Route::get('facturePaiement/{id}/add','add')->name("facturePaiement.add");
    });
   
 
    Route::resource("stock",StockController::class)->except(["create"]);
    Route::controller(StockController::class)->group(function(){
      Route::get('/reference-stock','filterReference')->name("stock.reference");
      Route::get('/stock/{id}/new','new')->name("stock.add");

    });
    Route::resource("produit",ProduitController::class);
    Route::controller(ProduitController::class)->group(function(){
      Route::post('produits/import','import')->name("produit.import");
      Route::get('produits/example','example')->name("produit.example");
    });
    Route::controller(ProduitCategorieController::class)->group(function(){
      Route::post('produitCategorie','store')->name("produitCategorie.store");
      Route::delete('produitCategorie/{proCategorie_id}','destroy')->name("produitCategorie.destroy");
    });
    Route::controller(TresorerierController::class)->group(function(){
      Route::get('plan-tresorie','planCommande')->name("tresorerie.plan");
      Route::get('tresoririer-document','commandeDocument')->name("tresorerie.docCommande");
    });
    Route::controller(ProduitSousCategorieController::class)->group(function(){
      Route::post('produitSousCategorie','store')->name("produitSousCategorie.store");
      Route::delete('produitSousCategorie/{id}','destroy')->name("produitSousCategorie.destroy");
    });

    Route::controller(LigneRapportController::class)->group(function () {
      Route::get('/ligneRapports', 'index')->name("ligneRapport.index");
      Route::get('/ligneRapport/{ligneRapport}', 'show')->name("ligneRapport.show");
      Route::get('/rapports/liste/buySell', 'liste_buySell')->name("ligneRapport.listeBuySell");
      Route::get('/rapports/details/{mois?}/buySell/document', 'documentBuySell')->name("ligneRapport.docBuySell");
      Route::get('/rapport/details/{mois?}/buySell/excel', 'exportBuySell')->name("ligneRapport.exportBuySell");
      Route::get('/rapports/{mois?}/buySell', 'buySell')->name("ligneRapport.buySell");

      Route::get('/rapport/details/{ligneRapport}/ventes', 'ventes')->name("ligneRapport.ventes");

      Route::get('/rapport/details/{ligneRapport}/achats', 'achats')->name("ligneRapport.achats");
      Route::get('/rapport/details/{ligneRapport}/clients', 'clients')->name("ligneRapport.clients");
      Route::get('/rapport/details/{ligneRapport}/fournisseurs', 'fournisseurs')->name("ligneRapport.fournisseurs");

    });

    Route::controller(RapportAchatController::class)->group(function () {

      Route::get('/rapportAchat/{mois?}/achats/document', 'documentAchat')->name("rapportAchat.docAchat");
      Route::get('/rapportAchat/{mois?}/achats/documentDay', 'documentDay')->name("rapportAchat.documentDay");
      Route::get('/rapportAchat/{mois?}/achats/excel', 'exportAchats')->name("rapportAchat.exportAchat");
    });

    Route::controller(RapportVenteController::class)->group(function () {
      Route::get('/rapportVente/{mois?}/ventes/document', 'documentVente')->name("rapportVente.docVente");
      Route::get('/rapportVente/{mois?}/ventes/documentDay', 'documentDay')->name("rapportVente.documentDay");
      Route::get('/rapportVente/{mois?}/ventes/excel', 'exportVentes')->name("rapportVente.exportVente");
    });

    Route::controller(RapportClientController::class)->group(function () {
      Route::get('/rapportClients/{mois?}/clients/document', 'documentClients')->name("rapportClient.docClient");
      Route::get('/rapportClients/{mois?}/clients/documentDay', 'documentDay')->name("rapportClient.documentDay");
      Route::get('/rapportClients/{mois?}/clients/excel', 'exportClients')->name("rapportClient.exportClient");
    });

    Route::controller(RapportFournisseurController::class)->group(function () {
      Route::get('/rapportFournisseurs/{mois?}/fournisseurs/document', 'documentFournisseurs')->name("rapportFournisseur.docFournisseur");
      Route::get('/rapportFournisseurs/{mois?}/fournisseurs/documentDay', 'documentDay')->name("rapportFournisseur.documentDay");
      Route::get('/rapportFournisseurs/{mois?}/fournisseurs/excel', 'exportFournisseurs')->name("rapportFournisseur.exportFournisseur");
    });



    Route::resource("/ligneAchat",LigneAchatController::class);
    Route::controller(LigneAchatController::class)->group(function () {
      Route::put('/achat-valider/{ligneAchat}','valider')->name("ligneAchat.valider");
      Route::get('/bonCommande/{ligneAchat}','bon')->name("ligneAchat.bon");
      Route::get('/ligneAchat/{ligneAchat}/checkDepot','checkDepot')->name("ligneAchat.checkDepot");
      Route::get('/facture/{ligneAchat}','document')->name("ligneAchat.facture");
      Route::get('/facture/{ligneAchat}/demandePrice','demandePrice')->name("ligneAchat.demandePrice");
    });
    Route::controller(ProduitCaracteristiqueController::class)->group(function(){
      Route::post('produitCaracteristique/','store')->name("produitCaracteristique.store");
      Route::put('produitCaracteristique/{id}','update')->name("produitCaracteristique.update");
      Route::delete('produitCaracteristique/{id}','destroy')->name("produitCaracteristique.destroy");
    });
    Route::resource("/fournisseur",FournisseurController::class);
    Route::controller(FournisseurController::class)->group(function(){
      Route::get('/fournisseur/{fournisseur}/paiements','paiements')->name("fournisseur.paiement");
      Route::get('/fournisseur/{fournisseur}/ligneAchats','ligneAchats')->name("fournisseur.ligneAchat");
      Route::get('/fournisseur/{fournisseur}/rapport','rapportDocument')->name("fournisseur.rapportDocument");
    });
    Route::resource("/client",ClientController::class);
    Route::controller(ClientController::class)->group(function(){
      Route::get('/client/{client}/rapport','rapportDocument')->name("client.rapportDocument");
      Route::post('clients/import','import')->name("client.import");
      Route::get('clients/example','example')->name("client.example");
    });

    Route::resources([
      "client"                 => ClientController::class,
      "profil"                 => ProfilController::class,
      "user"                   => UserController::class,
      "role"                   => RoleController::class,
      "sousCategorie"          => SousCategorieController::class,
      "achatCheque"            => AchatChequeController::class,
    ]);


Route::get('/getGroup',[ClientController::class,'getGroup'])->name("getGroup");

Route::controller(GetDataController::class)->group(function(){
    Route::get('/get-group-client','GroupClient')->name("clientGroup");
    Route::get('/getProduit','getProduit')->name("getProduit");
    Route::get('/client-year','ClientYear')->name("clientYear");

});


Route::controller(ProfilController::class)->group(function(){
    Route::put('/password/{profil}/update','updatePwd')->name("pwd.update");
});







Route::controller(FacturePaiementController::class)->group(function(){
    Route::get('/paiement-clients','facture_paiement')->name("paiement.facture");
    Route::get('/paiement-fiches','client_paiement')->name("paiement.client");
    Route::get('/information-paiement-client/{client}','cp_details')->name("paycli.details");
});






Route::get('/',[HomeController::class,'index'])->name('home');

});




















Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

