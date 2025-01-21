<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use App\Models\StockDepot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Models\Activity;

class DepotController extends Controller
{
  function __construct()
  {
    // $this->middleware('permission:depot-list|depot-nouveau|depot-modification|depot-display', ['only' => ['index','show']]);
    $this->middleware('permission:depot-list', ['only' => 'index']);

    $this->middleware('permission:depot-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:depot-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:depot-suppression', ['only' => 'destroy']);

    $this->middleware('permission:depot-display', ['only' => 'show']);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $depots = Depot::select("id","num_depot","quantite","disponible","sortie","entre","adresse")->get();
    $all    = [ "depots" => $depots ];
    return view("depots.index",$all);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view("depots.create");
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
      "adresse"=>["required"],
      "num_depot"=>['required','unique:depots,num_depot']
    ]);
    // $count_depot = DB::table("depots")->count() + 1;
    Depot::create([
      "num_depot"=>$request->num_depot,
      "adresse"=>$request->adresse
    ]);
    toast("L'enregistrement de depôt effectuée" , "success");
    return redirect()->route('depot.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Depot  $depot
   * @return \Illuminate\Http\Response
  */
  public function show(Depot $depot)
  {
    $suivi_actions = Activity::where("log_name","depot")->where('subject_id',$depot->id)->get();
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

    $stock_depots = $depot->stockDepot()->get();
    $all = [
      "depot"         => $depot,
      "suivi_actions" => $suivi_actions,
      "stock_depots"  => $stock_depots
    ];
    return view("depots.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Depot  $depot
   * @return \Illuminate\Http\Response
  */
  public function edit(Depot $depot)
  {
    $all = [ "depot" => $depot ];
    return view("depots.edit",$all);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Depot  $depot
   * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Depot $depot)
  {
    $request->validate([
      "adresse"   => ["required"],
      'num_depot' => [
        "required",
        Rule::unique('depots', 'num_depot')->ignore($depot->id),
      ],
    ]);
    $depot->update([
      "adresse"   => $request->adresse,
      "num_depot" => $request->num_depot,
    ]);
    toast("La modification de depôt effectuée" , "success");
    return redirect()->route('depot.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Depot  $depot
   * @return \Illuminate\Http\Response
  */
  public function destroy(Depot $depot)
  {
    StockDepot::where("depot_id",$depot->id)->delete();
    $depot->delete();
    toast("La suppression de depôt effectuée","success");
    return back();
  }
}
