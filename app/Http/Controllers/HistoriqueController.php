<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AchatPaiement;
use App\Models\Categorie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class HistoriqueController extends Controller
{
    public function index(){
      $client_news = Activity::where("log_name","client")->where("event","created")->count();
      $client_update = Activity::where("log_name","client")->where("event","updated")->count();
      $client_delete = Activity::where("log_name","client")->where("event","deleted")->count();
      return view("historiques.index");
    }
    public function show(){
      $categories = Activity::where("log_name","categorie")->get();
      foreach($categories as $categorie){
        $categorie->user = User::find($categorie->causer_id)->first()->name;
        $categorie->nom = DB::table("categories")->where("id",$categorie->subject_id)->first()->nom;
      }

        $all = [
          "categories"=>$categories,
        ];
        return view("historiques.categories",$all);

    }
    public function groupes(){
      $groupes = Activity::where("log_name","groupe")->get();
      foreach($groupes as $groupe){
        $groupe->user = User::find($groupe->causer_id)->first()->name;
        $groupe->nom = DB::table("groups")->where("id",$groupe->subject_id)->first()->nom;

      }
      $all = [
        "groupes"=>$groupes,
      ];

      return view("historiques.groupes",$all);
    }

    public function entreprises(){
      $entreprises = Activity::where("log_name","entreprise")->get();
      foreach($entreprises as $entreprise){
        $entreprise->user = User::find($entreprise->causer_id)->first()->name;
        $entreprise->nom = DB::table("groups")->where("id",$entreprise->subject_id)->first()->nom;

      }
      $all = [
        "entreprises"=>$entreprises,
      ];

      return view("historiques.entreprises",$all);
    }

    public function typeClients(){
      $typeClients = Activity::where("log_name","type_client")->get();
      foreach($typeClients as $typeClient){
        $typeClient->user = User::find($typeClient->causer_id)->first()->name;
        $typeClient->nom = DB::table("groups")->where("id",$typeClient->subject_id)->first()->nom;

      }
      $all = [
        "typeClients"=>$typeClients,
      ];

      return view("historiques.typeClients",$all);
    }

    public function taux_tva(){
      $taux_tva = Activity::where("log_name","taux_tva")->get();
      foreach($taux_tva as $taux){
        $taux->user = User::find($taux->causer_id)->first()->name;
      }
      $all = [
        "taux_tva"=>$taux_tva,
      ];

      return view("historiques.taux_tva",$all);
    }

    public function livraisons(){
      $livraisons = Activity::where("log_name","livraison")->get();
      foreach($livraisons as $livraison){
        $livraison->user = User::find($livraison->causer_id)->first()->name;
        $livraison->nom = DB::table("livraisons")->where("id",$livraison->subject_id)->first()->libelle;
      }
      $all = [
        "livraisons"=>$livraisons,
      ];

      return view("historiques.livraisons",$all);
    }

    public function clients(){
      $clients = Activity::where("log_name","client")->get();
      foreach($clients as $client){
        $client->user = User::find($client->causer_id)->first()->name;
        $client->nom = DB::table("clients")->where("id",$client->subject_id)->first()->raison_sociale;
      }
      $all = [
        "clients"=>$clients,
      ];
      return view("historiques.clients",$all);
    }

    public function users(){
      $users = Activity::where("log_name","user")->get();
      foreach($users as $user){
        $user->name = User::find($user->causer_id)->first()->name;
        $user->news = DB::table("users")->where("id",$user->subject_id)->first()->name;
      }
      $all = [
        "users"=>$users,
      ];
      return view("historiques.users",$all);
    }

    public function achatPaiements(){
      $achatPaiements = Activity::where("log_name","achat_paiement")->get();
      foreach($achatPaiements as $achatPaiement){
        $achatPaiement->user = User::find($achatPaiement->causer_id)->first()->name;
        $achatPaiement->num = DB::table("achat_paiements")->where("id",$achatPaiement->subject_id)->first()->numero_operation;
      }
      $all = [
        "achatPaiements"=>$achatPaiements,
      ];
      return view("historiques.achatPaiements",$all);
    }

    public function achatCheques(){
      $achatCheques = Activity::where("log_name","achat_cheque")->get();
      foreach($achatCheques as $achatCheque){
        $achatCheque->user = User::find($achatCheque->causer_id)->first()->name;
        $achatCheque->num = DB::table("achat_cheques")->where("id",$achatCheque->subject_id)->first()->numero;
      }
      $all = [
        "achatCheques"=>$achatCheques,
      ];
      return view("historiques.achatCheques",$all);
    }

    public function facturePaiements(){
      $facturePaiements = Activity::where("log_name","facture_paiement")->get();
      foreach($facturePaiements as $facturePaiement){
        $facturePaiement->user = User::find($facturePaiement->causer_id)->first()->name;
        $facturePaiement->num = DB::table("facture_paiements")->where("id",$facturePaiement->subject_id)->first()->numero_operation;
      }
      $all = [
        "facturePaiements"=>$facturePaiements,
      ];
      return view("historiques.facturePaiements",$all);
    }

    public function factureCheques(){
      $factureCheques = Activity::where("log_name","facture_cheque")->get();
      foreach($factureCheques as $factureCheque){
        $factureCheque->user = User::find($factureCheque->causer_id)->first()->name;
        $factureCheque->num = DB::table("facture_paiement_cheques")->where("id",$factureCheque->subject_id)->first()->numero;
      }
      $all = [
        "factureCheques"=>$factureCheques,
      ];
      return view("historiques.factureCheques",$all);
    }

    public function condition_paiements(){
      $conditionPaiements = Activity::where("log_name","condition_paiement")->get();
      foreach($conditionPaiements as $conditionPaiement){
        $conditionPaiement->user = User::find($conditionPaiement->causer_id)->first()->name;
        $conditionPaiement->nom = DB::table("groups")->where("id",$conditionPaiement->subject_id)->first()->nom;

      }
      $all = [
        "conditionPaiements"=>$conditionPaiements,
      ];

      return view("historiques.conditionPaiements",$all);
    }
}
