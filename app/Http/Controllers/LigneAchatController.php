<?php

namespace App\Http\Controllers;

use App\Models\LigneAchat;
use App\Http\Controllers\Controller;
use App\Models\Achat;
use App\Models\CustomizeAchat;
use App\Models\CustomizeReference;
use App\Models\Depot;
use App\Models\DepotSuivi;
use App\Models\Entreprise;
use App\Models\Fournisseur;
use App\Models\LigneRapport;
use App\Models\Produit;
use App\Models\Rapport;
use App\Models\RapportCrm;
use App\Models\Stock;
use App\Models\StockDepot;
use App\Models\StockHistorique;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class LigneAchatController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:ligneAchat-list|ligneAchat-nouveau|ligneAchat-modification|ligneAchat-display', ['only' => ['index','show']]);

    $this->middleware('permission:ligneAchat-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:ligneAchat-modification', ['only' => ['edit','checkDepot','update']]);

    $this->middleware('permission:ligneAchat-suppression', ['only' => ['destroy']]);
  }
  /**
      * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $ligneAchats = LigneAchat::all();
    foreach($ligneAchats as $ligne){
      $today = Carbon::today();
      $toDate       = Carbon::parse($today);
      $fromDate     = Carbon::parse($ligne->date_paiement);
      $ligne->delai = $toDate->diffInDays($fromDate);
    }
    $all         = [ "ligneAchats"  => $ligneAchats ];
    return view("ligneAchats.index",$all);
  }

  /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $count_default = CustomizeReference::where("operation","achat")->count();
    $fournisseurs = DB::table("fournisseurs")->select("id","raison_sociale","deleted_at")->whereNull("deleted_at")->get();
    $produits     = DB::table("produits")->select("id","designation","prix_achat","reference","deleted_at")->whereNull("deleted_at")->get();
    $entreprises  = DB::table("entreprises")->select("id","raison_sociale","deleted_at")->whereNull("deleted_at")->get();
    $tvas         = DB::table("taux_tvas")->select("valeur")->pluck("valeur");

      $all = [
        "fournisseurs" => $fournisseurs,
        "produits"     => $produits,
        "entreprises"  => $entreprises,
        "tvas"         => $tvas,
        "count_default"         => $count_default,
      ];

    return view("ligneAchats.create",$all);
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
      "fournisseur" => ['required'],
      "statut"      => ['required'],
      "date_paiement"      => ['required'],
      "tva"         => ['required','numeric','exists:taux_tvas,valeur'],
    ]);
    $num         = CustomizeReference::where("check_exists",1)->where("champ","num_achat")->where("operation","achat")->first()->valeur;
    $separeteur  = CustomizeReference::where("check_exists",1)->where("champ","separateur")->where("operation","achat")->first()->valeur;
    $counter     = CustomizeReference::where("check_exists",1)->where("champ","counter")->where("operation","achat")->first()->valeur;
    $nombre_zero = CustomizeReference::where("check_exists",1)->where("champ","nombre_zero")->where("operation","achat")->first()->valeur;
    $reference   = null;
    $count_achat = LigneAchat::withTrashed()->count() + $counter;
    $coun_new    = $count_achat + intval($counter);
    $reference   = $num . $separeteur . str_pad($coun_new, intval($nombre_zero), "0", STR_PAD_LEFT);

    if(isset($request->pro)){
      $num               = CustomizeReference::where("check_exists",1)->where("champ","num_demande")->where("affecter","demande")->where("operation","achat")->first()->valeur;
      $separeteur        = CustomizeReference::where("check_exists",1)->where("champ","separateur")->where("affecter","demande")->where("operation","achat")->first()->valeur;
      $counter           = CustomizeReference::where("check_exists",1)->where("champ","counter")->where("affecter","demande")->where("operation","achat")->first()->valeur;
      $nombre_zero       = CustomizeReference::where("check_exists",1)->where("champ","nombre_zero")->where("affecter","demande")->where("operation","achat")->first()->valeur;
      $reference_demande = null;
      $count_achat       = LigneAchat::withTrashed()->where("statut","en cours")->count() + $counter;
      $coun_new          = $count_achat + intval($counter);
      $reference_demande = $num . $separeteur . str_pad($coun_new, intval($nombre_zero), "0", STR_PAD_LEFT);
      $count_ent         = Entreprise::count();
      $tva               = DB::table("taux_tvas")->where("id",$request->tva)->whereNull("deleted_at")->first();
      $mois              = date("m-Y",strtotime($request->date ?? Carbon::today() ));
      $ligne = LigneAchat::create([
        "fournisseur_id" => $request->fournisseur,
        "num_achat"      => $reference,
        "num_demande"    => $reference_demande,
        "statut"         => $request->statut,
        "date_paiement"         => $request->date_paiement,
        "date_achat"     => $request->date ?? Carbon::today(),
        "taux_tva"       => $request->tva,
        "entreprise_id"  => $count_ent == 1 ? Entreprise::first()->id : $request->entreprise_id,
        "payer"          => 0,
        "mois"           => $mois,
        "dateCreation"   => Carbon::today(),
        "nombre_achats"  => count($request->pro),
      ]);
      $tva = $request->tva;
      $ttc = 0;
      foreach($request->pro as $k =>  $value){
        $remise_pro = $request->remise[$k] ?? 0 ;
        $prix       = $request->prix[$k] ;
        $qte        = $request->quantite[$k] ?? 0 ;
        $montant    = $prix * $qte ;
        $mt         = $montant * ( 1 - ($remise_pro/100));
        $achat      = Achat::create([
          "ligne_achat_id" => $ligne->id,
          "produit_id"     => $request->pro[$k],
          "quantite"       => $qte,
          "remise"         => $remise_pro,
          "montant"        => $mt,
          "prix"           => $prix,
        ]);
        $this->saveAchat($achat->id);
        $stock      = Stock::where("produit_id",$value)->first();
        $stock->update([
          "qte_achatRes"=>$stock->qte_achatRes + $qte,
        ]);
      }
      $ht  = DB::table("achats")->where("ligne_achat_id",$ligne->id)->sum("montant");
      $ttc = $ht  + ($ht * ($tva/100));
      $ligne->update([
          "ttc"    => $ttc,
          "ht"     => $ht,
          "payer"  => 0,
          "mt_tva" => $ttc - $ht,
      ]);

      $this->saveRapport($ligne->id);
      $this->updateFournisseur($ligne->id);
    }
    toast("L'enregistrement d'achat effectuée","success");
    return redirect()->route('ligneAchat.index');
  }

  public function  saveAchat($achat)
  {
    $produitAchat = DB::table("achats")->where("id",$achat)->first();
    $produit      = DB::table("produits")->where("id",$produitAchat->produit_id)->first();
    $stock_check       = DB::table("stocks")->where("produit_id",$produit->id)->exists();
    $stock_id = null;
    if($stock_check == true)
    {
      $stock_id = DB::table("stocks")->where("produit_id",$produit->id)->first()->id;
    }
    else
    {
      $stock_new = Stock::create([
        "produit_id" => $produitAchat->produit_id,
        "num"        => Str::upper(Str::random(6)),
        "min"        => 0,
        "max"        => 0,
        "qte_achatRes"=>$produitAchat->quantite,
      ]);
      $stock_id = $stock_new->id;
    }
    StockHistorique::create([
      "stock_id"       => $stock_id,
      "quantite"       => $produitAchat->quantite,
      "fonction"       => "achat_reserver",
      "date_mouvement" => Carbon::today(),
    ]);
  }

  public function saveRapport($ligneAchat_id)
  {
    $ligneAchat   = LigneAchat::find($ligneAchat_id);
    $fournisseur  = Fournisseur::find($ligneAchat->fournisseur_id);
    $rand_num     = Str::random(5);
    $ligneRapport = null;
    $ligneRapport_ex = LigneRapport::where("mois",$ligneAchat->mois)->exists();
    if($ligneRapport_ex == true)
    {
      $ligneRapport = LigneRapport::where("mois",$ligneAchat->mois)->first();
    }
    else
    {
      $ligneRapport = LigneRapport::create([
        "num"      => Str::upper($rand_num),
        "mois"     => $ligneAchat->mois,
      ]);

    }
    Rapport::create([
      "identifiant"      => $fournisseur->identifiant,
      "raison_sociale"   => $fournisseur->raison_sociale,
      "ligne_rapport_id" => $ligneRapport->id,
      "montant"          => $ligneAchat->ttc,
      "jour"             => $request->date ?? Carbon::today(),
      "payer"            => $ligneAchat->payer,
      "reste"            => $ligneAchat->reste,
      "reference"        => $ligneAchat->num_achat,
      "affecter"         => "achat",
      "status"           => $ligneAchat->status,
    ]);
    $sum_ttc   = Rapport::where("ligne_rapport_id",$ligneRapport->id)->sum("montant");
    $sum_payer = Rapport::where("ligne_rapport_id",$ligneRapport->id)->sum("payer");
    $sum_reste = Rapport::where("ligne_rapport_id",$ligneRapport->id)->sum("reste");
    $ligneRapport->update([
      "montant_achat" => $sum_ttc,
      "payer_achat"   => $sum_payer,
      "reste_achat"   => $sum_reste,
    ]);
  }


  /**
   * Display the specified resource.
   *
   * @param  \App\Models\LigneAchat  $ligneAchat
   * @return \Illuminate\Http\Response
   */
  public function show(LigneAchat $ligneAchat)
  {
    $paiements = $ligneAchat->paiements()->get();
    $achats    = $ligneAchat->achats()->get();
    $all = [
      "ligneAchat" => $ligneAchat,
      "paiements"  => $paiements,
      "achats"     => $achats,
    ];
    return view("ligneAchats.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\LigneAchat  $ligneAchat
   * @return \Illuminate\Http\Response
   */
  public function edit(LigneAchat $ligneAchat)
  {
    if($ligneAchat->statut == "validé")
    {
      toast("L'achat a été validé" , "success");
      return back();
    }
    elseif($ligneAchat->fournisseur->deleted_at != null)
    {
      toast("Un fournisseur pour ces achats a été supprimé.","warning");
      return back();
    }
    else
    {
      $pro_ids      = DB::table("achats")->where("ligne_achat_id",$ligneAchat->id)->whereNull("deleted_at")->pluck("produit_id");
      $count_pro    = DB::table("produits")->select("id","reference","designation","prix_achat","deleted_at")->whereNull("deleted_at")->whereNotIn("id",$pro_ids)->count();
      $fournisseurs = DB::table("fournisseurs")->select("id","raison_sociale","deleted_at")->get();
      $tvas         = DB::table("taux_tvas")->pluck("valeur");
      $entreprises  = DB::table("entreprises")->select("id","raison_sociale","deleted_at")->whereNull("deleted_at")->get();

      $all = [
        "ligneAchat"   => $ligneAchat,
        "fournisseurs" => $fournisseurs,
        "entreprises"  => $entreprises,
        "tvas"         => $tvas,
        "count_pro"    => $count_pro,
      ];
      return view("ligneAchats.edit",$all);

    }
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\LigneAchat  $ligneAchat
   * @return \Illuminate\Http\Response
  */
  public function update(Request $request, LigneAchat $ligneAchat)
  {
    $request->validate([
      "fournisseur_id" => ["required"],
      "tva"            => ["required"],
      "date_paiement"     => ["required"],
    ]);
    $ht        = $ligneAchat->ht;
    $tva       = $request->tva;
    $ttc       = $ht  + ($ht * ($tva/100));
    $count_ent = Entreprise::count();
    $ligneAchat->update([
      "fournisseur_id" => $request->fournisseur_id,
      "statut"         => $request->statut,
      "taux_tva"       => $request->tva,
      "ttc"            => $ttc,
      "reste"          => $ttc,
      "date_paiement"          => $request->date_paiement,
      "entreprise_id"  => $count_ent == 1 ? Entreprise::first()->id : $request->entreprise_id,
      "date_achat"     => $request->date_achat == null ? Carbon::now() : $request->date_achat,
    ]);
    Session()->flash("update_achat","");
    toast("La modification du facture effectuée","success");
    return redirect()->route('ligneAchat.index');

  }


  public function checkDepot(Request $request , LigneAchat $ligneAchat)
  {
    if($ligneAchat->statut == "en cours")
    {
      $achats = $ligneAchat->achats()->get();
      foreach($achats as $achat)
      {
        $stock         = Stock::where("produit_id",$achat->produit_id)->first();
        $achat->stock         = Stock::where("produit_id",$achat->produit_id)->first();
        $achat->depots = $stock->depots()->get();
        $check_depot      = StockDepot::where("stock_id",$stock->id)->where("check_default",1)->exists();
        if($check_depot == true)
        {
          $depot_id      = StockDepot::where("stock_id",$stock->id)->where("check_default",1)->first()->depot_id;
          $achat->depot = Depot::find($depot_id);
        }
      }

      $all = [
        "ligneAchat"=>$ligneAchat,
        "achats"=>$achats,
        "check_depot"=>$check_depot
      ];
      return view("ligneAchats.checkDepots",$all);
    }
    else
    {
      toast("L4achat a été validé","success");
      return back();
    }
  }


  public function valider(Request $request , LigneAchat $ligneAchat) {
    $ligneAchat->update([
      "statut"=>"validé",
      "net_payer"=>$ligneAchat->ttc,
      "reste"=>$ligneAchat->ttc,
    ]);

    foreach($request->achat as $k => $val)
    {
      $qte     = $request->quantite[$k];
      $achat   = Achat::find($val);
      $produit = Produit::find($achat->produit_id);
      $stock   = Stock::where("produit_id",$achat->produit_id)->first();
      // update depot
      $depot = null;
      if(isset($request->depot_select))
      {
        $depot = Depot::find($request->depot_select);
      }
      elseif(isset($request->depot_default))
      {
        $depot = Depot::where("num_depot",$request->depot_default)->first();
      }
      else
      {
        return back();
      }
      // update depot
      $depot->update([
        "quantite"   => $depot->quantite + $qte,
        'disponible' => $depot->disponible + $qte,
        'entre'      => $depot->entre + $qte,
      ]);

      // update depot stock
      $stock_depot = StockDepot::where("stock_id",$stock->id)->where("depot_id",$depot->id)->first();
      $stock_depot->update([
        "quantite"   => $stock_depot->quantite + $qte,
        "entre"      => $stock_depot->entre + $qte,
        "disponible" => $stock_depot->disponible + $qte,
      ]);

      // insertion depot suivi
      DepotSuivi::create([
        "stock_depot_id"=>$stock_depot->id,
        "date_suivi"=>Carbon::today(),
        "quantite"=>$qte,
        "operation"=>"achat",
      ]);


      // update stock
      $stock->update([
        "qte_achat"    => $stock->qte_achat + $qte,
        "qte_achatRes" => $stock->qte_achatRes - $qte,
        "disponible"   => $stock->disponible + $qte,
      ]);

      // insertion stock history
      StockHistorique::create([
        "stock_id"       => $stock->id,
        "quantite"       => $qte,
        "date_mouvement" => Carbon::today(),
        "fonction"       => "achat_validé",
      ]);

      $produit->update([
        "quantite" => $produit->quantite + $qte,
      ]);
    }
    Rapport::where("reference",$ligneAchat->num_achat)->update([
      "status"=>$ligneAchat->status,
    ]);
    $this->updateFournisseur($ligneAchat->id);
    toast("L'achat a été confirmé.","success");
    return back();
  }



  public function bon(LigneAchat $ligneAchat){
    $achats      = $ligneAchat->achats()->get();
    $fournisseur = $ligneAchat->fournisseur;
    $entreprise  = $ligneAchat->entreprise;
    $all = [
      "achats"      => $achats,
      "ligneAchat"  => $ligneAchat,
      "reference"   => $ligneAchat->num_achat,
      "fournisseur" => $fournisseur,
      "entreprise"  => $entreprise
    ];
    $pdf = Pdf::loadview('ligneAchats.bonCmd',$all);
    return $pdf->stream("bon commande|" . $ligneAchat->num_achat);
  }

  public function demandePrice(LigneAchat $ligneAchat){
    $achats      = $ligneAchat->achats()->get();
    $fournisseur = $ligneAchat->fournisseur;
    $entreprise  = $ligneAchat->entreprise;
    $all = [
      "achats"      => $achats,
      "entreprise"  => $entreprise,
      "ligneAchat"  => $ligneAchat,
      "fournisseur" => $fournisseur
    ];
      $pdf = Pdf::loadview('ligneAchats.demandePrice',$all);
      return $pdf->stream("demande prix : " . $ligneAchat->num_demande);
  }



  public function updateFournisseur($id){
    $ligneAchat = LigneAchat::find($id);
    $mt_facture = LigneAchat::where("fournisseur_id",$ligneAchat->fournisseur_id)->where("statut","validé")->sum("ttc");
    $sum_payer = LigneAchat::where("fournisseur_id",$ligneAchat->fournisseur_id)->sum("payer");
    $fournisseur = Fournisseur::find($ligneAchat->fournisseur_id);
    $fournisseur->update([
      "montant"         => $mt_facture,
      "reste"           => $mt_facture,
      "payer"           => $sum_payer
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



}
