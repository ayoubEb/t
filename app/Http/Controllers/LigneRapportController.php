<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\LigneRapport;
use App\Models\Rapport;
use App\Models\RapportCrm;
use Illuminate\Http\Request;
use OpenSpout\Common\Entity\Style\Style;
use PDF;
use Rap2hpoutre\FastExcel\FastExcel;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LigneRapportController extends Controller
{
    //

    public function index(){
      $ligneRapports = LigneRapport::all();

      $all = [ "ligneRapports" => $ligneRapports ];
      return view("ligneRapports.index",$all);
    }





    public function show(LigneRapport $ligneRapport){
      $net_payer_ventes = Rapport::where("affecter",'vente')->where("status","validé")->sum("montant");
      $reste_ventes = Rapport::where("affecter",'vente')->where("status","validé")->sum("reste");
      $payer_ventes = Rapport::where("affecter",'vente')->where("status","validé")->sum("payer");
      $count_ventes = Rapport::where("affecter",'vente')->where("status","validé")->count();

      $montant_ventes = Rapport::where("affecter",'vente')->where("status","en cours")->sum("montant");
      $devisReste_ventes = Rapport::where("affecter",'vente')->where("status","en cours")->sum("reste");
      $devisPayer_ventes = Rapport::where("affecter",'vente')->where("status","en cours")->sum("payer");
      $devisCount_ventes = Rapport::where("affecter",'vente')->where("status","en cours")->count();
      $totalCount_ventes = Rapport::where("affecter",'vente')->count();

      $net_payer_achats = Rapport::where("affecter",'achat')->where("status","validé")->sum("montant");
      $reste_achats = Rapport::where("affecter",'achat')->where("status","validé")->sum("reste");
      $payer_achats = Rapport::where("affecter",'achat')->where("status","validé")->sum("payer");
      $count_achats = Rapport::where("affecter",'achat')->where("status","validé")->count();

      $montant_achats = Rapport::where("affecter",'achat')->where("status","en cours")->sum("montant");
      $devisReste_achats = Rapport::where("affecter",'achat')->where("status","en cours")->sum("reste");
      $devisPayer_achats = Rapport::where("affecter",'achat')->where("status","en cours")->sum("payer");
      $devisCount_achats = Rapport::where("affecter",'achat')->where("status","en cours")->count();

      $totalCount_achats = Rapport::where("affecter",'achat')->count();







      $all          = [

        "net_payer_ventes" => $net_payer_ventes,
        "reste_ventes" => $reste_ventes,
        "payer_ventes" => $payer_ventes,
        "count_ventes" => $count_ventes,

        "montant_ventes" => $montant_ventes,
        "devisReste_ventes" => $devisReste_ventes,
        "devisPayer_ventes" => $devisPayer_ventes,
        "devisCount_ventes" => $devisCount_ventes,

        "totalCount_ventes" => $totalCount_ventes,

        "net_payer_achats" => $net_payer_achats,
        "reste_achats" => $reste_achats,
        "payer_achats" => $payer_achats,
        "count_achats" => $count_achats,

        "montant_achats" => $montant_achats,
        "devisReste_achats" => $devisReste_achats,
        "devisPayer_achats" => $devisPayer_achats,
        "devisCount_achats" => $devisCount_achats,

        "totalCount_achats" => $totalCount_achats,

        "ligneRapport" => $ligneRapport,





      ];
      return view("ligneRapports.show",$all);
    }


    public function liste_buySell(){
      $ligneRapports = DB::table("ligne_rapports")->get();
      $all          = [ "ligneRapports" => $ligneRapports ];
      return view("rapportBuySell.index",$all);
    }

    public function buySell($mois = null){
      $ligneRapport_ids = DB::table('ligne_rapports')->where("mois",$mois)->pluck("id");
      $details          = DB::table('rapports')->where('ligne_rapport_id',$ligneRapport_ids)->get();
      $all              =
      [
        "details" => $details,
        "mois"    => $mois,
      ];
      return view("rapportBuySell.show",$all);
    }

    public function documentBuySell($mois){
      $ligneRapport = LigneRapport::where("mois",$mois)->first();
      $rap_id       = $ligneRapport->id;
      $rapports     = Rapport::where("ligne_rapport_id",$rap_id)->get();
      $nbr_rapports = Rapport::where("ligne_rapport_id",$rap_id)->count();
      $all          = [
        "rapports"     => $rapports,
        "mois"         => $mois,
        "ligneRapport" => $ligneRapport,
        "nbr_rapports" => $nbr_rapports,
      ];
      $pdf = PDF::loadview('rapportBuySell.document',$all);
      return $pdf->stream();
    }

    public function exportBuySell($mois)
    {

      $rap_id = LigneRapport::where("mois",$mois)->first()->id;
      $rapports = Rapport::where("ligne_rapport_id",$rap_id)->get();
      $exportData = [];
      $rows_style = null;
      foreach ($rapports as $rapport) {
        $facture = Facture::where("num",$rapport->reference)->first();
        $client = DB::table("clients")->where("id",$facture->client_id)->first();
      $exportData[] = [
        "client" => $client->raison_sociale,
        "référence" => $rapport->reference,
        "montant"   => number_format($rapport->montant , 2 , "," ," " ) . " DHS",
        "payer"     => number_format($rapport->payer , 2 , "," ," " ) . " DHS",
        "reste"     => number_format($rapport->reste , 2 , "," ," " ) . " DHS",
        "date"      => $rapport->jour,
        "status"    => $rapport->status,
        "affecter"  => $rapport->affecter,
        ];
      }
        $header_style = (new Style())
        ->setFontBold()
        ->setFontSize(10)
        ->setBackgroundColor("EDEDED")
        ->setFontItalic()
        ->setCellAlignment("center")
        ->setCellVerticalAlignment("center")
        ->setShouldWrapText(1);

        $rows_style = (new Style())
        ->setFontSize(10)
        ->setCellAlignment("center")
        ->setCellVerticalAlignment("center")
        ->setShouldWrapText(true);
      return (new FastExcel($exportData))
      ->headerStyle($header_style)
      ->rowsStyle($rows_style)
      ->download('achatsVentes_' . $mois . '.xlsx');

    }



    public function ventes(LigneRapport $ligneRapport){
      $details = Rapport::where("ligne_rapport_id",$ligneRapport->id)->where("affecter","vente")->get();
      $all    = [
        "ligneRapport" => $ligneRapport,
        "details" => $details,
      ];
      return view("ligneRapports.ventes",$all);
    }

    public function achats(LigneRapport $ligneRapport){
      $details = Rapport::where("ligne_rapport_id",$ligneRapport->id)->where("affecter","achat")->get();
      $all    = [
        "ligneRapport" => $ligneRapport,
        "details" => $details,
      ];
      return view("ligneRapports.achats",$all);
    }


    public function clients(LigneRapport $ligneRapport){
      $details = RapportCrm::where("ligne_rapport_id",$ligneRapport->id)->where("affecter","client")->get();
      $all    = [
        "ligneRapport" => $ligneRapport,
        "details"      => $details,
      ];
      Session()->flash("cli","");
      return view("ligneRapports.clients",$all);
    }


    public function fournisseurs(LigneRapport $ligneRapport){
      $details = RapportCrm::where("ligne_rapport_id",$ligneRapport->id)->where("affecter","fournisseur")->get();
      $all    = [
        "ligneRapport" => $ligneRapport,
        "details"      => $details,
      ];
      return view("ligneRapports.fournisseurs",$all);
    }






}
