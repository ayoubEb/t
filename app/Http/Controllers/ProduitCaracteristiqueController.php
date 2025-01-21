<?php

namespace App\Http\Controllers;

use App\Models\Caracteristique;
use App\Models\Produit;
use App\Models\ProduitCaracteristique;
use App\Models\StockAttribut;
use App\Models\StockAttributHistorique;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProduitCaracteristiqueController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      foreach($request->attr as $k => $row){
        $attr_id = Caracteristique::where("nom",$request->attr)->first()->id;
        $pro_cat = ProduitCaracteristique::create([
        "produit_id"         => $request->pro,
        "caracteristique_id" => $attr_id,
        "valeur"             => $request->valeur[$k],
        "prix_vente"         => $request->prix_vente[$k],
        "prix_achat"         => $request->prix_achat[$k],
        "quantite"           => $request->quantite[$k],
        ]);

        $stock_attribut = StockAttribut::create([
          "numero"             => Str::upper(Str::random(5)),
          "produit_caracteristique_id"         => $pro_cat->id,
          "quantite"           => $request->quantite[$k],
          "reste"              => $request->quantite[$k],
          "sortie"             => 0,
          "qte_vente"=>0,
          "qte_achat"=>0,
        ]);
        StockAttributHistorique::create([
          "stock_attribut_id" => $stock_attribut->id,
          "quantite"          => $request->quantite[$k],
          "fonction"          => "initial",
          "date_mouvement"    => Carbon::today(),
        ]);

      }
        toast("L'enregistrement du caractéristique effectuée","success");
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProduitCaracteristique  $produitCaracteristique
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $produitCaracteristique = ProduitCaracteristique::find($id);
        $produitCaracteristique->update([
            "caracteristique_id" => $request->attr_id != null ? $request->attr_id : $produitCaracteristique->caracteristique_id,
            "prix_achat"         => $request->prixAchat,
            "prix_vente"         => $request->prixVente,
            "valeur"             => $request->valeur_u,
            "quantite"           => $request->qte,
        ]);
        $fonc = "modification";
        $this->saveStock($produitCaracteristique->id , $request->qte , $fonc);
        toast("La modification du caractéristique effectuée","success");
        return back();
    }
    public function saveStock($id , $qte , $fonc){
      $produitAttribut = ProduitCaracteristique::find($id);
      $stockAttribut   = StockAttribut::where("produit_caracteristique_id",$produitAttribut->id)->first();
      StockAttributHistorique::create([
        "stock_attribut_id" => $stockAttribut->id,
        "fonction"          => $fonc,
        "quantite"          => $qte,
        "date_mouvement"    => Carbon::today(),
      ]);
      if($fonc == "modification")
      {
        $qte_previous = $stockAttribut->quantite - $produitAttribut->quantite;
        $stockAttribut->update([
          "quantite" => $qte_previous + $qte,
          "reste"    => ( $qte_previous + $qte ) - $stockAttribut->initial,
        ]);
      }
      else if($fonc == "suppression"){
        $qte_new = $stockAttribut->quantite - $qte;
        $stockAttribut->update([
          "quantite" => $qte_new,
          "reste"    => $qte_new - $stockAttribut->sortie,
        ]);

      }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProduitCaracteristique  $produitCaracteristique
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $produitCaracteristique = ProduitCaracteristique::find($id);
      $qte                    = $produitCaracteristique->quantite;
      $fonc                   = "suppression";
      $this->saveStock($produitCaracteristique->id , $qte , $fonc);
      $produitCaracteristique->delete();

      toast("La déplacement du corbeille du caractéristique effectuée","success");


        return back();

        // $produit_caracteristique->delete();
        // $quantite = ProduitCaracteristique::where("produit_id",$request->produit)->sum("quantite");
        // $produit_caracteristique->produit()->update([
        //     "quantite"=>$quantite,
        // ]);
        // toast("La suppression du caractéristique du produit effectuée","success");
    }
}
