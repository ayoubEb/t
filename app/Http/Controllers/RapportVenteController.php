<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Facture;
use App\Models\LigneRapport;
use App\Models\Rapport;
use Illuminate\Support\Facades\DB;
use OpenSpout\Common\Entity\Style\Style;
use PDF;
use Rap2hpoutre\FastExcel\FastExcel;
class RapportVenteController extends Controller
{
  public function documentVente($mois){
    $ligneRapport = LigneRapport::where("mois",$mois)->first();
    $rap_id = $ligneRapport->id;
    $rapports = Rapport::where("ligne_rapport_id",$rap_id)->where("affecter","vente")->get();
    $nbr_rapports = Rapport::where("ligne_rapport_id",$rap_id)->where("affecter","vente")->count();
    $sum_devis = Rapport::where("ligne_rapport_id",$rap_id)->where("affecter","vente")->where("status","en cours")->sum("montant");
    $sum_factures = Rapport::where("ligne_rapport_id",$rap_id)->where("affecter","vente")->where("status","validé")->sum("montant");
    $montant_vente = $ligneRapport->montant_vente;
    $payer_vente   = $ligneRapport->paye_vente;
    $reste_vente   = $ligneRapport->reste_vente;
    $all    = [
      "rapports" => $rapports,
      "mois"    => $mois,
      "sum_devis"    => $sum_devis,
      "sum_factures"    => $sum_factures,
      "payer_vente" => $payer_vente,
      "montant_vente" => $montant_vente,
      "reste_vente" => $reste_vente,
      "nbr_rapports"      => $nbr_rapports,
      "ligneRapport"    => $ligneRapport,
    ];
    $pdf = PDF::loadview('rapportVentes.document',$all);
    return $pdf->stream();
  }

  // public function documentMensuel($mois){
  //   $ligneRapport = LigneRapport::where("mois",$mois)->first();
  //   $rap_id = $ligneRapport->id;
  //   $rapports = DB::table('rapports')
  //   ->select("jour")
  //   ->where("ligne_rapport_id",$rap_id)
  //   ->groupBy("jour")
  //   ->where("affecter","vente")
  //   ->selectRaw('sum(montant) as sum_mt')
  //   ->selectRaw('sum(payer) as sum_payer')
  //   ->selectRaw('sum(reste) as sum_reste')
  //   ->get();
  //   foreach($rapports as $rapport)
  //   {
  //     $facture = Facture::where("date_facture",$rapport->jour)
  //     ->selectRaw('sum(qteProduits) as qteProduits')
  //     ->selectRaw('sum(qteRetours) as qteRetours')
  //     ->selectRaw('sum(nbrProduits) as nbrProduits')
  //     ->selectRaw('sum(nbrRetours) as nbrRetours')
  //     ->selectRaw('sum(net_credit) as sum_credit')
  //     ->first();
  //     $rapport->credit = $facture->sum_credit;
  //     $rapport->qteProduits = $facture->qteProduits;
  //     $rapport->qteRetours = $facture->qteRetours;
  //     $rapport->nbrProduits = $facture->nbrProduits;
  //     $rapport->nbrRetours = $facture->nbrRetours;
  //   }



  //   $nbr_rapports = Rapport::where("ligne_rapport_id",$rap_id)->where("affecter","vente")->count();
  //   $montant_vente = $ligneRapport->montant_vente;
  //   $payer_vente   = $ligneRapport->paye_vente;
  //   $reste_vente   = $ligneRapport->reste_vente;

  //   $all    = [
  //     "rapports" => $rapports,
  //     "mois"    => $mois,
  //     "payer_vente" => $payer_vente,
  //     "montant_vente" => $montant_vente,
  //     "reste_vente" => $reste_vente,
  //     "nbr_rapports"      => $nbr_rapports,
  //     "ligneRapport"    => $ligneRapport,
  //   ];
  //   $pdf = PDF::loadview('rapportVentes.docMensuel',$all);
  //   return $pdf->stream();
  // }

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
    $pdf = PDF::loadview('rapportVentes.docDay',$all);
    return $pdf->stream();
  }

  public function exportVentes($mois)
  {

    $rap_id     = LigneRapport::where("mois",$mois)->first()->id;
    $rapports   = Rapport::where("ligne_rapport_id",$rap_id)->where("affecter","Vente")->get();
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
      ->setFontItalic();

      $rows_style = (new Style())
      ->setFontSize(10)
      ->setShouldWrapText();
    return (new FastExcel($exportData))
    ->headerStyle($header_style)
    ->rowsStyle($rows_style)
    ->download('ventes_' . $mois . '.xlsx');
  }


}
