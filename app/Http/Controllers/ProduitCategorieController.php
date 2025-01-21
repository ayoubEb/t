<?php

namespace App\Http\Controllers;

use App\Models\ProduitCategorie;
use Illuminate\Http\Request;

class ProduitCategorieController extends Controller
{

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // $request->validate([
    //   "categories"=>['required'],
    // ]);
    if(isset($request->categories))
    {
      foreach($request->categories as $k => $val)
      {
        ProduitCategorie::create([
          "produit_id"=>$request->pro,
          "categorie_id"=>$val,
        ]);

      }

    }
    // $array = [];
    // foreach ($request->categorie as $key => $value) {
    //     $cat_check = ProduitCategorie::where("categorie_id",$request->categorie[$key])->exists();
    //       if($cat_check == false){
    //         ProduitCategorie::create([
    //           "produit_id"   => $request->produit,
    //           "categorie_id" => $request->categorie[$key],
    //         ]);
    //       }
    //     $array[]= $request->categorie[$key];
    // }

    // if(ProduitCategorie::where("categorie_id",$array)->exists()){
    //     toast("S'il voûs plaît les catégorie sélectionner déja existe","warning");
    // }
    // else{
    //   }
    toast("L'enregistrement du catégorie de produit effectuée","success");
    return back();
  }




  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\ProduitCategorie  $produitCategorie
   * @return \Illuminate\Http\Response
   */
  public function destroy($proCategorie_id)
  {
    // dd($proCategorie);
    $produitCategorie = ProduitCategorie::find($proCategorie_id);
    $produitCategorie->delete();
    toast("La déplacement du corbeille du catégorie effectuée","success");
    return back();
  }
}
