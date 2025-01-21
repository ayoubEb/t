<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\FactureProduit;
use App\Models\ProduitCategorie;
use App\Models\ProduitSousCategorie;
use App\Models\SousCategorie;
use App\Models\Stock;
use App\Models\StockHistorique;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\Activitylog\Models\Activity;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProduitsExample;
use App\Imports\ProduitsImport;
class ProduitController extends Controller
{

  function __construct()
  {
    $this->middleware('permission:produit-list|produit-nouveau|produit-modification|produit-suppression', ['only' => ['index','show']]);

    $this->middleware('permission:produit-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:produit-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:produit-suppression', ['only' => ['destroy']]);

    $this->middleware('permission:produit-display', ['only' => ['show']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $produits = Produit::select("id","designation","reference","prix_vente","prix_revient","prix_achat","statut","quantite","statut","check_stock")->get();
    foreach($produits as $produit){
      if(isset($produit->stock)){
        $produit->disponible = $produit->stock->disponible;
        $produit->qte_alert  = $produit->stock->qte_alert;
      }
      else
      {
        $produit->disponible = 0;
        $produit->qte_alert  = 0;

      }

    }
    $all      = [ 'produits'=>$produits ];
    return view('produits.index',$all);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $categories       = DB::table("categories")->select('id','nom')->whereNull("deleted_at")->get();
    foreach($categories as $categorie){
      $categorie->sous = DB::table("sous_categories")->where("categorie_id",$categorie->id)->get();
    }
    // $sous_categories  = DB::table("sous_categories")->select('id','nom')->whereNull("deleted_at")->get();
    $all = [
        "categories"       => $categories,
        // "sous_categories"  => $sous_categories,
    ];
    return view("produits.create",$all);
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

      "designation"  => ["required"],
      "categorie"    => ["nullable","exists:categories,id"],
      "prix_vente"   => ["required","numeric","min:0"],
      "prix_achat"   => ["nullable","numeric","min:0"],
      "prix_revient" => ["nullable","numeric","min:0"],

    ]);
    if($request->reference != null)
    {
      $request->validate([
        "reference"    => ["required","unique:produits,reference"],
      ]);
      $reference = $request->reference;
    }
    else
    {
      $count_pro = DB::table("produits")->count();
      $reference = "PRO-0" . ($count_pro + 1);
    }
    if($request->hasFile("img")){
      $destination_path = 'public/images/produits/';
      $image_produit    = $request->file("img");
      $filename         = $image_produit->getClientOriginalName();
      $resu             = $filename;
      $request->file("img")->storeAs($destination_path,$filename);
    }
    if($request->hasFile("file")){
      $destination_path = 'public/files/produits/';
      $image_produit    = $request->file("file");
      $filename         = $image_produit->getClientOriginalName();
      $file_ex           = DB::table("produit_fiches")->where("title",$filename)->exists();
      $c                = DB::table("produit_fiches")->where("title",$filename)->count();
      $resu             = $filename;
      if($file_ex == true)
      {
        $resu = $filename.'( ' . $c + 1 . ')';
        $request->file("file")->storeAs($destination_path,$filename .'( ' . $c + 1 . ')');
      }
      else
      {
        $resu = $filename;
        $request->file("file")->storeAs($destination_path,$filename);

      }
    }
    $produit = Produit::create([
      "image"        => $resu ?? "",
      "reference"    => $reference,
      "designation"  => Str::upper($request->designation),
      "description"  => $request->description,
      "prix_vente"   => $request->prix_vente,
      "prix_achat"   => $request->prix_achat,
      "quantite"     => 0,
      "statut"       => 1,
    ]);
    if(isset($request->sous))
    {
      foreach($request->sous as $k => $row){
        SousCategorie::where("id",$row)->first();
        ProduitSousCategorie::create([
            "sous_categorie_id"=>$row,
            "produit_id"=>$produit->id,

        ]);
      }
    }

    if(isset($request->categorie))
    {
      foreach($request->categorie as $k => $row){
        ProduitCategorie::create([
          "produit_id"   => $produit->id,
          "categorie_id" => $row,
        ]);
      }
    }





      toast("L'enregistrement du produit effectuée","success");
      return redirect()->route('produit.index');


  }


  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Produit  $produit
   * @return \Illuminate\Http\Response
   */
  public function show(Produit $produit)
  {

    $count_ventes      = $produit->ventes()->count();
    $categories = $produit->categories()->get();
    $sous_categories = $produit->sous_categories()->get();
    $count_days            = Carbon::now()->daysInMonth;
    $days                  = [];
    $valuesCommande        = [];
    $valuesCommandeQte     = [];
    $valuesAchat           = [];
    $valuesCommandeMontant = [];

      $produit_suivi = $produit->activities()->get();
      foreach($produit_suivi as $pro_suivi){
        $user_check = User::where("id",$pro_suivi->causer_id)->exists();
        if($user_check == true){
          $pro_suivi->user = User::find($pro_suivi->causer_id)->first()->name;
        }
      }

    // for($i = 1; $i <= $count_days; $i++) {
    for($i = 1; $i <= $count_days; $i++) {
      array_push($days, $i);
      $valuesCommande[$i]        = FactureProduit::where("produit_id",$produit->id)->where(DB::raw("Day(created_at)"), $i)->whereYear('created_at',date('Y'))->count();
      $valuesCommandeMontant[$i] = FactureProduit::where("produit_id",$produit->id)->where(DB::raw("Day(created_at)"), $i)->whereYear('created_at',date('Y'))->sum("montant");
      $valuesCommandeQte[$i]     = FactureProduit::where("produit_id",$produit->id)->where(DB::raw("Day(created_at)"), $i)->whereYear('created_at',date('Y'))->sum("quantite");

      $valuesAchat[$i]        = Achat::where("produit_id",$produit->id)->where(DB::raw("Day(created_at)"), $i)->whereYear('created_at',date('Y'))->count();
      $valuesAchatMontant[$i] = Achat::where("produit_id",$produit->id)->where(DB::raw("Day(created_at)"), $i)->whereYear('created_at',date('Y'))->sum("montant");
      $valuesAchatQte[$i]     = Achat::where("produit_id",$produit->id)->where(DB::raw("Day(created_at)"), $i)->whereYear('created_at',date('Y'))->sum("quantite");
    }

    $all = [
      "produit"           => $produit,
      "count_ventes"      => $count_ventes,
      "categories" => $categories,
      "sous_categories" => $sous_categories,
      "produit_suivi" => $produit_suivi,
      "days"              => $days,
      "day_cmd"           => $valuesCommande,
      "montant_cmd"       => $valuesCommandeMontant,
      "qte_cmd"           => $valuesCommandeQte,
      "qte_achat"         => $valuesAchatQte,
      "day_achat"         => $valuesAchat,
      "montant_achat"     => $valuesAchatMontant,
    ];

    return view("produits.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\produit  $produit
   * @return \Illuminate\Http\Response
   */
  public function edit(Produit $produit)
  {
    $categories       = DB::table("categories")->whereNull("deleted_at")->get();
    $sousCategories   = SousCategorie::all();
    $proCategorie     = DB::table("produit_categories")->where("produit_id",$produit->id)->pluck("categorie_id")->all();
    $proSousCategorie = DB::table("produit_sous_categories")->where("produit_id",$produit->id)->pluck("sous_categorie_id")->all();
    $all = [
        "produit"          => $produit,
        "categories"       => $categories,
        "proCategorie"     => $proCategorie,
        "sousCategories"   => $sousCategories,
        "proSousCategorie" => $proSousCategorie,
    ];
    return view("produits.edit",$all);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Produit  $produit
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Produit $produit)
  {
    $request->validate([
      'reference' => [
        "required",
        Rule::unique('produits', 'reference')->ignore($produit->id),
      ],
      "designation" => ["required"],
      "prix_vente"  => ["required","min:0","numeric"],
      "prix_achat"  => ["nullable","min:0","numeric"],
    ]);

    if (File::exists(storage_path().'/app/public/images/produits/'.$produit->image)) {
      File::delete(storage_path().'/app/public/images/produits/'.$produit->image);
    }

    if($request->hasFile("img"))
    {
      $destination_path_produit = 'public/images/produits';
      $image_produit            = $request->file("img");
      $img_produit              = $image_produit->getClientOriginalName();
      $request->file("img")->storeAs($destination_path_produit,$img_produit);
    }


      $produit->update([
        "image"        => $img_produit ?? $produit->image,
        "reference"    => $request->reference,
        "designation"  => Str::upper($request->designation),
        "description"  => $request->description,
        "prix_vente"   => $request->prix_vente,
        "prix_achat"   => $request->prix_achat,
        "statut"       => 1,
      ]);
      if(isset($request->categorie))
      {
        $produit->categories()->detach();
        foreach($request->categorie as $k => $val){
          $proCategorie_exsits = ProduitCategorie::where("categorie_id",$request->categorie[$k])->exists();
          if($proCategorie_exsits == false){
            ProduitCategorie::create([
              "produit_id"   => $produit->id,
              "categorie_id" => $request->categorie[$k],
            ]);
          }
        }
      }
      if(isset($request->sous))
      {
        $produit->sous_categories()->detach();
        foreach($request->sous as $k => $val){
          $proCategorie_exsits = ProduitSousCategorie::where("sous_categorie_id",$val)->exists();
          if($proCategorie_exsits == false){
            ProduitSousCategorie::create([
              "produit_id"        => $produit->id,
              "sous_categorie_id" => $val,
            ]);
          }
        }
      }

      toast("La modification du produit effectuée","success");
      return redirect()->route('produit.index');

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Produit  $produit
   * @return \Illuminate\Http\Response
   */
  public function destroy(Produit $produit)
  {
    $produit->categories()->detach();
    $produit->sous_categories()->detach();
    $produit->delete();
      toast("La déplacement du corbeille du produit effectuée","success");
      if (File::exists(storage_path().'/app/public/images/produits/'.$produit->image)) {
          File::delete(storage_path().'/app/public/images/produits/'.$produit->image);
      }
      toast("La suppression du produit effectuée","success");
      return redirect()->route('produit.index');
  }




    public function example(){
        $data = [
          ['DésignationX' , "descriptionX" , "0","0"],
          ['DésignationY' , "descriptionY" , "0","0"],
          ['DésignationZ' , "descriptionZ" , "0","0"],
        ];
        return Excel::download(new ProduitsExample($data), 'example_produits.xlsx');
    }


  public function import( Request $request )
  {
    $import = new ProduitsImport();
    Excel::import($import, $request->file);

    // Access rows from the import class
    $rows = $import->rows;
 
    foreach($rows as $row)
    {
      $count_stock = DB::table('stocks')->count() + 1;
      $stock = Stock::create([
        "produit_id"=>$row['pro_id'],
        "num"=>"STO-00" . $count_stock,
        "disponible"=>$row["qte"],
        "created_at"=>Carbon::today(),
        "updated_at"=>Carbon::today(),
      ]);
      
      
      StockHistorique::create([
          "stock_id"=>$stock->id,
          'fonction'=>'initial',
          "quantite"=>$row["qte"],
          "date_mouvement"=>Carbon::today(),
          "created_at"=>Carbon::today(),
          "updated_at"=>Carbon::today(),
      ]);
    }
    return back()->with("success","L'importation de file excel effectuée");
  }

}




