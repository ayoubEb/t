<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Entreprise;
use App\Models\Facture;
use App\Models\FacturePaiement;
use App\Models\FacturePaiementCheque;
use App\Models\FactureReglement;
use App\Models\LigneRapport;
use App\Models\Rapport;
use App\Models\RapportCrm;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class FacturePaiementController extends Controller
{
  function __construct()
  {
       $this->middleware('permission:facturePaiement-list|facturePaiement-nouveau|facturePaiement-modification|facturePaiement-suppression', ['only' => ['index','show']]);
       $this->middleware('permission:facturePaiement-nouveau', ['only' => 'add','store']);
       $this->middleware('permission:facturePaiement-modification', ['only' => ['edit','update']]);
       $this->middleware('permission:facturePaiement-suppression', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index(Request $request)
  {
    $facturesPaiements = FacturePaiement::all();
    $all               = [ "facturePaiements"=>$facturesPaiements ];
    return view("ventePaiements.index",$all);
  }



  public function add($id)
  {
    $facture = Facture::find($id);
    if($facture->statut == "validé" && $facture->reste != 0)
    {
      $banks = DB::table("banks")->select("nom_bank","id")->get();
      $all = [
          "facture" => $facture,
          "banks"      => $banks
      ];
      return view("ventePaiements.new",$all);
    }
    else
    {
      return redirect()->route('facturePaiement.index');
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $facture = Facture::where("id",$request->facture_id)->first();
    $max   =  $facture->reste;
    $request->validate([
      "payer" => ["required","numeric","max:" . $max],
      "type"  => ["required","in:espèce,chèque"]
    ]);
    $count = FacturePaiement::where("facture_id",$facture->id)->count() + 1;
    $num = "reçu-n".$count;
    if($request->type == "chèque")
    {
      $request->validate([
        "numero"           => ["required","unique:facture_paiement_cheques,numero"],
        "nom_bank"         => ["required"],
        "date_cheque"      => ["required"],
        "date_enquisement" => ["required"],
        "statusCheque" => ["required"],
      ]);
    }
    $facture_ex = Facture::where("id",$request->facture_id)->exists();
    if($facture_ex == true)
    {
      $facture_paiement = FacturePaiement::create([
        "facture_id"       => $facture->id,
        "num"       => $num,
        "numero_operation" => rand(),
        "payer"            => $request->payer,
        "type_paiement"    => $request->type,
        "date_paiement"    => Carbon::now(),
        "statut"=>$request->type == "espèce" ? "payé" : "impayé",
      ]);

      if($request->type == "chèque"){
        FacturePaiementCheque::create([
          "facture_paiement_id" => $facture_paiement->id,
          "numero"              => $request->numero,
          "bank_id"             => $request->nom_bank,
          "date_cheque"         => $request->date_cheque,
          "date_enquisement"    => $request->date_enquisement,
        ]);
      }

      $facture->update([
        "payer"         => $facture->payer + $request->payer,
        "reste"         => $facture->reste - $request->payer,
      ]);

      $this->moveRapport($facture->id);
      $this->updateClient($facture->id);
      if($facture->reste == 0){
        Session()->flash("sup","");
        toast("L'enregistrement de paiement effectuée et en complément","success");
        return redirect()->route('facture.show',["facture"=>$facture]);
      }
      else
      {
        toast("L'enregistrement du paiement effectuée","success");
        return redirect()->route("facturePaiement.minInfo",["facturePaiement" => $facture_paiement]);
      }
    }
  }
  public function moveRapport($id)
  {
    $facture   = Facture::find($id);
    $first_day = Carbon::createFromFormat('Y-m-d', $facture->date_facture)->startOfMonth()->toDateString();
    $end_day   = Carbon::createFromFormat('Y-m-d', $facture->date_facture)->endOfMonth()->toDateString();
    Rapport::where("reference",$facture->num)->update([
      "payer"  => $facture->payer,
      "reste"  => $facture->reste,
      "status" => $facture->statut,
    ]);
    $sum_payer    = Rapport::whereBetween("jour",[$first_day , $end_day])->sum("payer");
    $mois         = date("m-Y",strtotime($facture->date_facture));
    $ligneRapport = LigneRapport::where("mois",$mois)->first();
    $ligneRapport->update([
      "payer_vente" => $sum_payer,
      "reste_vente" => $ligneRapport->montant_achat - $sum_payer,
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\FacturePaiement  $facturePaiement
   * @return \Illuminate\Http\Response
  */
  public function show(FacturePaiement $facturePaiement)
  {
    $facture = Facture::find($facturePaiement->facture_id);
    $client  = Client::find($facture->client_id);
    $all = [
      "facturePaiement" => $facturePaiement,
      "client"          => $client,
      "facture"          => $facture
    ];
    return view("ventePaiements.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\FacturePaiement  $facturePaiement
   * @return \Illuminate\Http\Response
  */
  public function edit(FacturePaiement $facturePaiement)
  {
    $facture = Facture::find($facturePaiement->facture_id);
    $banques = DB::table("banks")->select("nom_bank","id")->get();
    $all = [
        "facturePaiement" => $facturePaiement,
        "facture"         => $facture,
        "banques"         => $banques,
    ];
    return view("ventePaiements.edit",$all);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\FacturePaiement  $facturePaiement
   * @return \Illuminate\Http\Response
  */
  public function update(Request $request, FacturePaiement $facturePaiement)
  {
    $request->validate([
      "payer"=>["required","numeric"]
    ]);

    $facture = Facture::where("id",$facturePaiement->facture_id)->first();
    $mt_payer_avant = $facture->payer - $facturePaiement->payer;
    $mt_reste_avant = $facture->reste + $facturePaiement->payer;
    $facturePaiement->update([
      "payer"  => $request->payer,
      "statut" => $request->statut ? $request->statut : "payé",
    ]);
    $facture->update([
        "payer"=>$mt_payer_avant + $request->payer,
        "reste"=>$mt_reste_avant - $request->payer,
    ]);
    if($facturePaiement->type_paiement == "chèque")
    {

      $request->validate([
        "numero"           => ["required"],
        "banque"           => ["required","exists:banks,id"],
        "date_cheque"      => ["required"],
        "date_enquisement" => ["required"],
      ]);
      $factureCheque = FacturePaiementCheque::where("facture_paiement_id",$facturePaiement->id)->first();
      $factureCheque->update([
        "numero"            => $request->numero,
        "bank_id"            => $request->banque,
        "date_cheque"       => $request->date_cheque,
        "date_enquisement"  => $request->date_enquisement,
      ]);
    }
    $this->moveRapport($facture->id);
    if($facture->etat_paiement == 'en avance'){
      toast("La modification du paiement effectuée","success");
      return back();
    }
    else
    {
      toast("La modification du paiement effectuée et complémenet","success");
      return redirect()->route('facturePaiement.index');

    }
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\FacturePaiement  $facturePaiement
   * @return \Illuminate\Http\Response
   */
  public function destroy(FacturePaiement $facturePaiement)
  {
    $facture = Facture::where("id",$facturePaiement->facture_id)->first();
    $facture->update([
        "payer"=>$facture->payer - $facturePaiement->payer,
        "reste"=>$facture->reste + $facturePaiement->payer,
    ]);
    $facturePaiement->delete();
    Session::flash("sup","");
    toast("La suppression du paiement effectuée","success");
    return back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\FacturePaiement  $facturePaiement
   * @return \Illuminate\Http\Response
  */
  public function minInfo(FacturePaiement $facturePaiement)
  {
    $facture = Facture::find($facturePaiement->facture_id);
    $client = Client::find($facture->client_id);
    $all  = [
      "facturePaiement"=>$facturePaiement,
      "facture"=>$facture,
      "client"=>$client,
    ];
    Session::flash("sup","");
    return view("ventePaiements.afterSave",$all);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\FacturePaiement  $facturePaiement
   * @return \Illuminate\Http\Response
  */
  public function recu(FacturePaiement $facturePaiement)
  {
    $facture    = Facture::find($facturePaiement->facture_id);
    $client     = Client::find($facture->client_id);
    $entreprise = Entreprise::find($facture->etreprise_id);
    $all = [
      "facturePaiement" => $facturePaiement,
      "facture"         => $facture,
      "client"          => $client,
      "entreprise"      => $entreprise,
    ];
    $pdf = Pdf::loadview('ventePaiements.recu',$all);
    $pdf->setPaper('A5', 'landscape');
    return $pdf->stream("reçu paiement:".$facturePaiement->numero_operation);
  }



  public function updateClient($id)
  {
    $facture    = Facture::find($id);
    $mt_facture = Facture::where("client_id",$facture->client_id)->where("statut","validé")->sum("net_payer");
    $sum_payer  = Facture::where("client_id",$facture->client_id)->sum("payer");
    $client     = Client::find($facture->client_id);
    $client->update([
      "montant"       => $mt_facture,
      "reste"         => $mt_facture,
      "payer"         => $sum_payer
    ]);


    $ligneRapport= null;

    $ligneRapport_ex = LigneRapport::where("mois",$client->moisCreation)->exists();
    $rapportCrm_ex = RapportCrm::where("identifiant",$client->identifiant)->exists();
    if($ligneRapport_ex == true){
      $ligne = LigneRapport::where("mois",$client->moisCreation)->first();
      $ligneRapport = $ligne;
    }
    else
    {

      $ligneRapport = LigneRapport::create([
        "num"=>Str::upper(Str::random(8)),
        "mois"=>$client->moisCreation,
      ]);
    }


    if($rapportCrm_ex == true){
      $rapport_crm =RapportCrm::where("identifiant",$client->identifiant)->first();
      $rapport_crm->update([
        "montant"          => $client->montant,
        "payer"            => $client->payer,
        "reste"            => $client->reste,
      ]);

    }
    else
    {

      RapportCrm::create([
        "ligne_rapport_id" => $ligneRapport->id,
        "identifiant"      => $client->identifiant,
        "name"      => $client->raison_sociale,
        "jour"             => $client->dateCreation,
        "affecter"         => "client",
        "montant"          => $client->montant,
        "payer"            => $client->payer,
        "reste"            => $client->reste,
      ]);
    }
  }

}
