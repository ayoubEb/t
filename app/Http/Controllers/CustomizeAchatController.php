<?php

namespace App\Http\Controllers;

use App\Models\CustomizeReference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomizeAchatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {

      $reference_achats = DB::table("customize_references")->select("affecter" ,"champ","valeur","check_exists","id")->where("operation","achat")->where("affecter","reference_achat")->get();
      $demande_achats   = DB::table("customize_references")->select("affecter" ,"champ","valeur","check_exists","id")->where("operation","achat")->where("affecter","demande")->get();
      $bon_commandes    = DB::table("customize_references")->select("affecter" ,"champ","valeur","check_exists","id")->where("operation","achat")->where("affecter","bon_commande")->get();
      $count            = DB::table("customize_references")->count();
      $all = [
        "reference_achats" => $reference_achats,
        "demande_achats"   => $demande_achats,
        "bon_commandes"    => $bon_commandes,
        "count"            => $count,
      ];
      return view("customizesAchats.references",$all);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function default()
    {
      $this->achat();
      $this->demande();
      $this->bon_commande();
      $this->def_facture();
      return back();
    }

    public function updateReferences(Request $request){
      foreach($request->ids as $key => $val){
        CustomizeReference::where("id",$val)->update([
          "valeur"=>$request->valeur[$key],
          "check_exists"=>$request->check[$key],
        ]);
      }
      return back();
    }

    public function achat(){

      $data = [
        [
          "champ"        => "num_achat",
          "valeur"       => "BCMD",
          "check_exists" => 1,
          "affecter"     => "reference_achat",
          "operation"    => "achat",
        ],
        [
          "champ"        => "séparateur",
          "valeur"       => "-",
          "check_exists" => 1,
          "affecter"     => "reference_achat",
          "operation"    => "achat",
        ],
        [
          "champ"        => "nombre_zero",
          "valeur"       => "5",
          "check_exists" => 1,
          "affecter"     => "reference_achat",
          "operation"    => "achat",
        ],
        [
          "champ"        => "counter",
          "valeur"       => "1",
          "check_exists" => 1,
          "affecter"     => "reference_achat",
          "operation"    => "achat",
        ],
      ];

      return CustomizeReference::insert($data);

    }

    public function demande(){

      $data = [
        [
          "champ"        => "num_demande",
          "valeur"       => "DEM_PA",
          "check_exists" => 1,
          "affecter"     => "demande",
          "operation"    => "achat",
        ],
        [
          "champ"        => "séparateur",
          "valeur"       => "-",
          "check_exists" => 1,
          "affecter"     => "demande",
          "operation"    => "achat",
        ],
        [
          "champ"        => "nombre_zero",
          "valeur"       => 5,
          "check_exists" => 1,
          "affecter"     => "demande",
          "operation"    => "achat",
        ],
        [
          "champ"        => "counter",
          "valeur"       => "1",
          "check_exists" => 1,
          "affecter"     => "demande",
          "operation"    => "achat",
        ],
      ];

      return CustomizeReference::insert($data);

    }

    public function bon_commande(){

      $data = [
        [
          "champ"        => "num_bon_commande",
          "valeur"       => "BCMD",
          "check_exists" => 1,
          "affecter"     => "bon_commande",
          "operation"    => "achat",
        ],
        [
          "champ"        => "séparateur",
          "valeur"       => "-",
          "check_exists" => 1,
          "affecter"     => "bon_commande",
          "operation"    => "achat",
        ],
        [
          "champ"        => "nombre_zero",
          "valeur"       => 5,
          "check_exists" => 1,
          "affecter"     => "bon_commande",
          "operation"    => "achat",
        ],
        [
          "champ"        => "counter",
          "valeur"       => "1",
          "check_exists" => 1,
          "affecter"     => "bon_commande",
          "operation"    => "achat",
        ],
      ];

      return CustomizeReference::insert($data);

    }

    public function def_facture(){
      $data = [
        [
          "champ"        => "num_facture",
          "valeur"       => "ACHAT_FAC-",
          "check_exists" => 1,
          "affecter"     => "facture",
          "operation"    => "achat",
        ],
        [
          "champ"        => "séparateur",
          "valeur"       => "-",
          "check_exists" => 1,
          "affecter"     => "facture",
          "operation"    => "achat",
        ],
        [
          "champ"        => "nombre_zero",
          "valeur"       => 5,
          "check_exists" => 1,
          "affecter"     => "facture",
          "operation"    => "achat",
        ],

        [
          "champ"        => "counter",
          "valeur"       => "1",
          "check_exists" => 1,
          "affecter"     => "facture",
          "operation"    => "achat",
        ],
      ];
      return CustomizeReference::insert($data);
    }
}
