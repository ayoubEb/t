<?php

namespace Database\Seeders;

use App\Models\SousCategorie;
use Illuminate\Database\Seeder;

class SousCategorieSeeder extends Seeder
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
                "categorie_id"=>1,
                "nom"=>"Ordinateur",
            ],
            [
                "categorie_id"=>1,
                "nom"=>"écran pc",
            ],
            [
                "categorie_id"=>1,
                "nom"=>"Réseau pc",
            ],
            [
                "categorie_id"=>1,
                "nom"=>"Accessoires pc",
            ],
            [
                "categorie_id"=>1,
                "nom"=>"Composants pc",
            ],
            [
                "categorie_id"=>4,
                "nom"=>"Sport & fitness",
            ],
            [
                "categorie_id"=>5,
                "nom"=>"Cyclisme",
            ],
            [
                "categorie_id"=>5,
                "nom"=>"Top marque",
            ],
            [
                "categorie_id"=>4,
                "nom"=>"Natation",
            ],
            [
                "categorie_id"=>3,
                "nom"=>"Vêtements",
            ],
            [
                "categorie_id"=>2,
                "nom"=>"Football",
            ],
            [
                "categorie_id"=>1,
                "nom"=>"Musculation",
            ],
        ];

        SousCategorie::insert($data);
    }
}
