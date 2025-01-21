<?php

namespace Database\Seeders;

use App\Models\Produit;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      for($i = 1 ; $i <= 2 ; $i++)
      {
        Produit::create([
          'reference'    => 'LM-601'.$i,
          'designation'  => 'MICROPHONES',
          'description'  => 'BETA DYNAMIC MICROPHONE',
          'prix_vente'   => 8 . $i,
          'prix_achat'   => 5 . $i,
          'prix_revient' => 4 . $i,
          'prix_vente' => 4 . $i,
          'etat_stock'   => "disponible",
          'check_stock'   => 1,
          'quantite'     => 100,
          'created_at'   => '2023-07-07 20:52:52',
          'updated_at'   => '2023-07-12 14:44:31'
        ]);
    }
 
  }
}
