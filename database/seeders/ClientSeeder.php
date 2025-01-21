<?php

namespace Database\Seeders;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class ClientSeeder extends Seeder
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
                    "raison_sociale" => "Adam Cooper",
                    "adresse"        => "480 Passage Du Sommerard",
                    "email"          => "alix_aubert@gmail.com",
                    "ville"          => "Limoges",
                    "ice"            => "041689336",
                    "if_client"             => "575287430",
                    "rc"             => "041689336",
                    "telephone"      => '6454544833',
                    "code_postal"    => 12600,
                    "identifiant"=>Str::upper(Str::random(8)),
                    "moisCreation"=>date("m-Y"),
                    "dateCreation"=>Carbon::now(),
                    "created_at"=>Carbon::now(),
                    "updated_at"=>Carbon::now(),
                  ],
                  [
                    "raison_sociale"=>"AYOUB",
                    "adresse"=>"10 Voie Vaneau - Pau",
                    "email"=>"melchiormoulin.pierre@yahoo.fr",
                    "ville"=>"Yémen",
                    "ice"=>"855123",
                    "if_client"=>"2306855123452",
                    "rc"=>"116123",
                    "telephone"=> '625121415',
                    "code_postal"=>92057,
                    "identifiant"=>Str::upper(Str::random(8)),
                    "moisCreation"=>date("m-Y"),
                    "dateCreation"=>Carbon::now(),
                    "created_at"=>Carbon::now(),
                    "updated_at"=>Carbon::now(),
                    ],
                ];
        Client::insert($data);
    }
}
