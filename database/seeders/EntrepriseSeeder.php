<?php

namespace Database\Seeders;

use App\Models\Entreprise;
use Illuminate\Database\Seeder;

class EntrepriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Entreprise::create([
          "raison_sociale" => "Optima Shop",
          "ice"            => "003165615000042",
          "if"             => "53231510",
          "patente"        => "3481834",
          "rc"             => "560247",
          "site"             => "www.optima.ma",
          "adresse"        => "RUE 152 N°2 HAY MOULAY ABDELLAH - AIN CHOK -",
          "ville"          => "CASABLANCA MAROC",
          "telephone"      => "06 54 95 09 99",
          "fix"            => "05 20 29 99 18",
          "email"          => "optima.shop.import@gmail.com",
          "check_document"=>1,
        ]);

        Entreprise::create([
          "raison_sociale" => "POPKASE",
          "ice"            => "002216401000062",
          "if"             => "33654351",
          "patente"        => "34700795",
          "rc"             => "424341",
          "site"             => "www.optima.ma",
          "adresse"        => "MAGASIN RDC LOTISSEMENT MANAZYL AL MAIMOUN RUE BACHIR ALJ N° 15 - DERB GHALEF",
          "ville"          => "CASABLANCA",
          "telephone"      => "0617077090",
          "fix"            => "0520002767",
          "email"          => "Atc.424143@gmail.com",
          "check_document"=>0,
        ]);
    }
}
