<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Facture;
use App\Models\FactureProduit;
use App\Models\Client;
use App\Models\CustomizeReference;
use App\Models\Depot;
use App\Models\DepotSuivi;
use App\Models\Entreprise;
use App\Models\LigneRapport;
use App\Models\Produit;
use App\Models\Rapport;
use App\Models\RapportCrm;
use App\Models\Stock;
use App\Models\StockDepot;
use App\Models\StockHistorique;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

// use Barryvdh\DomPDF\PDF;
// use App\Post;


class FactureController extends Controller
{

  function __construct()
  {
    $this->middleware('permission:facture-list|facture-nouveau|facture-modification|facture-display', ['only' => ['index','show','newPaiement','now']]);

    $this->middleware('permission:facture-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:facture-modification', ['only' => ['edit','checkDepot','update']]);

    $this->middleware('permission:facture-suppression', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $factures   = Facture::all();
    foreach($factures as $ligne){
      $today = Carbon::today();
      $toDate       = Carbon::parse($today);
      $fromDate     = Carbon::parse($ligne->date_paiement);
      $ligne->delai = $toDate->diffInDays($fromDate);
    }
    $all      = [
      'factures'=>$factures,
    ];
    return view('ligneFactures.index',$all);
    }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function now()
  {
    $factures   = Facture::where("dateCreation",Carbon::today())->get();
    $all      = [
      'factures'=>$factures,
    ];
    return view('ligneFactures.today',$all);
    }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $customize_check = CustomizeReference::where("operation","vente")->exists();
    $all = null;
    if($customize_check == true)
    {
      $produits           = DB::table('produits')->where("etat_stock","disponible")->whereNull("deleted_at")->get();
      $clients            = DB::table("clients")->select("id","raison_sociale")->whereNull("deleted_at")->get();
      $entreprises        = DB::table("entreprises")->select("id","raison_sociale")->whereNull("deleted_at")->get();
      $banks              = DB::table("banks")->pluck("nom_bank");
      $tvas               = DB::table("taux_tvas")->pluck("valeur");
      foreach($produits as $produit)
      {
        $check_stock =DB::table("stocks")->where("produit_id",$produit->id)->exists();
        if($check_stock == true) {
          $produit->disponible   = DB::table("stocks")->where("produit_id",$produit->id)->first()->disponible;
        }
      }
      $all = [
        'clients'            => $clients,
        "entreprises"        => $entreprises,
        "banks"              => $banks,
        "produits"           => $produits,
        "tvas"               => $tvas,
        "customize_check" => $customize_check,
      ];
    }
    else
    {
      $all = [
        "customize_check" => $customize_check,
        "msg" => "s'îl vous plaît générer la référence default pour continuer la commande"
      ];
    }
    return view('ligneFactures.create',$all);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $request->validate([
      "client"         => ["required"],
      "tva"            => ["required","numeric" , "exists:taux_tvas,valeur"],
    ]);
    $reference_devis = null;
    $reference       = null;
    $count_facture   = Facture::withTrashed()->count();
    // format référence commande
    $num_cmd        = CustomizeReference::where("champ","num_commande")->where("affecter","commande")->where("operation","vente")->first()->valeur;
    $separateur_cmd = CustomizeReference::where("champ","séparateur")->where("affecter","commande")->where("operation","vente")->first()->valeur;
    $nbrZero_cmd    = CustomizeReference::where("champ","nombre_zero")->where("affecter","commande")->where("operation","vente")->first()->valeur;
    $counter_cmd    = CustomizeReference::where("champ","counter")->where("affecter","commande")->where("operation","vente")->first()->valeur;
    $reference      = $num_cmd . $separateur_cmd . str_pad($count_facture + $counter_cmd, $nbrZero_cmd, "0", STR_PAD_LEFT);
    // format référence devis
    $num_devis        = CustomizeReference::where("champ","num_devis")->where("affecter","devis")->where("operation","vente")->first()->valeur;
    $separateur_devis = CustomizeReference::where("champ","séparateur")->where("affecter","devis")->where("operation","vente")->first()->valeur;
    $nbrZero_devis    = CustomizeReference::where("champ","nombre_zero")->where("affecter","devis")->where("operation","vente")->first()->valeur;
    $counter_devis    = CustomizeReference::where("champ","counter")->where("affecter","devis")->where("operation","vente")->first()->valeur;
    $reference_devis  = $num_devis . $separateur_devis . str_pad($count_facture + $counter_devis, $nbrZero_devis, "0", STR_PAD_LEFT);
    // format reference facture préforma
    $num_preforma        = CustomizeReference::where("champ","num_preforma")->where("affecter","preforma")->where("operation","vente")->first()->valeur;
    $separateur_preforma = CustomizeReference::where("champ","séparateur")->where("affecter","preforma")->where("operation","vente")->first()->valeur;
    $nbrZero_preforma    = CustomizeReference::where("champ","nombre_zero")->where("affecter","preforma")->where("operation","vente")->first()->valeur;
    $counter_preforma    = CustomizeReference::where("champ","counter")->where("affecter","preforma")->where("operation","vente")->first()->valeur;
    $reference_preforma  = $num_preforma . $separateur_preforma . str_pad($count_facture + $counter_preforma, $nbrZero_preforma, "0", STR_PAD_LEFT);

    $mois             = date("m-Y",strtotime($request->date_facture ?? Carbon::today() ));
    $tva              = DB::table("taux_tvas")->where("valeur",$request->tva)->first()->valeur;
    $facture = Facture::create([
      "client_id"           => $request->client,
      "num"                 => $reference,
      "statut"              => "validé",
      "date_facture"        => $request->date_facture != '' ? $request->date_facture : Carbon::today(),
      "dateCreation"        => Carbon::today(),
      "taux_tva"            => $tva,
      "entreprise_id"  => Entreprise::count() == 1 ? Entreprise::first()->id : $request->entreprise_id,
      "payer"               => 0,
      "mois"                => $mois,
      'nbrProduits'         => count($request->pro),
      "num_devis"           => $reference_devis,
      "num_preforma"        => $reference_preforma,
      "commentaire"         => $request->commentaire,
    ]);
    $sum_qte = 0;
    foreach($request->pro as $k =>  $value)
    {
      $stock      = Stock::where("produit_id",$value)->first();
      $remise_pro = $request->remise[$k] > 0 ? $request->remise[$k] : 0;
      $qte        = $request->qte[$k] ?? 0;
      $price      = $request->prix[$k] ?? 0;
      $montant    = $qte * $price;
      $ht         = $montant * ( 1 - ($remise_pro/100));
      if($qte <= $stock->disponible ){
        $facturePro = FactureProduit::create([
          "facture_id"  => $facture->id,
          "produit_id"  => $request->pro[$k],
          "quantite"    => $qte,
          "remise"      => $remise_pro,
          "montant"     => $ht,
          "prix"        => $price,
        ]);
        $sum_qte += $qte;
        $this->saveStock($facturePro->id);
      }
    }
    $remiseGroup = 0;
    $sum_ht     = FactureProduit::where("facture_id",$facture->id)->sum("montant");   // sum montants
    $ht_tva     = $sum_ht * (1 + ($tva / 100));                                       // ht tva
    $remise_ht  = $sum_ht * floatval($remiseGroup / 100);                             // remise ht
    $remise_ttc = floatval($remise_ht) * (1 + ($tva / 100));                          // remise ttc
    $ttc_net    = $ht_tva - $remise_ttc;                                              // net payer
    $facture->update([
      "ttc"         => $ttc_net,
      "net_payer"         => $ttc_net,
      "reste"         => $ttc_net,
      "ht"          => $sum_ht,
      "qteProduits" => $sum_qte,
      "ht_tva"      => $ht_tva,
      "remise_ht"   => $remise_ht,
      "remise_ttc"  => $ttc_net,
    ]);
    $this->saveRapport($facture->id);
    $this->updateClient($facture->id);
    toast("L'enregistrement du facture effectuée","success");
    return redirect()->route("facture.index");

  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Facture  $facture
   * @return \Illuminate\Http\Response
   */
  public function edit(Facture $facture,Request $request)
  {
    if($facture->statut == "validé")
    {
      toast("Le vente validé" , "success");
      return back();
    }
    elseif($facture->client->deleted_at != null)
    {
      toast("Le client de cente a été supprimer","warning");
      return back();
    }
    else
    {
      $pro_ids       = $facture->produits()->where("quantite",'>',0)->pluck("produit_id");
      $produits_news = Produit::select("id","reference","designation","prix_vente","quantite")->whereNotIn("id",$pro_ids)->where("quantite",">",0)->get();
      $produits      = $facture->produits()->get();
      $clients       = DB::table('clients')->select("id",'raison_sociale')->get();
      $tvas          = DB::table("taux_tvas")->pluck("valeur");

      $all = [
        'facture'  => $facture,
        'produits' => $produits,
        'clients'  => $clients,
        'tvas'  => $tvas,
        "produits_news"=>$produits_news,
      ];
      return view('ligneFactures.edit',$all);

    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Facture  $facture
   * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Facture $facture)
  {
    $request->validate([
      "client"         => ["required"],
      "group"          => ["required"],
      "statut"         => ["required"],
      "date_paiement"   => ["required"],
      "tva"            => ["required","numeric" , "exists:taux_tvas,valeur"],
    ]);
    $tva         = DB::table("taux_tvas")->where("valeur",$request->tva)->first()->valeur;
    $grp_id      = DB::table("clients")->where("id",$request->client)->first()->group_id;
    $remiseGroup = DB::table("groups")->where("id",$grp_id)->first()->remise;
    $sum_ht      = FactureProduit::where("facture_id",$facture->id)->sum("montant");
    $sum_ht      = FactureProduit::where("facture_id",$facture->id)->sum("montant");        // sum montants
    $ht_tva      = $sum_ht * (1 + ($tva / 100));                                            // ht tva
    $remise_ht   = $sum_ht * floatval($remiseGroup / 100);                                  // remise ht
    $remise_ttc  = floatval($remise_ht) * (1 + ($tva / 100));                               // remise ttc
    $ttc_net     = $ht_tva - $remise_ttc;                                                   // net payer
    $facture->update([
      "client_id"           => $request->client,
      "statut"              => $request->statut ?? "en cours",
      "remise"              => $remiseGroup,
      "taux_tva"            => $tva,
      "condition_paiements" => $request->condition,
      "date_facture"        => $request->date_facture,
      "date_paiement"        => $request->date_paiement,
      "ttc"                 => $ttc_net,
      "reste"               => $ttc_net,
      "ht"                  => $sum_ht,
      "ht_tva"              => $ht_tva,
      "remise_ht"           => $remise_ht,
      "remise_ttc"          => $ttc_net,
    ]);

    toast("La modification du facture effectuée","success");
    return redirect()->route('facture.index');
  }


  public function saveStock($factureProduit_id){
    $factureProduit = FactureProduit::find($factureProduit_id);
    $stock = Stock::where("produit_id",$factureProduit->produit_id)->first();
    $qte = $factureProduit->quantite;
          // // update stock
      $stock->update([
        "qte_vente"    => $stock->qte_vente + $qte,
        "disponible"   => $stock->disponible - $qte,
      ]);

    StockHistorique::create([
      "stock_id"       => $stock->id,
      "quantite"       => $factureProduit->quantite,
      "date_mouvement" => Carbon::now(),
      "fonction"       => "sortie",
    ]);
  }


  public function saveRapport($facture_id){
    $facture           = Facture::find($facture_id);
    $client            = Client::where("id",$facture->client_id)->withTrashed()->first();
    $rand_num          = Str::random(5);
    $ligneRapport      = null;
    $ligne_ex          = LigneRapport::where("mois",$facture->mois)->exists();
    $factureRapport_ex = Rapport::where("reference",$facture->num)->exists();
    if($ligne_ex == true)
    {
      $ligneRapport = LigneRapport::where("mois",$facture->mois)->first();
    }
    else
    {
      $ligne = LigneRapport::create([
        "num"           => Str::upper($rand_num),
        "montant_vente" => 0,
        "mois"          => $facture->mois,
        "payer_vente"   => 0,
        "reste_vente"   => 0,
      ]);
      $ligneRapport = $ligne;
    }

    if($factureRapport_ex == false)
    {

      Rapport::create([
        "ligne_rapport_id" => $ligneRapport->id,
        "raison_sociale"          => $client->raison_sociale,
        "montant"          => $facture->ttc,
        "jour"             => $facture->date_facture,
        "payer"            => $facture->payer,
        "reste"            => $facture->reste,
        "reference"        => $facture->num,
        "affecter"         => "vente",
        "status"=>$facture->status,
      ]);
    }
    else
    {
      $factureRapport = Rapport::where("reference",$facture->num)->first();
      $factureRapport->update([
        "status"=>"validé",
      ]);
    }

    $sum_ttc   = Rapport::where("ligne_rapport_id",$ligneRapport->id)->sum("montant");
    $sum_payer = Rapport::where("ligne_rapport_id",$ligneRapport->id)->sum("payer");
    $sum_reste = Rapport::where("ligne_rapport_id",$ligneRapport->id)->sum("reste");
    $ligneRapport ->update([
      "montant_vente" => $sum_ttc,
      "payer_vente"   => $sum_payer,
      "reste_vente"   => $sum_reste,
    ]);


  }


  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Facture  $facture
   * @return \Illuminate\Http\Response
  */
  public function show(Facture $facture)
  {
      $produits  = $facture->produits()->get();
      $paiements = $facture->paiements()->get();
      $check_suivi = Activity::where("log_name","facture")->exists();
      $facture_suivis = null;
      if($check_suivi == true){
        $facture_suivis = Activity::where("log_name","facture_paiement")->get();
        foreach($facture_suivis as $facture_suivi){
          $facture_suivi->user = User::find($facture_suivi->causer_id)->first()->name;
        }
      }
      else
      {
        $facture_suivis = null;
      }
      $all = [
        "produits"  => $produits,
        "paiements" => $paiements,
        "facture"   => $facture,
        "facture_suivis"   => $facture_suivis,
      ];
      return view("ligneFactures.show",$all);
  }

  /**
   * Valider the specified resource.
   *
   * @param  \App\Models\Facture  $facture
   * @return \Illuminate\Http\Response
  */


  // public function valider(Facture $facture , Request $request)
  // {
  //   // format reference facture
  //   $facture->update([
  //     "statut"      => "validé",
  //     "net_payer"   => $facture->ttc,
  //     "reste"       => $facture->ttc,
  //   ]);

  //   foreach($request->commande as $k => $val)
  //   {
  //     $qte     = $request->quantite[$k];

  //     $factureProduit   = FactureProduit::find($val);
  //     $stock   = Stock::where("produit_id",$factureProduit->produit_id)->first();
  //     // update depot

  //     $depot = null;
  //     if(isset($request->depot_select))
  //     {
  //       $depot = Depot::find($request->depot_select[$k]);
  //     }
  //     elseif(isset($request->depot_default))
  //     {
  //       $depot = Depot::where("num_depot",$request->depot_default[$k])->first();
  //     }
  //     // update depot
  //     $depot->update([
  //       "quantite"   => $depot->quantite + $qte,
  //       'disponible' => $depot->disponible + $qte,
  //       'sortie'     => $depot->sortie + $qte,
  //     ]);

  //     // // update depot stock
  //     $stock_depot = StockDepot::where("stock_id",$stock->id)->where("depot_id",$depot->id)->first();
  //     $stock_depot->update([
  //       "quantite"   => $stock_depot->quantite + $qte,
  //       "sortie"      => $stock_depot->sortie + $qte,
  //       "disponible" => $stock_depot->disponible - $qte,
  //     ]);

  //     // // insertion depot suivi
  //     DepotSuivi::create([
  //       "stock_depot_id"=>$stock_depot->id,
  //       "date_suivi"=>Carbon::today(),
  //       "quantite"=>$qte,
  //       "operation"=>"vente",
  //     ]);


  //     // // update stock
  //     $stock->update([
  //       "qte_vente"    => $stock->qte_vente + $qte,
  //       "qte_venteRes" => $stock->qte_venteRes - $qte,
  //       "disponible"   => $stock->disponible - $qte,
  //     ]);

  //     // // insertion stock history
  //     StockHistorique::create([
  //       "stock_id"       => $stock->id,
  //       "quantite"       => $qte,
  //       "date_mouvement" => Carbon::today(),
  //       "fonction"       => "vente_validé",
  //     ]);

  //   }


  //   $this->saveRapport($facture->id);
  //   $this->updateClient($facture->id);
  //   Session()->flash("valider","");
  //   toast("La validation de devis effectuée","success");
  //   return redirect()->route('facture.index');
  // }

  public function updateClient($id)
  {
    $facture    = Facture::find($id);
    $mt_facture = Facture::where("client_id",$facture->client_id)->where("statut","validé")->sum("net_payer");
    $sum_payer  = Facture::where("client_id",$facture->client_id)->sum("payer");
    $client     = Client::where("id",$facture->client_id)->withTrashed()->first();
    $client->update([
      "montant"       => $mt_facture,
      "reste"         => $mt_facture,
      "payer"         => $sum_payer
    ]);

    $ligneRapport= null;

    $ligneRapport_ex = LigneRapport::where("mois",$client->moisCreation)->exists();
    $rapportCrm_ex   = RapportCrm::where("identifiant",$client->identifiant)->exists();
    if($ligneRapport_ex == true){
      $ligne = LigneRapport::where("mois",$client->moisCreation)->first();
      $ligneRapport = $ligne;
    }
    else
    {

      $ligneRapport = LigneRapport::create([
        "num"=>Str::upper(Str::random(8)),
        "mois"=>$client->moisCreation,
      ]);
    }


    if($rapportCrm_ex == true){
      $rapport_crm =RapportCrm::where("identifiant",$client->identifiant)->first();
      $rapport_crm->update([
        "montant"          => $client->montant,
        "payer"            => $client->payer,
        "reste"            => $client->reste,
      ]);

    }
    else
    {

      RapportCrm::create([
        "ligne_rapport_id" => $ligneRapport->id,
        "identifiant"      => $client->identifiant,
        "name"      => $client->raison_sociale,
        "jour"             => $client->dateCreation,
        "affecter"         => "client",
        "montant"          => $client->montant,
        "payer"            => $client->payer,
        "reste"            => $client->reste,
      ]);
    }



  }

  public static function asLetters($number) {
      $convert = explode('.', $number);
      $num[17] = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit',
      'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize');

      $num[100] = array(20 => 'vingt', 30 => 'trente', 40 => 'quarante', 50 => 'cinquante',
      60 => 'soixante', 70 => 'soixante-dix', 80 => 'quatre-vingt', 90 => 'quatre-vingt-dix');

      if (isset($convert[1]) && $convert[1] != '') {
      return self::asLetters($convert[0]).' et '.self::asLetters($convert[1]);
      }
      if ($number < 0) return 'moins '.self::asLetters(-$number);
      if ($number < 17) {
      return $num[17][$number];
      }
      elseif ($number < 20) {
      return 'dix-'.self::asLetters($number-10);
      }
      elseif ($number < 100) {
      if ($number%10 == 0) {
      return $num[100][$number];
      }
      elseif (substr($number, -1) == 1) {
      if( ((int)($number/10)*10)<70 ){
      return self::asLetters((int)($number/10)*10).'-et-un';
      }
      elseif ($number == 71) {
      return 'soixante-et-onze';
      }
      elseif ($number == 81) {
      return 'quatre-vingt-un';
      }
      elseif ($number == 91) {
      return 'quatre-vingt-onze';
      }
      }
      elseif ($number < 70) {
      return self::asLetters($number-$number%10).'-'.self::asLetters($number%10);
      }
      elseif ($number < 80) {
      return self::asLetters(60).'-'.self::asLetters($number%20);
      }
      else {
      return self::asLetters(80).'-'.self::asLetters($number%20);
      }
      }
      elseif ($number == 100) {
      return 'cent';
      }
      elseif ($number < 200) {
      return self::asLetters(100).' '.self::asLetters($number%100);
      }
      elseif ($number < 1000) {
      return self::asLetters((int)($number/100)).' '.self::asLetters(100).($number%100 > 0 ? ' '.self::asLetters($number%100): '');
      }
      elseif ($number == 1000){
      return 'mille';
      }
      elseif ($number < 2000) {
      return self::asLetters(1000).' '.self::asLetters($number%1000).' ';
      }
      elseif ($number < 1000000) {
      return self::asLetters((int)($number/1000)).' '.self::asLetters(1000).($number%1000 > 0 ? ' '.self::asLetters($number%1000): '');
      }
      elseif ($number == 1000000) {
      return 'millions';
      }
      elseif ($number < 2000000) {
      return self::asLetters(1000000).' '.self::asLetters($number%1000000);
      }
      elseif ($number < 1000000000) {
      return self::asLetters((int)($number/1000000)).' '.self::asLetters(1000000).($number%1000000 > 0 ? ' '.self::asLetters($number%1000000): '');
      }
  }

  public function showPdf(Facture $facture){

    $entreprise     = $facture->entreprise;
    $client = $facture->client;
    $letter_chiffre = $this->asLetters(($facture->ttc));
    $all = [
      "facture"        => $facture,
      "client"        => $client,
      "entreprise"      => $entreprise ?? null,
      "letter_chiffre" => $letter_chiffre
    ];
    $pdf = Pdf::loadview('ligneFactures.document',$all);
    return $pdf->stream("facture:".$facture->num_facture);
  }


  public function facturePreforma(Facture $facture){

    $entreprise      = $facture->entreprise;
    $client      = $facture->client;
    $numero_preforma = "préforma : ". $facture->num_preforma;
    $file_preforma   = "préforma : ". $facture->nnum_preformaum;
    $letter_chiffre  = $this->asLetters(($facture->ttc));
    $all = [
      "facture"         => $facture,
      "client"         => $client,
      "entreprise"       => $entreprise,
      "letter_chiffre"  => $letter_chiffre,
      "numero_preforma" => $numero_preforma,
    ];
    $pdf = Pdf::loadview('ligneFactures.facturePreforma',$all);
    return $pdf->stream($file_preforma);
    // return $pdf->download('facture.pdf');
  }

  public function devis(Facture $facture){

    $entreprise     = $facture->entreprise;
    $client     = $facture->client;

    $title_file = "facture : " . $facture->num_devis;
    $all = [
      "facture"      => $facture,
      "client"      => $client,
      "entreprise"   => $entreprise ?? null,
      "numero_devis" => $facture->num_devis,
    ];
    $pdf = Pdf::loadview('ligneFactures.devis',$all);
    return $pdf->stream($title_file);
    // return $pdf->download('facture.pdf');
  }










}
