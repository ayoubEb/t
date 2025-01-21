<?php

namespace App\Http\Controllers;

use App\Models\TauxTva;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Models\Activity;

class TauxTvaController extends Controller
{
  function __construct()
  {
    // $this->middleware('permission:tauxTva-list|tauxTva-nouveau|tauxTva-modification', ['only' => ['index']]);
    $this->middleware('permission:tauxTva-list', ['only' => ['index']]);

    $this->middleware('permission:tauxTva-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:tauxTva-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:tauxTva-suppression', ['only' => ['destroy']]);

    $this->middleware('permission:tauxTva-display', ['only' => ['show']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $tauxTvas = TauxTva::select("id","valeur","description")->get();
    $all      = [ "tauxTvas" => $tauxTvas ];
    return view("tauxTva.index",$all );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view("tauxTva.create");
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
      "valeur" => ["required","numeric","unique:taux_tvas,valeur","min:0"],
    ]);
    TauxTva::create([
      "nom"         => $request->nom,
      "valeur"      => $request->valeur,
      "description" => $request->description,
    ]);
    toast("L'enregistrement du tva effectuée","success");
    return redirect()->route('tauxTva.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\TauxTva  $tauxTva
   * @return \Illuminate\Http\Response
  */
  public function show(TauxTva $tauxTva)
  {
    $suivi_actions = Activity::where("log_name","taux_tva")->where("subject_id",$tauxTva->id)->get();
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
      "tauxTva"     => $tauxTva,
      "suivi_actions" => $suivi_actions,
    ];
    return view("tauxTva.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\TauxTva  $tauxTva
   * @return \Illuminate\Http\Response
  */
  public function edit(TauxTva $tauxTva)
  {
    $all = [ "tauxTva" => $tauxTva ];
    return view("tauxTva.edit",$all );
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\TauxTva  $tauxTva
   * @return \Illuminate\Http\Response
  */
  public function update(Request $request, TauxTva $tauxTva)
  {
    $request->validate([
      'valeur' => [
        "required","numeric",'min:0',
        Rule::unique('taux_tvas', 'valeur')->ignore($tauxTva->id),
      ],
    ]);
    $tauxTva->update([
      "valeur"      => $request->valeur,
      "description" => $request->description,
    ]);
    toast("La modification du tva effectuée","success");
    return redirect()->route('tauxTva.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\TauxTva  $tauxTva
   * @return \Illuminate\Http\Response
  */
  public function destroy(TauxTva $tauxTva)
  {
    $tauxTva->delete();
    toast("La suppression du tva effectuée","success");
    return back();
  }
}
