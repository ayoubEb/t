<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LigneRapport;
use App\Models\Rapport;
use Illuminate\Support\Facades\DB;
use OpenSpout\Common\Entity\Style\Style;
use PDF;
use Rap2hpoutre\FastExcel\FastExcel;
class RapportAchatController extends Controller
{
  public function documentAchat($mois){
    $ligneRapport  = LigneRapport::where("mois",$mois)->first();
    $rap_id        = $ligneRapport->id;
    $rapports      = Rapport::where("ligne_rapport_id",$rap_id)->where("affecter","achat")->get();
    $nbr_rapports  = Rapport::where("ligne_rapport_id",$rap_id)->where("affecter","achat")->count();
    $montant_achat = $ligneRapport->montant_achat;
    $payer_achat   = $ligneRapport->paye_achat;
    $reste_achat   = $ligneRapport->reste_achat;
    $all    = [
      "rapports"      => $rapports,
      "mois"          => $mois,
      "ligneRapport"          => $ligneRapport,
      "nbr_rapports"  => $nbr_rapports,
      "montant_achat" => $montant_achat,
      "payer_achat"   => $payer_achat,
      "reste_achat"   => $reste_achat,
    ];
    $pdf = PDF::loadview('rapportAchats.document',$all);
    return $pdf->stream();
  }


  public function exportAchats($mois)
  {

    $rap_id = LigneRapport::where("mois",$mois)->first()->id;
    $rapports = Rapport::where("ligne_rapport_id",$rap_id)->where("affecter","achat")->get();
    $exportData = [];
    $rows_style = null;
    foreach ($rapports as $rapport) {

    $exportData[] = [
      "référence" => $rapport->reference,
      "raison sociale" => $rapport->raison_sociale,
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
    ->download('achats_' . $mois . '.xlsx');

  }

  public function documentDay($mois){
    $ligneRapport = LigneRapport::where("mois",$mois)->first();
    $rap_id       = $ligneRapport->id;
    $rapportsDay = DB::table('rapports')
    ->select("*",DB::raw('DATE(jour) as day'))
    ->where("ligne_rapport_id",$rap_id)
    ->where("affecter","vente")
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
    $pdf = PDF::loadview('rapportAchats.docDay',$all);
    return $pdf->stream();
  }


}
