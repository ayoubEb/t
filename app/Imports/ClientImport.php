<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class ClientImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
            if (empty($row['nom'])) {
        return null;
      }
      // Count products to generate a reference
            $count_cli = DB::table("clients")->count() + 1;
            $ref  =$count_cli . Str::upper(Str::random(6)) ;
            return Client::create([
              'identifiant'    => $ref,
              'raison_sociale' => $row['nom'],
              'ice' => $row['ice'],
              'adresse'            => $row['adresse'] ?? null,
            ]);
     


    }

    public function headingRow(): int
    {
        return 1;
    
    }
}
