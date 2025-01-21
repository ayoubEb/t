<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ "nom_bank"=>"AL AKHDAR BANK" ],
            [ "nom_bank"=>"AL BARID BANK" ],
            [ "nom_bank"=>"ARAB BANK" ],
            [ "nom_bank"=>"ATTIJARIWAFA BANK" ],
            [ "nom_bank"=>"BANK AL YOUSR" ],
            [ "nom_bank"=>"BANK ASSAFA" ],
            [ "nom_bank"=>"BANK OF AFRICA" ],
            [ "nom_bank"=>"BANQUE CENTRALE POPULAIRE" ],
            [ "nom_bank"=>"BMCI" ],
            [ "nom_bank"=>"BTI BANK" ],
            [ "nom_bank"=>"CDG CAPITAL" ],
            [ "nom_bank"=>"CFG BANK" ],
            [ "nom_bank"=>"CIH BANK" ],
            [ "nom_bank"=>"CITIBANK MAGHREB" ],
            [ "nom_bank"=>"CREDIT AGRICOLE DU MAROC" ],
            [ "nom_bank"=>"CREDIT DU MAROC" ],
            [ "nom_bank"=>"DAR EL AMANE" ],
            [ "nom_bank"=>"SOCIÉTÉ GÉNÉRALE MAROC" ],
            [ "nom_bank"=>"UMNIA BANK" ],
        ];
        Bank::insert($data);
    }
}
