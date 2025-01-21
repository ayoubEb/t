<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AchatPaiement;
use App\Models\Facture;
use App\Models\FacturePaiement;
use App\Models\LigneAchat;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TresorerierController extends Controller
{
  public function planCommande(){
    $mois                  = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

    $month_data = [];
    for($i = 0; $i < 12; $i++) {


      $cmdNetPayer[$i + 1] = Facture::where(DB::raw("MONTH(date_facture)"), $i + 1)->whereYear('date_facture',date('Y'))->sum("net_payer");
      $cmd_ttc[$i + 1]     = Facture::where(DB::raw("MONTH(date_facture)"), $i + 1)->whereYear('date_facture',date('Y'))->sum("ttc");
      $cmd_payer[$i + 1]   = Facture::where(DB::raw("MONTH(date_facture)"), $i + 1)->whereYear('date_facture',date('Y'))->sum("payer");
      $cmd_reste[$i + 1]   = Facture::where(DB::raw("MONTH(date_facture)"), $i + 1)->whereYear('date_facture',date('Y'))->sum("reste");

      $especes[$i + 1]        = FacturePaiement::where(DB::raw("MONTH(date_paiement)"), $i + 1)->whereYear('date_paiement',date('Y'))->where("type_paiement","espèce")->sum("payer");
      $cheque_payer[$i + 1]   = FacturePaiement::where(DB::raw("MONTH(date_paiement)"), $i + 1)->whereYear('date_paiement',date('Y'))->where("type_paiement","chèque")->where("statut","payé")->sum("payer");
      $cheque_impayer[$i + 1] = FacturePaiement::where(DB::raw("MONTH(date_paiement)"), $i + 1)->whereYear('date_paiement',date('Y'))->where("type_paiement","chèque")->where("statut","impayé")->sum("payer");
      $cheques[$i + 1]        = FacturePaiement::where(DB::raw("MONTH(date_paiement)"), $i + 1)->whereYear('date_paiement',date('Y'))->where("type_paiement","chèque")->sum("payer");






      $month_data[$mois[$i]] =$cmd_ttc[$i + 1] // 0
                    . ' - ' . $cmdNetPayer[$i + 1] // 1
                    . ' - ' . $cmd_payer[$i + 1] // 2
                    . ' - ' . $cmd_reste[$i + 1] // 3
                    . ' - ' . $especes[$i + 1] // 4
                    . ' - ' . $cheques[$i + 1] // 5
                    . ' - ' . $cheque_payer[$i + 1] // 6
                    . ' - ' . $cheque_impayer[$i + 1] // 7
                    ;
    }
    $all = [
      // "mois"              => $mois,
      "months"           => $month_data,
    ];
    return view("tresoreries.plan",$all);
  }
  public function commandeDocument(){

    $mois                  = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

    $month_data = [];
    for($i = 0; $i < 12; $i++) {


      $cmdNetPayer[$i + 1] = Facture::where(DB::raw("MONTH(date_facture)"), $i + 1)->whereYear('date_facture',date('Y'))->sum("net_payer");
      $cmd_ttc[$i + 1]     = Facture::where(DB::raw("MONTH(date_facture)"), $i + 1)->whereYear('date_facture',date('Y'))->sum("ttc");
      $cmd_payer[$i + 1]   = Facture::where(DB::raw("MONTH(date_facture)"), $i + 1)->whereYear('date_facture',date('Y'))->sum("payer");
      $cmd_reste[$i + 1]   = Facture::where(DB::raw("MONTH(date_facture)"), $i + 1)->whereYear('date_facture',date('Y'))->sum("reste");

      $especes[$i + 1]        = FacturePaiement::where(DB::raw("MONTH(date_paiement)"), $i + 1)->whereYear('date_paiement',date('Y'))->where("type_paiement","espèce")->sum("payer");
      $cheque_payer[$i + 1]   = FacturePaiement::where(DB::raw("MONTH(date_paiement)"), $i + 1)->whereYear('date_paiement',date('Y'))->where("type_paiement","chèque")->where("statut","payé")->sum("payer");
      $cheque_impayer[$i + 1] = FacturePaiement::where(DB::raw("MONTH(date_paiement)"), $i + 1)->whereYear('date_paiement',date('Y'))->where("type_paiement","chèque")->where("statut","impayé")->sum("payer");
      $cheques[$i + 1]        = FacturePaiement::where(DB::raw("MONTH(date_paiement)"), $i + 1)->whereYear('date_paiement',date('Y'))->where("type_paiement","chèque")->sum("payer");






      $month_data[$mois[$i]] =$cmd_ttc[$i + 1] // 0
                    . ' - ' . $cmdNetPayer[$i + 1] // 1
                    . ' - ' . $cmd_payer[$i + 1] // 2
                    . ' - ' . $cmd_reste[$i + 1] // 3
                    . ' - ' . $especes[$i + 1] // 4
                    . ' - ' . $cheques[$i + 1] // 5
                    . ' - ' . $cheque_payer[$i + 1] // 6
                    . ' - ' . $cheque_impayer[$i + 1] // 7
                    ;
    }
    $all = [
      // "mois"              => $mois,
      "months"           => $month_data,
    ];
    $pdf = Pdf::loadView("tresoreries.docs",$all);
    $pdf->setPaper('a4', 'landscape');
    return $pdf->stream();
  }
}
