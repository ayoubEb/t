<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Models\Activity;

class EntrepriseController extends Controller
{
  function __construct()
  {
    // $this->middleware('permission:entreprise-list|entreprise-nouveau|entreprise-modification|entreprise-display', ['only' => ['index','show']]);
    $this->middleware('permission:entreprise-list', ['only' => 'index']);

    $this->middleware('permission:entreprise-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:entreprise-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:entreprise-suppression', ['only' => 'destroy']);

    $this->middleware('permission:entreprise-display', ['only' => 'show']);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $entreprises = Entreprise::select("raison_sociale","logo","rc","if","ice","patente","site","cnss","ville","adresse","email" , "code_postal","telephone","fix","description" , "id")->get();
    $all         = [ "entreprises" => $entreprises ];
    return  view('entreprises.index',$all);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('entreprises.create');
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
      "raison_sociale" => ["required"],
      "adresse"        => ["required"],
      "ice"            => ["numeric","required","digits_between:1,16","unique:entreprises,ice"],
      "if"            => ["numeric","required","digits_between:1,16","unique:entreprises,if"],
      "rc"            => ["numeric","required","digits_between:1,16","unique:entreprises,rc"],
      "patente"        => ["numeric","required"],
      "cnss"           => ["nullable","numeric"],
      "site"           => ["nullable"],
      "telephone"      => ["required"],
      "ville"          => ["required"],
      "code_postal"    => ["nullable","numeric"],
      "email"          => ["required"],
    ]);


    if($request->hasFile("logo")){
      $destination_path = 'public/images/entreprises/';
      $image_produit    = $request->file("logo");
      $filename         = $image_produit->getClientOriginalName();
      $request->file("logo")->storeAs($destination_path,$filename);
    }

    Entreprise::create([
        "logo"           => $filename ?? "default.jpg",
        "raison_sociale" => request("raison_sociale"),
        "rc"             => request("rc"),
        "ice"            => request("ice"),
        "if"             => request("if"),
        "adresse"        => request("adresse"),
        "ville"          => request("ville"),
        "email"          => request("email"),
        "site"           => request("site"),
        "cnss"           => request("cnss"),
        "code_postal"    => request("code_postal"),
        "telephone"      => request("telephone"),
        "patente"        => request("patente"),
        "fix"            => request("fix"),
        "description"    => request("description"),
    ]);
    toast("L'enregistrement d'entreprise effectuée","success");
    return redirect()->route('entreprise.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Entreprise  $entreprise
   * @return \Illuminate\Http\Response
  */
  public function show(Entreprise $entreprise)
  {
    $suivi_actions = Activity::where("log_name","entreprise")->where("subject_id",$entreprise->id)->get();
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
      "entreprise"    => $entreprise,
      "suivi_actions" => $suivi_actions,
    ];
    return view('entreprises.show',$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Entreprise  $entreprise
   * @return \Illuminate\Http\Response
  */
  public function edit(Entreprise $entreprise)
  {
    $all = [ "entreprise" => $entreprise ];
    return view('entreprises.edit',$all);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Entreprise  $entreprise
   * @return \Illuminate\Http\Response
  */
  public function update(Request $request,Entreprise $entreprise)
  {
    $request->validate([
      "raison_sociale" => ["required"],
      "adresse"        => ["required"],
      'ice' => [
        "nullable","digits_between:1,16",
        Rule::unique('entreprises', 'ice')->ignore($entreprise->id),
      ],
      'if' => [
        "nullable","digits_between:1,16",
        Rule::unique('entreprises', 'if')->ignore($entreprise->id),
      ],
      'rc' => [
        "nullable","digits_between:1,16",
        Rule::unique('entreprises', 'rc')->ignore($entreprise->id),
      ],
      "patente"        => ["numeric","required"],
      "cnss"           => ["numeric","required"],
      "site"           => ["required"],
      "telephone"      => ["required"],
      "ville"          => ["required"],
      "code_postal"    => ["regex:/^([0-9]){1,5}$/","required"],
      "email"          => ["required"],
    ]);
    if (File::exists(storage_path().'/app/public/images/entreprises/'.$entreprise->logo)) {
      File::delete(storage_path().'/app/public/images/entreprises/'.$entreprise->logo);
    }

    if($request->hasFile("logo"))
    {
      $destination_path_produit = 'public/images/entreprises/';
      $logo                     = $request->file("logo");
      $logo_en                  = $logo->getClientOriginalName();
      $request->file("logo")->storeAs($destination_path_produit,$logo_en);
    }
    $entreprise->update([
      "logo"           => $logo_en ?? $entreprise->logo,
      "raison_sociale" => request("raison_sociale"),
      "rc"             => request("rc"),
      "ice"            => request("ice"),
      "if"             => request("if"),
      "adresse"        => request("adresse"),
      "ville"          => request("ville"),
      "email"          => request("email"),
      "site"           => request("site"),
      "cnss"           => request("cnss"),
      "code_postal"    => request("code_postal"),
      "telephone"      => request("telephone"),
      "patente"        => request("patente"),
      "fix"            => request("fix"),
      "description"    => request("description")
    ]);
    toast("La motification d'entreprise effectuée","success");
    return redirect()->route("entreprise.index");
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Entreprise  $entreprise
   * @return \Illuminate\Http\Response
   */
  public function destroy(Entreprise $entreprise,Request $request)
  {
    $entreprise->delete();
    toast("La suppression d'entreprise effectuée","success");
    return redirect()->route("entreprise.index");
  }
}
