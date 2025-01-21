<?php

namespace App\Http\Controllers;

use App\Models\CustomizeReference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomizeVenteController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $liste_devis = DB::table("customize_references")->select("affecter" ,"champ","valeur","check_exists","id")->where("operation","vente")->where("affecter","devis")->get();
    $preformas   = DB::table("customize_references")->select("affecter" ,"champ","valeur","check_exists","id")->where("operation","vente")->where("affecter","preforma")->get();
    $commandes   = DB::table("customize_references")->select("affecter" ,"champ","valeur","check_exists","id")->where("operation","vente")->where("affecter","commande")->get();
    $livraisons  = DB::table("customize_references")->select("affecter" ,"champ","valeur","check_exists","id")->where("operation","vente")->where("affecter","livraison")->get();
    $avoires     = DB::table("customize_references")->select("affecter" ,"champ","valeur","check_exists","id")->where("operation","vente")->where("affecter","avoire")->get();
    $count       = DB::table("customize_references")->where("operation","vente")->count();
    $all = [
      "liste_devis" => $liste_devis,
      "preformas"   => $preformas,
      "commandes"   => $commandes,
      "livraisons"  => $livraisons,
      "avoires"     => $avoires,
      "count"       => $count,
    ];
    return view("customizesVentes.references",$all);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function default()
  {
    $this->def_devis();
    $this->def_preformas();
    $this->def_commandes();
    $this->def_livraison();
    $this->bon_livraison();
    $this->def_avoire();
    $this->def_facture();
    return back();
  }

  public function updateReferences(Request $request){
    foreach($request->ids as $key => $val){
      CustomizeReference::where("id",$val)->update([
        "valeur"=>$request->valeur[$key],
      ]);
    }
    return back();
  }

  public function def_devis(){
    $data = [
      [
        "champ"        => "num_devis",
        "valeur"       => "DEV",
        "check_exists" => 1,
        "affecter"     => "devis",
        "operation"    => "vente",
      ],
      [
        "champ"        => "séparateur",
        "valeur"       => "-",
        "check_exists" => 1,
        "affecter"     => "devis",
        "operation"    => "vente",
      ],
      [
        "champ"        => "nombre_zero",
        "valeur"       => 5,
        "check_exists" => 1,
        "affecter"     => "devis",
        "operation"    => "vente",
      ],

      [
        "champ"        => "counter",
        "valeur"       => "1",
        "check_exists" => 1,
        "affecter"     => "devis",
        "operation"    => "vente",
      ],
    ];
    return CustomizeReference::insert($data);
  }

  public function def_preformas(){
    $data = [
      [
        "champ"        => "num_preforma",
        "valeur"       => "FPE",
        "check_exists" => 1,
        "affecter"     => "preforma",
        "operation"    => "vente",
      ],
      [
        "champ"        => "séparateur",
        "valeur"       => "-",
        "check_exists" => 1,
        "affecter"     => "preforma",
        "operation"    => "vente",
      ],
      [
        "champ"        => "nombre_zero",
        "valeur"       => 5,
        "check_exists" => 1,
        "affecter"     => "preforma",
        "operation"    => "vente",
      ],

      [
        "champ"        => "counter",
        "valeur"       => "1",
        "check_exists" => 1,
        "affecter"     => "preforma",
        "operation"    => "vente",
      ],
    ];
    return CustomizeReference::insert($data);
  }

  public function def_commandes(){
    $data = [
      [
        "champ"        => "num_commande",
        "valeur"       => "CMD",
        "check_exists" => 1,
        "affecter"     => "commande",
        "operation"    => "vente",
      ],
      [
        "champ"        => "séparateur",
        "valeur"       => "-",
        "check_exists" => 1,
        "affecter"     => "commande",
        "operation"    => "vente",
      ],
      [
        "champ"        => "nombre_zero",
        "valeur"       => 5,
        "check_exists" => 1,
        "affecter"     => "commande",
        "operation"    => "vente",
      ],

      [
        "champ"        => "counter",
        "valeur"       => "1",
        "check_exists" => 1,
        "affecter"     => "commande",
        "operation"    => "vente",
      ],
    ];
    return CustomizeReference::insert($data);
  }

  public function def_livraison(){
    $data = [
      [
        "champ"        => "num_livraison",
        "valeur"       => "BL",
        "check_exists" => 1,
        "affecter"     => "livraison",
        "operation"    => "vente",
      ],
      [
        "champ"        => "séparateur",
        "valeur"       => "-",
        "check_exists" => 1,
        "affecter"     => "livraison",
        "operation"    => "vente",
      ],
      [
        "champ"        => "nombre_zero",
        "valeur"       => 5,
        "check_exists" => 1,
        "affecter"     => "livraison",
        "operation"    => "vente",
      ],

      [
        "champ"        => "counter",
        "valeur"       => "1",
        "check_exists" => 1,
        "affecter"     => "livraison",
        "operation"    => "vente",
      ],
    ];
    return CustomizeReference::insert($data);
  }

  public function bon_livraison(){
    $data = [
      [
        "champ"        => "num_bon",
        "valeur"       => "CMDBL",
        "check_exists" => 1,
        "affecter"     => "bon_livraison",
        "operation"    => "vente",
      ],
      [
        "champ"        => "séparateur",
        "valeur"       => "-",
        "check_exists" => 1,
        "affecter"     => "bon_livraison",
        "operation"    => "vente",
      ],
      [
        "champ"        => "nombre_zero",
        "valeur"       => 5,
        "check_exists" => 1,
        "affecter"     => "bon_livraison",
        "operation"    => "vente",
      ],

      [
        "champ"        => "counter",
        "valeur"       => "1",
        "check_exists" => 1,
        "affecter"     => "bon_livraison",
        "operation"    => "vente",
      ],
    ];
    return CustomizeReference::insert($data);
  }

  public function def_avoire(){
    $data = [
      [
        "champ"        => "num_avoire",
        "valeur"       => "AVO",
        "check_exists" => 1,
        "affecter"     => "avoire",
        "operation"    => "vente",
      ],
      [
        "champ"        => "séparateur",
        "valeur"       => "-",
        "check_exists" => 1,
        "affecter"     => "avoire",
        "operation"    => "vente",
      ],
      [
        "champ"        => "nombre_zero",
        "valeur"       => 5,
        "check_exists" => 1,
        "affecter"     => "avoire",
        "operation"    => "vente",
      ],

      [
        "champ"        => "counter",
        "valeur"       => "1",
        "check_exists" => 1,
        "affecter"     => "avoire",
        "operation"    => "vente",
      ],
    ];
    return CustomizeReference::insert($data);
  }

  public function def_facture(){
    $data = [
      [
        "champ"        => "num_facture",
        "valeur"       => "BFAC",
        "check_exists" => 1,
        "affecter"     => "facture",
        "operation"    => "vente",
      ],
      [
        "champ"        => "séparateur",
        "valeur"       => "-",
        "check_exists" => 1,
        "affecter"     => "facture",
        "operation"    => "vente",
      ],
      [
        "champ"        => "nombre_zero",
        "valeur"       => 5,
        "check_exists" => 1,
        "affecter"     => "facture",
        "operation"    => "vente",
      ],

      [
        "champ"        => "counter",
        "valeur"       => "1",
        "check_exists" => 1,
        "affecter"     => "facture",
        "operation"    => "vente",
      ],
    ];
    return CustomizeReference::insert($data);
  }

}
