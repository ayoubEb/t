<?php

namespace Database\Seeders;

use App\Models\TypeClient;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TypeClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ "nom"=>"Ecole" , "created_at"=>Carbon::now() , "updated_at"=>Carbon::now() ],
            [ "nom"=>"Sociéte" ,"created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
            [ "nom"=>"Hôpital" ,"created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
            [ "nom"=>"Restaurant" ,"created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
            [ "nom"=>"Mosquée" ,"created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
        ];
        TypeClient::insert($data);
    }
}
