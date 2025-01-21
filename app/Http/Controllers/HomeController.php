<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Facture;
use App\Models\LigneAchat;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

      $count_client = Client::count();
      $count_client_today = Client::where("created_at",Carbon::today())->count();

      $count_facture = Facture::count();
      $count_facture_today = Facture::where("created_at",Carbon::today())->count();

      $count_produit = Produit::count();
      $count_produit_today = Produit::where("created_at",Carbon::today())->count();

      $count_stock = Stock::count();
      $count_stock_today = Stock::where("created_at",Carbon::today())->count();






        // liste
        $factures = Facture::select(
            "id",
            "client_id",
            "num",
            "ht",
            "ttc",
            "taux_tva",
            "remise",
            "payer",
            "reste",
            "date_facture"
            )
            ->get();
        $stocks = Stock::select("produit_id","date_stock","qte_alert","disponible","num")->whereColumn("disponible","<","qte_alert")->take(5)->get();
        $stock_count = Stock::select("produit_id","date_stock","qte_alert","disponible","num")->whereColumn("disponible","<","qte_alert")->count();

        return view('home',[
            "count_client"=>$count_client,
            "count_client_today"=>$count_client_today,

            "count_facture"=>$count_facture,
            "count_facture_today"=>$count_facture_today,

            "count_produit"=>$count_produit,
            "count_produit_today"=>$count_produit_today,

            "count_stock"=>$count_stock,
            "count_stock_today"=>$count_stock_today,

            "achat_paiements"=>0,
            "vente_paiements"=>0,
            "count_achatPaiement"=>0,
            "count_ventePaiement"=>0,

            "stocks"=>$stocks,
            "stock_count"=>$stock_count,
            "factures"=>$factures
        ]);
    }
}
