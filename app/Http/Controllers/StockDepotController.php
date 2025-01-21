<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use App\Models\DepotSuivi;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\StockDepot;
use App\Models\StockHistorique;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class StockDepotController extends Controller
{
  function __construct()
  {
    // $this->middleware('permission:stockDepot-list|stockDepot-nouveau|stockDepot-modification', ['only' => ['index']]);
    $this->middleware('permission:stockDepot-list', ['only' => 'index']);

    $this->middleware('permission:stockDepot-nouveau', ['only' => ['new','store']]);

    $this->middleware('permission:stockDepot-modification', ['only' => ['annuler']]);

    $this->middleware('permission:stockDepot-display', ['only' => 'show']);
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $stock_depots = StockDepot::select("id","stock_id","depot_id","quantite","entre","sortie","disponible","check_default" , "statut")->get();
      $all          = [ "stock_depots" => $stock_depots ];
      return view("stockDepots.index",$all);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function depots($id)
    {
      $depot_ids = StockDepot::where("stock_id",$id)->pluck("depot_id");
      $depots    = Depot::whereNotIn("id",$depot_ids)->get();
      $stock     = Stock::find($id);
      $liste_depots = $stock->depots()->get();
      $all = [
        "stock"        => $stock,
        "depots"       => $depots,
        "liste_depots" => $liste_depots
      ];
      return view("stockDepots.add",$all);
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
          "depot"=>["required","exists:depots,id"]
        ]);
        $qte = $request->quantite == '' ? 0 : $request->quantite;
        $stock_depot = StockDepot::create([
          "depot_id"   => $request->depot,
          "stock_id"   => $request->stock_id,
          "quantite"   => $qte,
          "entre"      => $qte,
          "disponible" => $qte,
          "statut" => "active",
        ]);
        $stock = Stock::find($request->stock_id);
        $stock->update([
          "qte_augmenter" => $stock->qte_augmenter + $qte,
          "disponible"    => $stock->disponible + $qte,
          "check_depot"=>1,
        ]);
        if($qte > 0){
          $depot = Depot::find($request->depot);
          $depot->update([
            "quantite"   => $depot->quantite + $qte,
            "disponible" => $depot->disponible + $qte,
            "entre"      => $depot->entre + $qte,
          ]);
          StockHistorique::create([
            "stock_id"       => $stock->id,
            "fonction"       => "initial",
            "date_mouvement" => Carbon::today(),
            "quantite"       => $qte,
            "description"       => "initial de depôt : " . $depot->num_depot,
          ]);
          $produit = Produit::find($stock->produit_id);
          $produit->update([
            "quantite"=>$produit->quantite + $qte,
          ]);

          DepotSuivi::create([
            "stock_depot_id" => $stock_depot->id,
            "operation"      => "initial",
            "date_suivi"     => Carbon::today(),
            "quantite"       => $qte,
          ]);

        }

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StockDepot  $stockDepot
     * @return \Illuminate\Http\Response
     */
    public function show(StockDepot $stockDepot)
    {
      $stock = $stockDepot->stock;
      $depot = $stockDepot->depot;
      $suivi_actions = Activity::where("log_name","stock_depot")->get();
      foreach($suivi_actions as $suivi_action){
        $check_user = User::where('id',$suivi_action->causer_id)->exists();
        if($check_user == true)
        {
          $suivi_action->user = User::find($suivi_action->causer_id)->first()->name;
        }
        else
        {
          $suivi_action->user = null;
        }
      }

      $all = [
        "stock"         => $stock,
        "depot"         => $depot,
        "stockDepot"    => $stockDepot,
        "suivi_actions" => $suivi_actions,
      ];
      return view("stockDepots.show",$all);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StockDepot  $stockDepot
     * @return \Illuminate\Http\Response
     */
    public function inactive($id)
    {
      $stockDepot = StockDepot::find($id);
      $stock = Stock::find($stockDepot->stock_id);
      $depot = Depot::find($stockDepot->depot_id);
        $stockDepot->update([
          "statut"=>"inactive",
        ]);
        $stock->update([
          "disponible" => intval($stock->disponible - $stockDepot->disponible),
        ]);
        $depot->update([
          "disponible" => intval($depot->disponible - $stockDepot->disponible),
        ]);
        StockHistorique::create([
          "stock_id"       => $stock->id,
          "fonction"       => "réduite",
          "date_mouvement" => Carbon::today(),
          "quantite"       => $stockDepot->disponible,
          "description"       => "réduite ( Le quantité a été réduite ) de depôt : " . $depot->num_depot,
        ]);

        DepotSuivi::create([
          "stock_depot_id" => $stockDepot->id,
          "operation"      => "réduite",
          "date_suivi"     => Carbon::today(),
          "quantite"       => $stockDepot->disponible,
        ]);

        toast("La modification de stock depôt effectuée","success");
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StockDepot  $stockDepot
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {
      $stockDepot = StockDepot::find($id);
        $stockDepot->update([
          "statut"=>"inactive",
        ]);
        $stock = Stock::find($stockDepot->stock_id);
        $depot = Depot::find($stockDepot->depot_id);
        $stock->update([
          "disponible"=>$stock->disponible + $stockDepot->quantite,
        ]);
        $depot->update([
          "disponible"=>$depot->disponible + $stockDepot->quantite,
        ]);
        StockHistorique::create([
          "stock_id"       => $stock->id,
          "fonction"       => "active",
          "date_mouvement" => Carbon::today(),
          "quantite"       => $stockDepot->quantite,
          "description"       => "active ( Le quantité a été active ) de depôt : " . $depot->num_depot,
        ]);

        DepotSuivi::create([
          "stock_depot_id" => $stockDepot->id,
          "operation"      => "active",
          "date_suivi"     => Carbon::today(),
          "quantite"       => $stockDepot->quantite,
        ]);

        toast("La modification de stock depôt effectuée","success");
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockDepot  $stockDepot
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockDepot $stockDepot)
    {
        //
    }
}
