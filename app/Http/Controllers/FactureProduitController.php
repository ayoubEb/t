<?php

namespace App\Http\Controllers;
use App\Models\FactureProduit;
use App\Models\Facture;
use App\Models\LigneRapport;
use App\Models\Produit;
use App\Models\Rapport;
use App\Models\Stock;
use App\Models\StockHistorique;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FactureProduitController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

    }

  public function add($id)
  {
    $facture = Facture::find($id);
    if($facture->statut != "validé" && $facture->etat_retour == 0)
    {
      $pro_ids  = $facture->produits()->pluck("produit_id");
      $produits_news = Produit::select("id","reference","designation","prix_vente")
      ->whereNotIn("id",$pro_ids)
      ->where("etat_stock","<>","rupture")
      ->get();
      foreach($produits_news as $produit){
        $produit->disponible   = DB::table("stocks")->where("produit_id",$produit->id)->first()->disponible;
        $produit->reste        = DB::table("stocks")->where("produit_id",$produit->id)->first()->reste;
        $produit->qte_venteRes = DB::table("stocks")->where("produit_id",$produit->id)->first()->qte_venteRes;
      }

      $all = [
        "facture" => $facture ,
        "produits_news" => $produits_news ,
      ];
      return view("factures.add",$all);
    }
    else
    {
      return back();
    }
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

  public function store(Request $request)
  {
    $facture = Facture::find($request->facture_id);
    if(isset($request->pro))
    {
      foreach($request->pro as $row => $val){
        $stock = Stock::where("produit_id",$val)->first();
        $price = $request->prix[$row];
        $qte = $request->quantite[$row] ?? 0;
        if($qte <= ($stock->disponible - $stock->qte_venteRes))
        {

          $montant = $qte * $price;
          StockHistorique::create([
            "stock_id"       => $stock->id,
            "quantite"       => $request->quantite[$row],
            "date_mouvement" => Carbon::today(),
            "fonction"       => "vente_réserver",
          ]);
          FactureProduit::create([
            "facture_id" => $request->facture_id,
            "produit_id" => $val,
            "quantite"   => $qte,
            "remise"     => $request->remise[$row],
            "montant"    => $montant,
            "prix"       => $price,
          ]);
        }
      }
      $tva               = $facture->taux_tva;
      $remiseGroup       = $facture->remise;
      $sum_ht         = FactureProduit::where("facture_id",$facture->id)->sum("montant");
      $sum_qte         = FactureProduit::where("facture_id",$facture->id)->sum("quantite");
      $ht_tva     = $sum_ht * (1 + ($tva / 100));               // ht tva
      $remise_ht  = $sum_ht * floatval($remiseGroup / 100);     // remise ht
      $remise_ttc = floatval($remise_ht) * (1 + ($tva / 100));  // remise ttc
      $ttc_net    = $ht_tva - $remise_ttc;                      // net payer
      $facture->update([
        "nbrProduits"    => count($request->pro) + $facture->nbrProduits,
        "ttc"         => $ttc_net,
        "reste"       => $ttc_net,
        "ht"          => $sum_ht,
        "qteProduits" => $sum_qte,
        "ht_tva"      => $ht_tva,
        "remise_ht"   => $remise_ht,
        "remise_ttc"  => $ttc_net,
      ]);
      $stock->update([
        "qte_venteRes"=>$stock->qte_venteRes + $qte,
      ]);
      $this->updateRapport($facture->id);
    }
    toast("L'enregistrement des produits effectuée","success");
    return redirect()->route('facture.edit',["facture"=>$facture]);

  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\FactureProduit  $factureProduit
   * @return \Illuminate\Http\Response
   */
  public function show(FactureProduit $factureProduit)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\FactureProduit  $factureProduit
   * @return \Illuminate\Http\Response
   */
  public function edit(FactureProduit $factureProduit)
  {
    $all = [ "factureProduit" => $factureProduit ];
    return view("factures.edit",$all);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\FactureProduit  $factureProduit
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, FactureProduit $factureProduit)
  {


    $facture        = Facture::find($factureProduit->facture_id);
    $produit        = Produit::find($factureProduit->produit_id);
    $pv             = DB::table("produits")->where("id",$factureProduit->produit_id)->first()->prix_vente;
    $tva            = $facture->taux_tva;
    $remiseGroup    = $facture->remise;
    $qte            = $request->quantite ?? 0;
    $remise         = $request->remise ?? 0;
    $montant = ($qte *  $pv) * ( 1 - ($remise/100));
    $qte_vente = $produit->qte_venteRes - $factureProduit->quantite;
    $factureProduit->update([
        "quantite" => $qte,
        "remise"   => $remise,
        "montant"  => $montant,
    ]);

    $sum_ht      = FactureProduit::where("facture_id",$facture->id)->sum("montant");
    $sum_qte     = FactureProduit::where("facture_id",$facture->id)->sum("quantite");
    $sum_nbrs    = FactureProduit::where("facture_id",$facture->id)->count();
    $tva         = $facture->taux_tva;
    $remiseGroup = $facture->remise;
    $ht_tva      = $sum_ht * (1 + ($tva / 100));                                       // ht tva
    $remise_ht   = $sum_ht * floatval($remiseGroup / 100);                             // remise ht
    $remise_ttc  = floatval($remise_ht) * (1 + ($tva / 100));                          // remise ttc
    $ttc_net     = $ht_tva - $remise_ttc;

      $facture->update([
        "ttc"         => $ttc_net,
        "reste"       => $ttc_net,
        "ht"          => $sum_ht,
        "qteProduits" => $sum_qte,
        "nbrProduits" => $sum_nbrs,
        "ht_tva"      => $ht_tva,
        "remise_ht"   => $remise_ht,
        "remise_ttc"  => $ttc_net,
      ]);
      $produit->update([
        "qte_venteRes"=>$qte_vente + $qte,
      ]);
      $this->updateRapport($facture->id);

      toast("La motification du produit effectuée","success");
      return back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\FactureProduit  $factureProduit
   * @return \Illuminate\Http\Response
   */
  public function destroy(FactureProduit $factureProduit)
  {
    $facture  = Facture::find($factureProduit->facture_id);
    $sum_ht   = FactureProduit::where("facture_id",$facture->id)->sum("montant")- $factureProduit->montant;
    $sum_qte  = FactureProduit::where("facture_id",$facture->id)->sum("quantite");
    $sum_nbrs = FactureProduit::where("facture_id",$facture->id)->count();
    $tva         = $facture->taux_tva;
    $remiseGroup = $facture->remise;
    $ht_tva      = $sum_ht * (1 + ($tva / 100));                                       // ht tva
    $remise_ht   = $sum_ht * floatval($remiseGroup / 100);                             // remise ht
    $remise_ttc  = floatval($remise_ht) * (1 + ($tva / 100));                          // remise ttc
    $ttc_net     = $ht_tva - $remise_ttc;

    $facture->update([
      "ttc"         => $ttc_net,
      "reste"       => $ttc_net,
      "ht"          => $sum_ht,
      "qteProduits" => $sum_qte,
      "nbrProduits" => $sum_nbrs,
      "ht_tva"      => $ht_tva,
      "remise_ht"   => $remise_ht,
      "remise_ttc"  => $ttc_net,
    ]);

    $produit = Produit::find($factureProduit->produit_id);
    $produit->update([
      "qte_venteRes"=>$produit->qte_venteRes - $factureProduit->quantite,
    ]);
    $this->updateRapport($facture->id);

    $factureProduit->delete();

    toast("La suppression du produit effectuée","success");
    return back();

  }


    public function updateRapport($id)
    {
      $facture = DB::table("factures")->where("id",$id)->first();
      $rapport = Rapport::where("reference",$facture->num)->first();
      $rapport->update([
        "montant" => $facture->ttc,
        "reste"   => $facture->reste,
      ]);
      $ligneRapport = LigneRapport::where("mois",$facture->mois)->first();
      $sum_montant  = Rapport::where("ligne_rapport_id",$ligneRapport->id)->where("affecter","vente")->sum("montant");
      $sum_payer    = Rapport::where("ligne_rapport_id",$ligneRapport->id)->where("affecter","vente")->sum("payer");
      $ligneRapport->update([
        "montant_vente" => $sum_montant,
        "payer_vente"   => $sum_payer,
        "reste_vente"   => $sum_montant - $sum_payer,
      ]);
    }
}
