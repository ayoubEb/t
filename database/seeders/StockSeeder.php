<?php

namespace Database\Seeders;

use App\Models\Depot;
use App\Models\DepotSuivi;
use App\Models\Stock;
use App\Models\StockDepot;
use App\Models\StockHistorique;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Activitylog\Models\Activity;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      for($i = 1 ; $i <= 3 ; $i++){
        Stock::create([
          "produit_id" => $i,
          "num"        => "STO00-".$i,
          "initial"    => 1,
          "disponible"     => 100,
          "min"        => 1,
          "qte_alert"=>5,
          "date_stock" => Carbon::now(),
        ]);

        StockHistorique::create([
          "stock_id"=>$i,
          "fonction"=>"initial",
          "quantite"=>100,
          "date_mouvement"=>Carbon::today(),
        ]);
     
      }

    }
}
