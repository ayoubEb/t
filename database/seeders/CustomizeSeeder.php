<?php

namespace Database\Seeders;

use App\Models\Customize;
use Illuminate\Database\Seeder;

class CustomizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $data = [
        [
          "champ" => "num_devis",
          "num"   => "devis-",
          "affecter"=>"vente",
        ],
        [
          "champ" => "num_facture",
          "num"   => "fac-",
          "affecter"=>"vente",
        ],
        [
          "champ" => "num_preforma",
          "num"   => "facpre-",
          "affecter"=>"vente",
        ],
        [
          "champ" => "num_avoire",
          "num"   => "av-",
          "affecter"=>"vente",
        ],
        [
          "champ" => "num_livraison",
          "num"   => "bl-",
          "affecter"=>"vente",
        ],
      ];
      Customize::insert($data);
    }
}
