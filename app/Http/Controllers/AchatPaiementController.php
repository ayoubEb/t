<?php

namespace App\Http\Controllers;

use App\Models\AchatPaiement;
use App\Http\Controllers\Controller;
use App\Models\Achat;
use App\Models\AchatCheque;
use App\Models\Bank;
use App\Models\Entreprise;
use App\Models\Fournisseur;
use App\Models\LigneAchat;
use App\Models\LigneRapport;
use App\Models\Rapport;
use App\Models\RapportCrm;
use App\Models\RapportPaiement;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class AchatPaiementController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:achatPaiement-list|achatPaiement-nouveau|achatPaiement-modification|achatPaiement-suppression', ['only' => ['index','show']]);

    $this->middleware('permission:achatPaiement-nouveau', ['only' => ['store' , 'add']]);

    $this->middleware('permission:achatPaiement-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:achatPaiement-suppression', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $achatPaiements = AchatPaiement::all();
    $all            = [ "achatPaiements"  => $achatPaiements ];
    return view("achatPaiements.index",$all);
  }



  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $ligne = LigneAchat::where("id",request("ligne_achat_id"))->first();

    $max   = $ligne->reste;
    $request->validate([
      "payer" => ["required","numeric","max:" . $max],
      "type"  => ["required"]
    ]);
    if($request->type == "chèque")
    {
      $request->validate([
        "payer"            => ["required","numeric","max:" . $max],
        "type"             => ["required"],
        "numero"           => ["required","unique:achat_cheques,numero"],
        "nom_bank"         => ["required"],
        "date_cheque"      => ["required"],
        "date_enquisement" => ["required"],
        "statusCheque"     => ["required"],
      ]);
    }

    $numero = Str::random(6);
    /**
     * ? save achat paiement
     */

    $count = DB::table("achat_paiements")->count() + 1;
    $achat_paiement = AchatPaiement::create([
      "num" => Str::upper("reçu-0" . $count),
      "numero_operation" => Str::upper($numero),
      "ligne_achat_id"   => $ligne->id,
      "payer"            => $request->payer,
      "type_paiement"    => $request->type,
      "date_paiement"    => Carbon::now(),
      "statut"           => $request->type == "espèce" ? "payé" : $request->statusCheque,
    ]);
    if($request->type == "chèque")
    {

      // $request->validate()
      $banque   = Bank::where("id",$request->nom_bank)->exists();
      $nom_bank = Bank::where("id",$request->nom_bank)->first()->nom_bank;
      AchatCheque::create([
        "achat_paiement_id" => $achat_paiement->id,
        "numero"            => $request->numero,
        "banque"            => $banque == true ? $nom_bank : null,
        "date_cheque"       => $request->date_cheque,
        "date_enquisement"  => $request->date_enquisement,
      ]);
    }
    $sum_payer = AchatPaiement::where("ligne_achat_id",$ligne->id)->sum("payer");
    $ligne->update([
        "payer"         => $sum_payer,
        "reste"         => $ligne->ttc- $sum_payer,
    ]);
    $this->saveRapport($ligne->id);
    $this->updateFournisseur($ligne->fournisseur_id , $ligne->id);

    toast("L'enregistrement du paiement effectuée","success");
    return redirect()->route("achatPaiement.minInfo",["achatPaiement" => $achat_paiement]);


  }

  public function saveRapport($id)
  {
    $ligneAchat = LigneAchat::find($id);
    $first_day  = Carbon::createFromFormat('Y-m-d', $ligneAchat->date_achat)->startOfMonth()->toDateString();
    $end_day    = Carbon::createFromFormat('Y-m-d', $ligneAchat->date_achat)->endOfMonth()->toDateString();
    Rapport::where("reference",$ligneAchat->num_achat)->update([
      "payer" => $ligneAchat->payer,
      "reste" => $ligneAchat->reste,
    ]);
    $sum_payer    = Rapport::whereBetween("jour",[$first_day , $end_day])->sum("payer");
    $mois         = date("m-Y",strtotime($ligneAchat->date_achat));
    $ligneRapport = LigneRapport::where("mois",$mois)->first();
    $ligneRapport->update([
      "payer_achat" => $sum_payer,
      "reste_achat" => $ligneRapport->montant_achat - $sum_payer,
    ]);

  }


  public function updateFournisseur($id , $ligne_id)
  {
    $fournisseur = Fournisseur::find($id);
    $ligneAchat = LigneAchat::find($ligne_id);
    $sum_payer = LigneAchat::where("fournisseur_id",$fournisseur->id)->where("statut","validé")->sum("payer");
    $sum_total = LigneAchat::where("fournisseur_id",$fournisseur->id)->where("statut","validé")->sum("ttc");
    $fournisseur->update([
      "payer"=>$sum_payer,
      "montant"=>$sum_total,
      "reste"=>$sum_total - $sum_payer,
    ]);
    $ligneRapport = LigneRapport::where("mois",$ligneAchat->mois)->first();
    $rapportCrm_ex = RapportCrm::where("identifiant",$fournisseur->identifiant)->exists();
    if($rapportCrm_ex == true){
      $rapport_crm =RapportCrm::where("identifiant",$fournisseur->identifiant)->first();
      $rapport_crm->update([
        "montant"          => $fournisseur->montant,
        "payer"            => $fournisseur->payer,
        "reste"            => $fournisseur->reste,
      ]);

    }
    else
    {

      RapportCrm::create([
        "ligne_rapport_id" => $ligneRapport->id,
        "identifiant"      => $fournisseur->identifiant,
        "name"      => $fournisseur->raison_sociale,
        "jour"             => $fournisseur->dateCreation,
        "affecter"         => "fournisseur",
        "montant"          => $fournisseur->montant,
        "payer"            => $fournisseur->payer,
        "reste"            => $fournisseur->reste,
      ]);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\AchatPaiement  $achatPaiement
   * @return \Illuminate\Http\Response
   */
  public function show(AchatPaiement $achatPaiement)
  {
    $ligneAchat = LigneAchat::find($achatPaiement->ligne_achat_id);
    $fournisseur = Fournisseur::find($ligneAchat->fournisseur_id);
    $all = [
      "achatPaiement"=>$achatPaiement,
      "fournisseur"=>$fournisseur,
      "ligneAchat"=>$ligneAchat,
    ];
      return view("achatPaiements.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\AchatPaiement  $achatPaiement
   * @return \Illuminate\Http\Response
  */
  public function edit(AchatPaiement $achatPaiement)
  {
    $ligneAchat = LigneAchat::where("id",$achatPaiement->ligne_achat_id)->first();
    $banques    = DB::table("banks")->pluck("nom_bank");
    $all = [
        "achatPaiement" => $achatPaiement,
        "ligneAchat"    => $ligneAchat,
        "banques"       => $banques,
    ];
    return view("achatPaiements.edit",$all);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\AchatPaiement  $achatPaiement
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, AchatPaiement $achatPaiement)
  {

    $request->validate([
      "payer"=>["required","numeric"]
    ]);

    $ligneAchat = LigneAchat::where("id",$achatPaiement->ligne_achat_id)->first();
    $achatPaiement->update([
      "payer"=>$request->payer,
      "status"=>$request->status ? $request->status : "payé",
    ]);
    $sum_payer = AchatPaiement::where("ligne_achat_id",$ligneAchat->id)
                ->where('statut',"payé")
                ->sum("payer");
    $ligneAchat->update([
      "payer"=>$sum_payer,
      "reste"=>$ligneAchat->ttc - $sum_payer
    ]);
    if($achatPaiement->type_paiement == "chèque")
    {

      $request->validate([
        "numero"           => ["required"],
        "banque"           => ["required"],
        "date_cheque"      => ["required"],
        "date_enquisement" => ["required"],
      ]);

      $banque      = Bank::where("nom_bank",$request->banque)->exists();
      $achatCheque = AchatCheque::where("achat_paiement_id",$achatPaiement->id)->first();
      $achatCheque->update([
        "numero"            => $request->numero,
        "banque"            => $banque == true ? $request->banque : null,
        "date_cheque"       => $request->date_cheque,
        "date_enquisement"  => $request->date_enquisement,
      ]);
    }
    $this->saveRapport($ligneAchat->id);
    $this->updateFournisseur($ligneAchat->fournisseur_id , $ligneAchat->id);
    toast("La modification du paiement effectuée","success");
    return back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\AchatPaiement  $achatPaiement
   * @return \Illuminate\Http\Response
  */
  public function destroy(AchatPaiement $achatPaiement)
  {
    $ligneAchat = LigneAchat::where("id",$achatPaiement->ligne_achat_id)->first();
    $ligneAchat->update([
      "payer"=>$ligneAchat->payer - $achatPaiement->payer,
      "reste"=>$ligneAchat->reste + $achatPaiement->payer,
    ]);
    $ligneRapport = LigneRapport::where("mois",$ligneAchat->mois)->first();
    $payer_new = $ligneRapport->payer_achat + $achatPaiement->payer;
    $ligneRapport->update([
      "payer_achat"=>$payer_new,
      "reste_achat"=>$ligneRapport->montant_achat - $payer_new,
    ]);

    $achatPaiement->cheque()->delete();
    $achatPaiement->delete();

    toast("La suppression du paiement effectuée","success");
    return back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\FacturePaiement  $facturePaiement
   * @return \Illuminate\Http\Response
  */
  public function minInfo(AchatPaiement $achatPaiement)
  {
    $ligneAchat   =   LigneAchat::find($achatPaiement->ligne_achat_id);
    $fournisseur  =   Fournisseur::find($ligneAchat->fournisseur_id);
    $all  = [
      "achatPaiement" => $achatPaiement,
      "ligneAchat"    => $ligneAchat,
      "fournisseur"   => $fournisseur,
    ];
    Session::flash("sup","");
    return view("achatPaiements.afterSave",$all);
  }

  public function recu(AchatPaiement $achatPaiement)
  {
    $ligneAchat  = LigneAchat::find($achatPaiement->ligne_achat_id);
    $fournisseur = Fournisseur::find($ligneAchat->fournisseur_id);
    $entreprise  = Entreprise::find($ligneAchat->entreprise_id);
    $all = [
      "achatPaiement" => $achatPaiement,
      "ligneAchat"    => $ligneAchat,
      "fournisseur"   => $fournisseur,
      "entreprise"    => $entreprise,
    ];
    $pdf = Pdf::loadview('achatPaiements.recu',$all);
    $pdf->setPaper("A5", 'landscape');
    return $pdf->stream("reçu paiement:".$achatPaiement->numero_operation);
  }


  public function add($id)
  {
    $ligneAchat = LigneAchat::find($id);
    if($ligneAchat->statut == "validé" && $ligneAchat->reste != 0)
    {
      $banks = DB::table("banks")->select("nom_bank","id")->get();
      $all   = [
        "ligneAchat" => $ligneAchat,
        "banks"      => $banks
      ];
      return view("achatPaiements.new",$all);
    }
    else
    {
      return back();

    }
  }
}
