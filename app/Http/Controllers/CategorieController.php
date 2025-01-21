<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\SousCategorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class CategorieController extends Controller
{

  function __construct()
  {
    // $this->middleware('permission:categorie-list|categorie-nouveau|categorie-modification|categorie-display', ['only' => ['index','show']]);
    $this->middleware('permission:categorie-list', ['only' => 'index']);

    $this->middleware('permission:categorie-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:categorie-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:categorie-suppression', ['only' => 'destroy']);

    $this->middleware('permission:categorie-display', ['only' => 'show']);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $categories = Categorie::select("id","nom","description")->get(); // get all categories
    $all        = [ "categories" => $categories ]; // stock array in all variables before
    return view('categories.index',$all);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view("categories.create");
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
      "nom" => ["required","unique:categories,nom"],
      "img" => ["nullable","unique:categories,image"],
    ]);

    if($request->hasFile("img")){
      $destination_path = 'public/images/category/';
      $image_produit    = $request->file("img");
      $filename         = $image_produit->getClientOriginalName();
      $img_ex           = DB::table("categories")->where("image",$filename)->exists();
      $c                = DB::table("categories")->where("image",$filename)->count();
      $resu             = $filename;
      if($img_ex == true)
      {
        $resu = ($c + 1). '-' . $filename;
        $request->file("img")->storeAs($destination_path,$filename .'( ' . $c + 1 . ')');
      }
      else
      {
        $resu = $filename;
        $request->file("img")->storeAs($destination_path,$filename);

      }
    }
    // start save category
    $categorie = Categorie::create([
      "nom"         => $request->nom,
      "description" => $request->description,
      "image"=>$resu ?? '',
    ]);

    // start save sub ategory
    if(isset($request->nom_sous))
    {
      SousCategorie::create([
        "categorie_id" => $categorie->id,
        "nom"          => $request->nom_sous,
      ]);
    }

    // check multiple enregistrer categroies
    if(isset($request->autre_sous))
    {
      return redirect()->route('categorie.show',["categorie"=>$categorie->id]);
    }
    else{
      toast("L'enregistrement du catégorie effectuée","success");
      return redirect()->route('categorie.index');
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Categorie  $categorie
   * @return \Illuminate\Http\Response
  */
  public function show(Categorie $categorie)
  {
    $sous_categories = $categorie->sous()->get(); // get all sous catégroies
    $all = [
      'categorie'       => $categorie, // get find category
      'sous_categories' => $sous_categories // get all sous category
    ];
    return view("categories.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Categorie  $categorie
   * @return \Illuminate\Http\Response
   */
  public function edit(Categorie $categorie)
  {
      $all = [ 'categorie' => $categorie ];
      return view("categories.edit",$all);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Categorie  $categorie
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Categorie $categorie)
  {
    $request->validate([
      'nom' => [
        "required",
        Rule::unique('categories', 'nom')->ignore($categorie->id),
      ],
    ]);

      File::delete(storage_path().'/app/public/images/category/'.$categorie->image);

      if($request->hasFile("img")){
        $destination_path = 'public/images/category/';
        $image_produit = $request->file("img");
        $filename =  $image_produit->getClientOriginalName();
        $request->file("img")->storeAs($destination_path,$filename);
      }
      $categorie->update([
        "image"=>$filename ?? $categorie->image,
          "nom"         => $request->nom == $categorie->nom ? $categorie->nom : $request->nom,
          "description" => $request->description,
      ]);
      toast("La motification du catégories effectuée","success");
      return redirect()->route('categorie.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Categorie  $categorie
   * @return \Illuminate\Http\Response
   */
  public function destroy(Categorie $categorie)
  {
      SousCategorie::where("categorie_id",$categorie->id)->delete();
      $categorie->delete();
      if (File::exists(storage_path().'/app/public/images/category/'.$categorie->image)) {
        File::delete(storage_path().'/app/public/images/category/'.$categorie->image);
      }
      toast("La suppression du catégorie effectuée","success");
      return back();
  }
}