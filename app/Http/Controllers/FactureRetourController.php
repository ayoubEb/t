<?php

namespace App\Http\Controllers;

use App\Models\FactureRetour;
use App\Http\Controllers\Controller;
use App\Models\Facture;
use App\Models\FactureProduit;
use App\Models\LigneFactureRetour;
use App\Models\Stock;
use App\Models\StockHistorique;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FactureRetourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        foreach($request->pro as $k => $val){
            $st = Stock::where("produit_id",$request->pro[$k])->first();
            $facture_pro = FactureProduit::where("produit_id",$request->pro[$k])->first();
            FactureRetour::create([
                "facture_id"=>$request->facture_id,
                "facture_produit_id"=>$facture_pro->id,
                "produit_id"=>$val,
                "montant"=>$request->montant[$k] - $request->mt_reste[$k],
                "qte"=>$request->retour[$k],
                "qte_actuel"=>$request->qte[$k],
                "qte_reste"=>$request->reste[$k],
                "montant_actuel"=>$request->montant[$k],
                "montant_reste"=>$request->mt_reste[$k],
                "date_retour"=>Carbon::today(),
            ]);

            Stock::where("produit_id",$request->pro[$k])->update([
                "reserverRetour"=>$st->reserverRetour + $request->retour[$k],
            ]);
            FactureProduit::where("produit_id",$request->pro[$k])->update([
                "total_retour"=>$facture_pro->total_retour + $request->retour[$k] ,
            ]);
            StockHistorique::where("stock_id",$st->id)->create([
                "stock_id"=>$st->id,
                "fonction"=>"retour",
                "quantite"=>$request->retour[$k],
                "date_mouvement"=>Carbon::today(),
            ]);
        }
        $sum_reste = FactureRetour::where("facture_id",$request->facture_id)->sum("montant_reste");
        $sum_qte = FactureRetour::where("facture_id",$request->facture_id)->sum("qte");
        $tva = Facture::where("id",$request->facture_id)->first()->taux_tva;
        $remise = Facture::where("id",$request->facture_id)->first()->remise;
        Facture::where("id",$request->facture_id)->update([
            "montant_retour"=>$sum_reste,
            "qte_retour"=>$sum_qte,
            "retour"=>"oui",
            "mt_retour_ttc"=>($sum_reste + ($sum_reste * ($tva / 100))) * (1 - ($remise/100)),

        ]);
        toast("L'enregistrement des produits retours effectuée","success");
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FactureRetour  $factureRetour
     * @return \Illuminate\Http\Response
     */
    public function show(FactureRetour $factureRetour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FactureRetour  $factureRetour
     * @return \Illuminate\Http\Response
     */
    public function edit(FactureRetour $factureRetour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FactureRetour  $factureRetour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FactureRetour $factureRetour)
    {



        $factureRetour->update([
            "qte_retour"=>$request->qte,
            "montant"=>$request->montant,
        ]);
        $sum_mt = FactureRetour::where("ligne_facture_retour_id",$factureRetour->ligne->id)->sum("montant");
        $sum_qte = FactureRetour::where("ligne_facture_retour_id",$factureRetour->ligne->id)->sum("qte_retour");
        $ligne = LigneFactureRetour::where("id",$factureRetour->ligne->id)->first();
        $mt_ttc = ($sum_mt + ($sum_mt * ($ligne->facture->taux_tva / 100))) + (1 - $ligne->facture->remise / 100);

        LigneFactureRetour::where("id",$factureRetour->ligne->id)->update([
            "total_qte"=>$sum_qte,
            "montant_ht"=>$sum_mt,
            "montant_ttc"=>$mt_ttc,
        ]);

        $stock = Stock::where("produit_id",$factureRetour->facture_produit->produit_id)->first();
        Stock::where("produit_id",$factureRetour->facture_produit->produit_id)->update([
            "reserverRetour"=>$sum_qte,
        ]);
        StockHistorique::create([
            "stock_id"=>$stock->id,
            "fonction"=>"- retour",
            "date_mouvement"=>Carbon::today(),
            "quantite"=>$request->qte,
        ]);
        toast("La motification du produit retour effectuée","success");
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FactureRetour  $factureRetour
     * @return \Illuminate\Http\Response
     */
    public function destroy(FactureRetour $factureRetour)
    {
        $stock = Stock::where("produit_id",$factureRetour->facture_produit->produit_id)->first();

        $factureRetour->delete();
    //    $ligne =  $factureRetour->ligne->id;
       $total_qte =  $factureRetour->ligne->total_qte;
       $tva =  $factureRetour->ligne->facture->taux_tva;
       $remise =  $factureRetour->ligne->facture->remise;
       $sum_montant = FactureRetour::where("ligne_facture_retour_id",$factureRetour->ligne->id)->sum("montant");
       $factureRetour->ligne->update([
        "total_qte"=>$total_qte - $factureRetour->qte_retour,
        "montant_ht"=>$sum_montant,
        "montant_ttc"=>($sum_montant + ($sum_montant * ($tva / 100))) * (1 - ($remise / 100)),
       ]);

       Stock::where("produit_id",$factureRetour->facture_produit->produit_id)->update([
        "reserverRetour"=>$stock->reserverRetour - $factureRetour->qte_retour,
       ]);
       StockHistorique::create([
        "stock_id"=>$stock->id,
        "fonction"=>"suppression.r",
        "date_mouvement"=>Carbon::today(),
        "quantite"=>$factureRetour->qte_retour,
       ]);

       toast("La suppression du produit retour effectuée","success");
       return back();


    }
}
