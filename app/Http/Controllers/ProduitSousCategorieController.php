<?php

namespace App\Http\Controllers;

use App\Models\ProduitSousCategorie;
use Illuminate\Http\Request;

class ProduitSousCategorieController extends Controller
{
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if(isset($request->sousCategorie))
    {
      foreach($request->sousCategorie as $k => $val)
      {
        ProduitSousCategorie::create([
          "produit_id"        => $request->pro,
          "sous_categorie_id" => $val,
        ]);

      }

    }
    toast("L'enregistrement des sous-catégorie du produit effectuée","success");
    return back();
  }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProduitSousCategorie  $produitSousCategorie
     * @return \Illuminate\Http\Response
     */
    public function destroy($proSouCategorie)
    {
      // dd($proCategorie);
      $produitSouCategororie = ProduitSousCategorie::find($proSouCategorie);
      $produitSouCategororie->delete();
      toast("La déplacement du corbeille du catégorie effectuée","success");
      return back();
    }
}
