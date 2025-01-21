<?php

namespace App\Imports;

use App\Models\Produit;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class ProduitsImport implements ToModel ,  WithHeadingRow
{
     public $rows;
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
            $count_pro = DB::table("produits")->count();
            $ref  ="PRO-00" . ( $count_pro + 1) ;
           $pro = Produit::create([
              'reference'    => $ref,
              'designation' => $row['nom'],
              'prix_vente'            => $row['prix'],
              'quantite'            => $row['quantite'],
            ]);
        // Assign the row to the class property
        if (!isset($this->rows)) {
          $this->rows = [];
      }

      $this->rows[] = [ "pro_id"=>$pro->id , "qte"=>$pro->quantite]; // Keep track of processed rows

      return $pro;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
