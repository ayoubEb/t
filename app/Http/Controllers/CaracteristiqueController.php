<?php

namespace App\Http\Controllers;

use App\Models\Caracteristique;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Models\Activity;

class CaracteristiqueController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:caracteristique-list|caracteristique-nouveau|caracteristique-modification', ['only' => ['index','show']]);

    $this->middleware('permission:caracteristique-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:caracteristique-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:caracteristique-suppression', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $caracteristiques = DB::table("caracteristiques")->select("id","nom")->get();
    $all              = [ "caracteristiques" => $caracteristiques ];
    return view("caracteristiques.index",$all );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view("caracteristiques.create");
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
      "nom" => ["required","unique:caracteristiques,nom"],
    ]);
    Caracteristique::create([
      "nom"=>$request->nom,
    ]);

    toast("L'enregistrement du caractéristiques effectuée","success");
    return redirect()->route('caracteristique.index');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Caracteristique  $caracteristique
   * @return \Illuminate\Http\Response
  */
  public function edit(Caracteristique $caracteristique)
  {
    $all              = [ "caracteristique" => $caracteristique ];
    return view("caracteristiques.edit",$all );
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Caracteristique  $caracteristique
   * @return \Illuminate\Http\Response
  */
  public function show(Caracteristique $caracteristique)
  {

    $suivi_actions = Activity::where("log_name","caracteristique")->where("subject_id",$caracteristique->id)->get();
    foreach($suivi_actions as $pro_suivi){
      $user_check = User::where("id",$pro_suivi->causer_id)->exists();
      if($user_check == true){
        $pro_suivi->user = User::find($pro_suivi->causer_id)->first()->name;
      }
    }
    // $suivi_check = Activity::where("log_name","caractéristique")->where("subject_id",$caracteristique->id)->exists();
    // if($suivi_check == true){
    // }
    // else{
    //   $suivi_check == false;
    // }

    $all              = [
      "caracteristique" => $caracteristique,
      "suivi_actions" => $suivi_actions,
    ];
    return view("caracteristiques.show",$all );
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Caracteristique  $caracteristique
   * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Caracteristique $caracteristique)
  {
    $request->validate([
      'nom' => [
        "required",
        Rule::unique('caracteristiques', 'nom')->ignore($caracteristique->id),
      ],
    ]);
    $caracteristique->update([
      "nom"=>$request->nom
    ]);
    toast("La modification du caractéristique effectuée","success");
    return redirect()->route('caracteristique.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Caracteristique  $caracteristique
   * @return \Illuminate\Http\Response
   */
  public function destroy(Caracteristique $caracteristique)
  {
    $caracteristique->delete();
    toast("La déplacement du corbeille du caractéristique effectuée","success");
    return back();
  }
}
