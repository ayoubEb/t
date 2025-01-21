<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use App\Models\DepotSuivi;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\StockDepot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class StockController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:stock-list|stock-nouveau|stock-modification', ['only' => ['index']]);

    $this->middleware('permission:stock-nouveau', ['only' => ['new','store']]);

    $this->middleware('permission:stock-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:stock-display', ['only' => ['show']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $produits           = Produit::select("id","reference","designation","quantite","check_stock")->paginate(10);
    foreach($produits as $produit){
      if(isset($produit->stock)){
        $stock = Stock::where("produit_id",$produit->id)->first();
        $produit->disponible = Stock::where("produit_id",$produit->id)->first()->disponible;
        $suivi_actions = $stock->activities()->get();
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
      }
      else{
        $produit->disponible = 0;
      }
    }
    $produits_reference = Produit::select("reference")->get();
    $all = [
      "produits"   => $produits,
      "references" => $produits_reference,
    ];

    return view("stocks.index",$all);
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function new($id)
  {
    $produit = Produit::find($id);
    if($produit->check_stock == 0)
    {
      $all = [
        "produit" => $produit,
      ];
      return view("stocks.new" , $all);
    }
    else
    {
      toast("Le produit a été déja exists le stock","warning");
      return back();
    }
  }

  /**<
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      "reference"  => ['required','exists:produits,reference'],
      // "quantite" => ['nullable','numeric','min:1'],
      "qte_min"  => ['required','numeric','min:1'],
      // "initial"  => ['nullable','numeric','min:1'],
    ]);


    $count_stock     = Stock::count();
    $produit         = Produit::where("reference",$request->reference)->first();
    $stock = Stock::create([
      "num"        => "STOCK-00" . $count_stock + 1,
      "produit_id" => $produit->id,
      "initial"    => $request->initial ?? 0,
      "qte_alert"    => 0,
      "date_stock" => Carbon::now(),
      "min"        => $request->qte_min,
      "max"        =>  0,
      "qte_augmenter"=>$request->quantite,
      "disponible"=>$request->quantite,
    ]);
    $produit->update([
      "quantite"=>$request->quantite,
      "check_stock" => 1,
    ]);





      $stock->history()->create([
        "stock_id"       => $stock->id,
        "fonction"       => "initial",
        "quantite"       => $request->quantite,
        "date_mouvement" => Carbon::today(),
      ]);




    toast("L'enregistrement de stock effectuée",'success');
    return redirect()->route('stock.index');
    }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Stock  $stock
   * @return \Illuminate\Http\Response
   */
  public function show(Stock $stock)
  {
    $stockHistoriques = $stock->history()->get();


    $suivi_actions = Activity::where("log_name","stock")->where("subject_id" , $stock->id)->get();
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
      "stock"            => $stock,
      "suivi_actions"    => $suivi_actions,
      "stockHistoriques" => $stockHistoriques,
    ];
    return view("stocks.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Stock  $stock
   * @return \Illuminate\Http\Response
   */
  public function edit(Stock $stock)
  {
    $all = [ "stock" => $stock ];
    return view("stocks.edit",$all);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Stock  $stock
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Stock $stock)
  {
    $request->validate([
      "qte_min"  => ['required','numeric','min:1'],
      "qte_max"  => ['nullable','numeric','min:0'],
      "qte_alert"  => ['nullable','numeric','min:1'],
      "initial"  => ['nullable','numeric','min:1'],
    ]);

    $stock->update([
      "initial"    => $request->initial,
      "qte_alert"    => $request->qte_alert ?? 0,
      "min"        => $request->qte_min ?? 1,
      "max"        => $request->qte_max ?? 0,
    ]);

      toast("La modification du stock effectuée","success");
      return redirect()->route('stock.index');
  }
}

