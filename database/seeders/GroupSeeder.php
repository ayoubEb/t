<?php

namespace Database\Seeders;

use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
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
              "nom"=>"Administration",
              "remise"=>10,
              "created_at"=>Carbon::today(),
              "updated_at"=>Carbon::today(),
            ],
            [
              "nom"=>"commerce en gros",
              "remise"=>0,
              "created_at"=>Carbon::today(),
              "updated_at"=>Carbon::today(),
            ],
            [
              "nom"=>"Particulier",
              "remise"=>0,
              "created_at"=>Carbon::today(),
              "updated_at"=>Carbon::today(),
            ],
            [
              "nom"=>"publique",
              "remise"=>0,
              "created_at"=>Carbon::today(),
              "updated_at"=>Carbon::today(),
            ],
            [
              "nom"=>"Revendeur",
              "remise"=>0,
              "created_at"=>Carbon::today(),
              "updated_at"=>Carbon::today(),
            ],
            [
              "nom"=>"Société",
              "remise"=>0,
              "created_at"=>Carbon::today(),
              "updated_at"=>Carbon::today(),
            ],
        ];
        Group::insert($data);
        foreach(Group::select("created_at",'updated_at')->get() as $group)
        {
          $group->updated([
            "created_at"=>Carbon::today(),
            "updated_at"=>Carbon::today(),
          ]);
        }
    }
}
