<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use App\Models\DepotSuivi;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\StockDepot;
use App\Models\StockHistorique;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class StockHistoriqueController extends Controller
{

  function __construct()
  {
    $this->middleware('permission:stockHistory-nouveau', ['only' => ['resign','augmenter']]);
  }

    public function augmenter(Request $request , $id)
    {
      $request->validate([
        "qte_add" => ['required','numeric','min:1'],
      ]);
      $qte_add = $request->qte_add;
      $stock     = Stock::find($id);
      $produit = Produit::find($stock->produit_id);



      StockHistorique::create([
        "stock_id"       => $stock->id,
        "fonction"       => "augmentation",
        "quantite"       => $qte_add ,
        "date_mouvement" => Carbon::today(),
      ]);
      $qte_new = $produit->quantite + $qte_add ;
      $produit->quantite = $qte_new;
      $produit->save();
      $stock->qte_augmenter =$stock->qte_augmenter + $qte_add ;
      $stock->disponible = $stock->disponible + $qte_add ;
      $stock->save();
      toast("L'augmentation du stock effectuée","success");
      return back();
    }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function resign($id,Request $request)
  {
    $request->validate([
      "qte_demi"=>["required","numeric","min:1"]
    ]);
    $qte_demi = $request->qte_demi;
    $stock   = Stock::find($id);
    $produit = Produit::find($stock->produit_id);
    $produit->update([
      "quantite" => $produit->quantite - intval(request("qte_demi")),
    ]);
    $stock->update([
      "disponible"=>$stock->disponible - $qte_demi,
    ]);


    StockHistorique::create([
      "stock_id"       => $stock->id,
      "fonction"       => "démissionner",
      "quantite"       => request("qte_demi"),
      "date_mouvement" => Carbon::today(),
    ]);
    toast("Le démssionner du stock a été effectuée","success");
    return back();
  }

}
