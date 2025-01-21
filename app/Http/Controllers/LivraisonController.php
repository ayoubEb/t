<?php

namespace App\Http\Controllers;

use App\Models\Livraison;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Models\Activity;

class LivraisonController extends Controller
{
  function __construct()
  {
    // $this->middleware('permission:livraison-list|livraison-nouveau|livraison-modification|livraison-display', ['only' => ['index']]);
    $this->middleware('permission:livraison-list', ['only' => 'index']);

    $this->middleware('permission:livraison-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:livraison-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:livraison-suppression', ['only' => 'destroy']);

    $this->middleware('permission:livraison-display', ['only' => 'show']);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $livraisons = Livraison::select("id","libelle","ville","prix")->get();
    $all        = [ "livraisons" => $livraisons ];
    return view("livraisons.index",$all);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view("livraisons.create");
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
      "prix"           => ["required","numeric","min:0"],
      "ville"          => ["required",'unique:livraisons,ville'],
    ]);
    Livraison::create([
      "prix"    => $request->prix,
      "libelle" => $request->libelle,
      "ville"   => $request->ville,
    ]);
    toast("L'enregistrement de livraison effectuée","success");
    return redirect()->route('livraison.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Livraison  $livraison
   * @return \Illuminate\Http\Response
  */
  public function show(Livraison $livraison)
  {
    $suivi_actions = Activity::where("log_name","livraison")->where("subject_id",$livraison->id)->get();
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
      "livraison"     => $livraison,
      "suivi_actions" => $suivi_actions,
    ];
    return view("livraisons.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Livraison  $livraison
   * @return \Illuminate\Http\Response
  */
  public function edit(Livraison $livraison)
  {
    $all = [ "livraison" => $livraison ];
    return view("livraisons.edit",$all);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Livraison  $livraison
   * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Livraison $livraison)
  {
    $request->validate([
      "prix"           => ["required","numeric",'min:0'],
      'ville' => [
        "required",
        Rule::unique('livraisons', 'ville')->ignore($livraison->id),
      ],
    ]);
    $livraison->update([
      "prix"    => $request->prix,
      "libelle" => $request->libelle,
      "ville"   => $request->ville,
    ]);
    toast("La modification de livraison effectuée","success");
    return redirect()->route('livraison.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Livraison  $livraison
   * @return \Illuminate\Http\Response
  */
  public function destroy(Livraison $livraison)
  {
    $livraison->delete();
    toast("La suppression de livraison effectuée","success");
    return back();
  }


  public function livraisonPrice()
  {
    $id = intval(request("id"));
    $price = DB::table("livraisons")->where("id",$id)->first()->prix;
    return $price;
  }
}
