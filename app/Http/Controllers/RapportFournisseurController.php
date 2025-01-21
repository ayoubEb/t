<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LigneRapport;
use App\Models\RapportCrm;
use Illuminate\Support\Facades\DB;
use OpenSpout\Common\Entity\Style\Style;
use PDF;
use Rap2hpoutre\FastExcel\FastExcel;

class RapportFournisseurController extends Controller
{
  public function documentClients($mois){
    $ligneRapport  = LigneRapport::where("mois",$mois)->first();
    $rap_id        = $ligneRapport->id;
    $rapports      = RapportCrm::where("ligne_rapport_id",$rap_id)->where("affecter","client")->get();
    $nbr_rapports  = RapportCrm::where("ligne_rapport_id",$rap_id)->where("affecter","client")->count();
    $all    = [
      "rapports"      => $rapports,
      "mois"          => $mois,
      "ligneRapport"          => $ligneRapport,
      "nbr_rapports"  => $nbr_rapports,
    ];
    $pdf = PDF::loadview('rapportClients.document',$all);
    return $pdf->stream();
  }


  public function exportClients($mois)
  {

    $rap_id = LigneRapport::where("mois",$mois)->first()->id;
    $rapports = RapportCrm::where("ligne_rapport_id",$rap_id)->where("affecter","client")->get();
    $exportData = [];
    $rows_style = null;
    foreach ($rapports as $rapport) {

    $exportData[] = [
      "name" => $rapport->name,
      "identifiant" => $rapport->identifiant,
      "montant"   => number_format($rapport->montant , 2 , "," ," " ) . " DHS",
      "payer"     => number_format($rapport->payer , 2 , "," ," " ) . " DHS",
      "reste"     => number_format($rapport->reste , 2 , "," ," " ) . " DHS",
      "date"      => $rapport->jour,
      ];
    }
      $header_style = (new Style())
      ->setFontBold()
      ->setFontSize(11)
      ->setBackgroundColor("EDEDED")
      ->setFontItalic()
      ->setShouldWrapText();

      $rows_style = (new Style())
      ->setFontSize(10)
      ->setShouldWrapText();
    return (new FastExcel($exportData))
    ->headerStyle($header_style)
    ->rowsStyle($rows_style)
    ->download('clients_' . $mois . '.xlsx');

  }

  public function documentDay($mois){
    $ligneRapport = LigneRapport::where("mois",$mois)->first();
    $rap_id       = $ligneRapport->id;
    $rapportsDay = DB::table('rapport_crms')
    ->select("*",DB::raw('DATE(jour) as day'))
    ->where("ligne_rapport_id",$rap_id)
    ->where("affecter","client")
    ->groupBy(DB::raw('DATE(created_at)'))
    ->selectRaw('sum(montant) as sum_mt')
    ->selectRaw('sum(payer) as sum_payer')
    ->selectRaw('sum(reste) as sum_reste')
    ->get();
    $all    = [
      "rapports" => $rapportsDay,
      "mois"        => $mois,
      "ligneRapport"        => $ligneRapport,
    ];
    $pdf = PDF::loadview('rapportClients.docDay',$all);
    return $pdf->stream();
  }
}
