<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\SousCategorie;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SousCategorieController extends Controller
{

  function __construct()
  {
    $this->middleware('permission:sousCategorie-nouveau', ['only' => ['store']]);

    $this->middleware('permission:sousCategorie-modification', ['only' => ['update']]);

    $this->middleware('permission:sousCategorie-suppression', ['only' => ['destroy']]);
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
      "nom_sous"=>['required','unique:sous_categories,nom'],
    ]);
    SousCategorie::create([
      "categorie_id" => $request->categorie,
      "nom"          => $request->nom_sous,
    ]);
    toast("L'enregistrement du sous catégories effectuée","success");
    return back();
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\SousCategorie  $sousCategorie
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, SousCategorie $sousCategorie)
  {
    $request->validate([
      Rule::unique('sous_categories', 'nom')->ignore($sousCategorie->id),
    ]);
    $sousCategorie->update([
      "nom"=>$request->sous_u,
    ]);
    toast("La motification du sous-catégorie effectuée","success");
    return back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\SousCategorie  $sousCategorie
   * @return \Illuminate\Http\Response
   */
  public function destroy(SousCategorie $sousCategorie,Request $request)
  {
    toast("La suppression sous-catégorie effectuée","success");
    $sousCategorie->delete();
    return back();
  }
}
