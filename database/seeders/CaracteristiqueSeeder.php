<?php

namespace Database\Seeders;

use App\Models\Caracteristique;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CaracteristiqueSeeder extends Seeder
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
                "nom"=>"Poids",
                "created_at"=>Carbon::today()
            ],
            [
                "nom"=>"Taille",
                "created_at"=>Carbon::today()
            ],
            [
                "nom"=>"Couleur",
                "created_at"=>Carbon::today()
            ],
            [
                "nom"=>"Marque",
                "created_at"=>Carbon::today()
            ],
            [
                "nom"=>"Matière principale",
                "created_at"=>Carbon::today()
            ],
            [
                "nom"=>"Modèle",
                "created_at"=>Carbon::today()
            ],
        ];

        Caracteristique::insert($data);
    }
}
