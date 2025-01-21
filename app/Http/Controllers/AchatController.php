<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Http\Controllers\Controller;
use App\Models\LigneAchat;
use App\Models\LigneRapport;
use App\Models\Rapport;
use App\Models\Stock;
use App\Models\StockHistorique;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class AchatController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add($id)
    {
      $ligneAchat = LigneAchat::find($id);
      $pro_ids  = DB::table("achats")->where("ligne_achat_id",$ligneAchat->id)->whereNull("deleted_at")->pluck("produit_id");
      $produits = DB::table("produits")->select("id","reference","designation","prix_achat","deleted_at")->whereNull("deleted_at")->whereNotIn("id",$pro_ids)->get();
      if($ligneAchat->status == "validé" || count($produits) == 0)
      {
        if($ligneAchat->status == "validé"){
          toast("L'achat a été validé","warning");
          return back();
        }
        else
        {
          toast("Tous les produits se trouvent dans les achats.","success");
          return back();
        }
      }
      else
      {
        $all = [
          "ligneAchat" => $ligneAchat,
          "produits"   => $produits,
        ];
        return view("ligneAchats.newAchat",$all);

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
      $ligne     = LigneAchat::find($request->ligne_id);;
      $first_day = Carbon::createFromFormat('Y-m-d', $ligne->date_achat)->startOfMonth()->toDateString();
      $end_day   = Carbon::createFromFormat('Y-m-d', $ligne->date_achat)->endOfMonth()->toDateString();

      foreach($request->pro as $row => $val)
      {
        $remise_pro = $request->remise[$row] > 0 ? $request->remise[$row] : 0;
        $produit    = DB::table("produits")->where("id",$val)->first();
        $quantite   = $request->quantite[$row] ?? 0;
        $montant    = $quantite * $produit->prix_achat;

        $mt         = $montant * ( 1 - ($remise_pro/100));
        Achat::create([
          "ligne_achat_id" => $ligne->id,
          "produit_id"     => $val,
          "quantite"       => $quantite,
          "remise"         => $remise_pro,
          "montant"        => $mt,
        ]);
        $stock        = DB::table("stocks")->where("produit_id",$produit->id)->exists();
        if($stock == true)
        {
          $stock = DB::table("stocks")->where("produit_id",$produit->id)->first();
          StockHistorique::create([
            "stock_id"       => $stock->id,
            "quantite"       => $quantite,
            "fonction"       => "achat_reserver",
            "date_mouvement" => Carbon::today(),
          ]);
        }
        else
        {
          $stock_new = Stock::create([
            "produit_id" => $produit->id,
            "num"        => Str::upper(Str::random(6)),
            "sortie"     => 0,
            "reste"      => 0,
            "min"        => 0,
            "max"        => 0,
          ]);
          StockHistorique::create([
            "stock_id"       => $stock_new->id,
            "quantite"       => $quantite,
            "fonction"       => "achat_reserver",
            "date_mouvement" => Carbon::today(),
          ]);
        }

      }
        $ht              = DB::table("achats")->where("ligne_achat_id",$ligne->id)->sum("montant");
        $ttc             = $ht  + ($ht * ($ligne->taux_tva/100));
        $ligne->ttc = $ttc;
        $ligne->ht  = $ht;
        $ligne->reste    = $ttc - $ligne->payer;
        $ligne->save();
        $rapport = Rapport::where("reference",$ligne->num_achat)->first();
        $rapport->update([
          "reste"   => $ttc,
          "montant" => $ttc,
        ]);

        $sum_rapport = Rapport::where("ligne_rapport_id",$rapport->ligne_rapport_id)
        ->whereBetween("jour",[$first_day , $end_day])
        ->sum("montant");

        $ligne_rapport = LigneRapport::where("id",$rapport->ligne_rapport_id)->first();
        $ligne_rapport->update([
          "montant_achat"=>$sum_rapport,
          "reste_achat"=>$sum_rapport - $ligne_rapport->payer
        ]);

        toast("L'enregisrtrement des produits effectuée","success");
        Session()->flash("update_pro","");
        return redirect()->route("ligneAchat.edit",["ligneAchat"=>$ligne]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function show(Achat $achat)
    {
        //
    }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Achat  $achat
   * @return \Illuminate\Http\Response
   */
  public function edit(Achat $achat)
  {
    $all = [ "achat" => $achat ];
    return view("achats.edit",$all);
  }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Achat $achat)
    {
      $request->validate([
        "quantite" => ["required","min:1"],
      ]);
      $ph          = DB::table('produits')->where("id",$achat->produit_id)->first()->prix_achat;
      $ligne       = LigneAchat::where("id",$achat->ligne_achat_id)->first();
      // calculer produit
      $montant_remise = ($request->quantite * $ph) * ( 1 - ($request->remise/100));
      $montant        = $request->quantite * $ph;

      // calculer ttc

      $achat->update([
        "quantite" => $request->quantite,
        "remise"   => $request->remise,
        "montant"  => $request->remise == 0 ? $montant : $montant_remise,
      ]);

      $sum_montant = Achat::where("ligne_achat_id",$ligne->id)->sum("montant");
      $ttc = ($sum_montant + ($sum_montant * ($ligne->taux_tva / 100)));
      $ligne->update([
          "ht"  => $sum_montant,
          "ttc" => $ttc,
          "reste"    => $ttc - $ligne->payer,
      ]);


      toast("La motification du produit effectuée","success");
      return redirect()->route("ligneAchat.edit",["ligneAchat"=>$ligne]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Achat $achat)
    {
      $ligne       = LigneAchat::where("id",$achat->ligne_achat_id)->first();
      $sum_montant = Achat::where("ligne_achat_id",$achat->ligne_achat_id)->sum("montant") - $achat->montant;
      $ttc         = $sum_montant + ($sum_montant * ($ligne->taux_tva / 100));
      $ligne->update([
        "ht"  => $sum_montant,
        "ttc" => $ttc,
        "reste"    => $ttc - $ligne->payer
      ]);
      $achat->delete();
      toast("La suppression d'achat effectuée","success");
      return back();
    }
}
