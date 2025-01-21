<?php

namespace App\Http\Controllers;

use App\Models\AchatPaiement;
use App\Models\Fournisseur;
use App\Models\LigneAchat;
use App\Models\LigneRapport;
use App\Models\RapportCrm;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Models\Activity;

class FournisseurController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:fournisseur-list|fournisseur-nouveau|fournisseur-modification|fournisseur-display', ['only' => ['index','show']]);

    $this->middleware('permission:fournisseur-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:fournisseur-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:fournisseur-suppression', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $fournisseurs = Fournisseur::all();
    $all          = [ "fournisseurs"=>$fournisseurs ];
    return view("fournisseurs.index",$all);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view("fournisseurs.create");
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
      "raison_sociale"  => ["required"],
      "code_postal"     => ['nullable',"numeric","digits:5"],
      "telephone"       => ["numeric","required"],
      "maxMontantPayer" => ["nullable","numeric","min:0"],
      "ice"             => ["nullable", "digits_between:1,16","unique:fournisseurs,ice"],
      "rc"              => ["nullable", "digits_between:1,16","unique:fournisseurs,rc"],
    ]);
    $count_fourni = DB::table("fournisseurs")->count();
    $iden         = "for-0".($count_fourni + 1).Str::random(6);
    $fournisseur = Fournisseur::create([
      "identifiant"     => Str::upper($iden),
      "raison_sociale"  => $request->raison_sociale,
      "ice"             => $request->ice,
      "rc"              => $request->rc,
      "email"           => $request->email,
      "telephone"       => $request->telephone,
      "fix"             => $request->fix,
      "adresse"         => $request->adresse,
      "ville"           => $request->ville,
      "pays"            => $request->pays,
      "code_postal"     => $request->code_postal,
      "montant"         => 0,
      "payer"           => 0,
      "reste"           => 0,
      "montant_devis"   => 0,
      "maxMontantPayer" => $request->maxMontantPayer ?? 0,
      'moisCreation'            => date("m-Y"),
      "dateCreation"    => Carbon::now(),
    ]);
    $ligneRapport= null;
    $ligneRapport_ex = LigneRapport::where("mois",$fournisseur->moisCreation)->exists();
    if($ligneRapport_ex == true){
      $ligne = LigneRapport::where("mois",$fournisseur->moisCreation)->first();
      $ligneRapport = $ligne;
    }
    else
    {

      $ligneRapport = LigneRapport::create([
        "num"=>Str::upper(Str::random(8)),
        "mois"=>$fournisseur->moisCreation,
      ]);
    }

    RapportCrm::create([
      "ligne_rapport_id" => $ligneRapport->id,
      "name"             => $fournisseur->raison_sociale,
      "identifiant"      => $fournisseur->identifiant,
      "jour"             => $fournisseur->dateCreation,
      "montant"          => $fournisseur->montant,
      "payer"            => $fournisseur->payer,
      "reste"            => $fournisseur->reste,
    ]);
    toast("L'enregistrement du fournisseur effectuée","success");
    return redirect()->route('fournisseur.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Fournisseur  $fournisseur
   * @return \Illuminate\Http\Response
  */
  public function show(Fournisseur $fournisseur)
  {
    $ligneAchats        = $fournisseur->ligne_achats()->paginate(15);
    $paiements          = $fournisseur->paiements()->get();
    $fournisseur_suivis = Activity::where("log_name","fournisseur")->get();
    foreach($fournisseur_suivis as $suivi){
      $suivi->user = User::find($suivi->causer_id)->first()->name;
    }
    $all = [
      "fournisseur"        => $fournisseur,
      "fournisseur_suivis" => $fournisseur_suivis,
      "ligneAchats"        => $ligneAchats,
      "paiements"          => $paiements,
    ];
    return view("fournisseurs.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Fournisseur  $fournisseur
   * @return \Illuminate\Http\Response
  */
  public function edit(Fournisseur $fournisseur)
  {
    $all = [ "fournisseur" => $fournisseur ];
    return view("fournisseurs.edit",$all);
  }

  /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Fournisseur  $fournisseur
    * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Fournisseur $fournisseur)
  {
    $request->validate([
      "raison_sociale"  => ["required"],
      "code_postal"     => ['nullable',"numeric","digits:5"],
      "telephone"       => ["numeric","required"],
      "maxMontantPayer" => ["numeric","required",'min:0'],
      'ice' => [
        "nullable", "digits_between:1,16",
        Rule::unique('fournisseurs', 'ice')->ignore($fournisseur->id),
      ],
      'rc' => [
        "nullable", "digits_between:1,16",
        Rule::unique('fournisseurs', 'rc')->ignore($fournisseur->id),
      ],
      'email' => [
        "nullable","email",
        Rule::unique('fournisseurs', 'email')->ignore($fournisseur->id),
      ],
    ]);
    $fournisseur->update([
      "raison_sociale"  => $request->raison_sociale,
      "ice"             => $request->ice,
      "rc"              => $request->rc,
      "email"           => $request->email,
      "telephone"       => $request->telephone,
      "fix"             => $request->fix,
      "adresse"         => $request->adresse,
      "ville"           => $request->ville,
      "pays"            => $request->pays,
      "code_postal"     => $request->code_postal,
      "maxMontantPayer" => $request->maxMontantPayer ?? 0,
    ]);
    toast("La modification du fournisseur effectuée","success");
    return back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Fournisseur  $fournisseur
   * @return \Illuminate\Http\Response
  */
  public function destroy(Fournisseur $fournisseur,Request $request)
  {
    $fournisseur->delete();
    toast("La suppression du fournisseur effectuée","success");
    return back();
  }

    public function paiements(Fournisseur $fournisseur)
    {
        $especes = $fournisseur->paiements()->where("type_paiement","espèce")->get();
        $paiementCheques = $fournisseur->paiements()->where("type_paiement","chèque")->get();
        return view("achats.fournisseurs.paiements",[
            "fournisseur"=>$fournisseur,
            "especes"=>$especes,
            "paiementCheques"=>$paiementCheques
        ]);
    }

    public function ligneAchats(Fournisseur $fournisseur)
    {
        $ligneAchats = $fournisseur->ligne_achats()->get();
        $all =
        [
          "fournisseur"=>$fournisseur,
          "ligneAchats"=>$ligneAchats
        ];
        return view("fournisseurs.ligneAchats",$all);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function rapportDocument(Fournisseur $fournisseur)
    {
      $achats = $fournisseur->ligne_achats()->get();
      $achat_ids = LigneAchat::where("fournisseur_id",$fournisseur->id)->pluck("id");
      $paiements = AchatPaiement::whereIn("ligne_achat_id",$achat_ids)->get();
      $all = [
        "fournisseur"        => $fournisseur,
        "achats"        => $achats,
        "paiements"        => $paiements,
      ];
      $pdf = Pdf::loadview('fournisseurs.rapportDocument',$all);
      return $pdf->stream("rapport:". $fournisseur->identifiant);
    }


}
