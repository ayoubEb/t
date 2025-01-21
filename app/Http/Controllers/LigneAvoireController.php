<?php

namespace App\Http\Controllers;

use App\Models\LigneAvoire;
use App\Http\Controllers\Controller;
use App\Models\Avoire;
use App\Models\CustomizeReference;
use App\Models\Entreprise;
use App\Models\Facture;
use App\Models\FactureProduit;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\StockHistorique;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LigneAvoireController extends Controller
{

  function __construct()
  {
    $this->middleware('permission:ligneAvoire-list|ligneAvoire-nouveau|ligneAvoire-modification|ligneAvoire-display', ['only' => ['index','show']]);

    $this->middleware('permission:ligneAvoire-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:ligneAvoire-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:ligneAvoire-suppression', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $ligne_retours = LigneAvoire::all();
    return view("avoires.index",[
      "ligne_retours"=>$ligne_retours,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    if(isset($request->factureProduit))
    {
      $facture      = Facture::find($request->facture);
      $tva          = $facture->taux_tva;
      $sum_qte      = 0;
      $count_avoire = LigneAvoire::count() + 1;

      $num          = CustomizeReference::where("check_exists",1)->where("champ","num_avoire")->where("affecter","avoire")->where("operation","vente")->first()->valeur;
      $separeteur   = CustomizeReference::where("check_exists",1)->where("champ","separateur")->where("affecter","avoire")->where("operation","vente")->first()->valeur;
      $counter      = CustomizeReference::where("check_exists",1)->where("champ","counter")->where("affecter","avoire")->where("operation","vente")->first()->valeur;
      $nombre_zero  = CustomizeReference::where("check_exists",1)->where("champ","nombre_zero")->where("affecter","avoire")->where("operation","vente")->first()->valeur;
      $num_facture  = null;
      $count_avoire = LigneAvoire::withTrashed()->count();
      $coun_new     = $count_avoire + intval($counter);
      $num_facture  = $num . $separeteur . str_pad($coun_new, intval($nombre_zero), "0", STR_PAD_LEFT);

      $ligneAvoire = LigneAvoire::create([
        "reference"   => "AVOIRE-0" . $count_avoire,
        "facture_id"  => $request->facture,
        "num_avoire"  => $num_facture,
        "date_retour" => Carbon::today(),
        "statut"      => "en cours",
      ]);
      foreach($request->factureProduit as $k => $val)
      {
        $qte_retour  = $request->retour[$k];
        $facture_pro = FactureProduit::find($val);
        if($qte_retour > 0 && $facture_pro->quantite >= $qte_retour)
        {
          $pv      = $facture_pro->prix;
          $qte_new = $facture_pro->quantite - $qte_retour;
          $montant = $qte_new * $pv;
          Avoire::create([
            "ligne_avoire_id"    => $ligneAvoire->id,
            "facture_produit_id" => $val,
            "qte_retour"         => $qte_retour,
            "montant"            => $montant,
            "qte_prev"           => $facture_pro->quantite,
          ]);
          $facture_pro->update([
              "qte_retour"  => $qte_retour,
              "etat_retour" => 1,
              "reste"       => $facture_pro->quantite - $qte_retour,
          ]);
          $st          = Stock::where("produit_id",$facture_pro->produit_id)->first();
          StockHistorique::where("stock_id",$st->id)->create([
            "stock_id"       => $st->id,
            "fonction"       => "avoire",
            "quantite"       => $qte_retour,
            "date_mouvement" => Carbon::today(),
          ]);
          $stock = Stock::where("produit_id",$facture_pro->produit_id)->first();
          $stock->update([
            "qte_retour"=>$stock->qte_retour + $qte_retour
          ]);

        }

        $sum_qte += $qte_retour;
      }
      $remiseGroup    = $facture->remise;
      $sum_ht         = Avoire::where("ligne_avoire_id",$ligneAvoire->id)->sum("montant");
      $sum_qte_retour = Avoire::where("ligne_avoire_id",$ligneAvoire->id)->sum("qte_retour");
      $ht_tva         = $sum_ht * (1 + ($tva / 100));                                          // ht tva
      $remise_ht      = $sum_ht * floatval($remiseGroup / 100);                                // remise ht
      $remise_ttc     = floatval($remise_ht) * (1 + ($tva / 100));                             // remise ttc
      $net_avoire    = $ht_tva - $remise_ttc;                      // net payer
      // $ttc_avoire     = ($sum_retour + ($sum_retour * ($tva / 100))) * (1 - ($remise/100));
      $ligneAvoire->update([
        "qte" => $sum_qte_retour,
        "ht"  => $sum_ht,
        "ttc"  => $net_avoire,
      ]);
      $facture->update([
        "qteRetours"=>$sum_qte_retour,
      ]);
      $net_payer = $facture->net_payer - $net_avoire;
      $facture->update([
        "etat_retour" => 1,
        "net_avoire"  => $net_avoire,
        "net_payer"   => $net_payer,
        "qteRetours"=>$sum_qte
      ]);

      toast("L'enregistrement des produits retours effectuée","success");
      return redirect()->route('ligneAvoire.edit',["ligneAvoire"=>$ligneAvoire]);

    }
    else
    {
      toast("warning","Aucun produit selectionner");
      return back();
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\LigneAvoire  $ligneAvoire
   * @return \Illuminate\Http\Response
   */
  public function show(LigneAvoire $ligneAvoire)
  {
    $ligne   = $ligneAvoire;
    $facture = Facture::find($ligneAvoire->facture_id);
    $all     = [
      "facture" => $facture,
      "ligne"   => $ligne
    ];
    return view("avoires.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\LigneAvoire  $ligneAvoire
   * @return \Illuminate\Http\Response
   */
  public function edit(LigneAvoire $ligneAvoire)
  {
    $facture = Facture::find($ligneAvoire->facture_id);
    if($facture->qteProduits != $facture->qteRetours)
    {
      $factureProduits = FactureProduit::where("facture_id",$facture->id)->get();
      $all = [
        "ligneAvoire" => $ligneAvoire,
        "factureProduits"    => $factureProduits,
      ];
      return view("avoires.edit",$all);
    }
    else
    {
      toast("Le quantite égual quantité retour" , "success");
      return back();
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\LigneAvoire  $ligneAvoire
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, LigneAvoire $ligneAvoire)
  {
    $ht = 0;
    $facture = Facture::find($ligneAvoire->facture_id);
    foreach($request->facProRetour as $row => $value)
    {
      $qte_retour     = $request->retour[$row] ?? 0;
      $factureProduit = FactureProduit::find($value);

      $avoire = Avoire::where("facture_produit_id",$value)->first();
      if($qte_retour > 0 && $factureProduit->etat_retour == 1)
      {
        $mt     = $factureProduit->prix * $qte_retour;
        $factureProduit->update([
          "qte_retour"=>$qte_retour,
          "reste"      => $avoire->qte_prev - $qte_retour,
        ]);
        $stock = Stock::where("produit_id",$factureProduit->produit_id)->first();
        $qte_retouPro = $stock->qte_retour - $avoire->qte_retour;
        $avoire->update([
          "qte_retour" => $qte_retour,
          "montant"    => $mt,
        ]);
        $factureProduit->qte_retour = $qte_retour;
        $stock->update([
          "qte_retour"=>$qte_retouPro + $avoire->qte_retour,
        ]);

      }

      elseif($qte_retour > 0 && $factureProduit->etat_retour == 0)
      {
        $pv      = $factureProduit->prix;
        $qte_new = $factureProduit->quantite - $qte_retour;
        $montant = $qte_new * $pv;
        $av = Avoire::create([
          "ligne_avoire_id"    => $ligneAvoire->id,
          "facture_produit_id" => $value,
          "qte_retour"         => $qte_retour,
          "montant"            => $montant,
        ]);
        FactureProduit::where("produit_id",$factureProduit->produit_id)->update([
          "qte_retour"  => $qte_retour,
          "etat_retour" => 1,
          "reste"=>$factureProduit->quantite - $qte_retour,
        ]);
        $st          = Stock::where("produit_id",$factureProduit->produit_id)->first();
        StockHistorique::where("stock_id",$st->id)->create([
          "stock_id"       => $st->id,
          "fonction"       => "retour",
          "quantite"       => $qte_retour,
          "date_mouvement" => Carbon::today(),
        ]);
        $pro          = Produit::find($factureProduit->produit_id);
        $pro->update([
          "qte_retour"=>$pro->qte_retour + $av->qte_retour,
        ]);

      }



    }


    $ht = Avoire::where("ligne_avoire_id",$ligneAvoire->id)->sum("montant");
    $credit     = ($ht + ($ht * ($facture->taux_tva / 100))) * (1 - ($facture->remise));
    $ligneAvoire->update([
      "ht"=>$ht,
      "ttc"=>$credit,
    ]);
    $facture->update([
      "net_avoire" => $credit,
      "net_payer"  => $facture->ttc - $credit,
    ]);
    toast("success","La modification d'avoire effectuée");
    return back();
  }

  public function document(LigneAvoire $ligneAvoire){

    $facture    = DB::table("factures")->where("id",$ligneAvoire->facture_id)->first();
    $entreprise = Entreprise::find($facture->entreprise_id);
    $client     = DB::table("clients")->where("id",$ligneAvoire->facture->client_id)->first();
    $avoires    = $ligneAvoire->avoires()->get();
      foreach($avoires as $avoire)
      {
        $facture_produit = DB::table("facture_produits")->where("id",$avoire->facture_produit_id)->first();
        $avoire->produit = DB::table("produits")->where("id",$facture_produit->produit_id)->first();
      }
    $all = [
      "ligneAvoire" => $ligneAvoire,
      "avoires"     => $avoires,
      "entreprise"   => $entreprise,
      "client"      => $client,
      "facture"      => $facture,
    ];
    $pdf = Pdf::loadview('avoires.pdf',$all);
    return $pdf->stream();
  }
}
