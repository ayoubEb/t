<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $permissions=[

        // nouveau - liste - display - suppression - modification
        'categorie-nouveau','categorie-modification','categorie-list','categorie-display','categorie-suppression',
        'depot-nouveau','depot-modification','depot-list','depot-display','depot-suppression',
        'conditionPaiement-nouveau','conditionPaiement-modification','conditionPaiement-list','conditionPaiement-suppression','conditionPaiement-display',
        'tauxTva-list','tauxTva-nouveau','tauxTva-modification','tauxTva-suppression','tauxTva-display',
        'user-nouveau','user-modification','user-list','user-display','user-suppression',
        'role-nouveau','role-modification','role-list','role-display','role-suppression',
        'entreprise-nouveau','entreprise-modification','entreprise-list','entreprise-suppression','entreprise-display',
        "typeClient-modification","typeClient-suppression","typeClient-nouveau","typeClient-list","typeClient-display",
        'groupe-nouveau','groupe-modification','groupe-list','groupe-suppression',"groupe-display",
        'client-nouveau','client-modification','client-list','client-display','client-suppression',
        'caracteristique-list','caracteristique-nouveau','caracteristique-modification','caracteristique-suppression',"caracteristique-display",
        "achatPaiement-list","achatPaiement-nouveau","achatPaiement-suppression","achatPaiement-display","achatPaiement-modification",
        'fournisseur-nouveau','fournisseur-modification','fournisseur-list','fournisseur-display','fournisseur-suppression',
        'produit-nouveau','produit-modification','produit-list','produit-display','produit-suppression',
        'facturePaiement-nouveau','facturePaiement-list','facturePaiement-suppression','facturePaiement-display','facturePaiement-modification',
        'facture-nouveau','facture-modification','facture-display','facture-suppression','facture-list',

        // nouveau - modification - suppression
        'produitCategorie-nouveau','produitCategorie-modification','produitCategorie-suppression',
        'produitSousCategorie-nouveau','produitSousCategorie-modification','produitSousCategorie-suppression',
        'produitAttribut-nouveau','produitAttribut-modification','produitAttribut-suppression',
        'sousCategorie-nouveau','sousCategorie-modification','sousCategorie-suppression',


        // nouveau - liste - diplay - modification
        "ligneAchat-nouveau", "ligneAchat-list","ligneAchat-modification","ligneAchat-display",
        'stock-list','stock-nouveau',"stock-display",'stock-suppression','stock-modification',
        "ligneAvoire-nouveau", "ligneAvoire-list","ligneAvoire-modification","ligneAvoire-display",
        'stockHistory-nouveau',

        // nouveau - modificatio - display - suppression
        "customize-facture","customize-stock","customize-ligneAchat",
        "ligneRapport-list","ligneRapport-display",
        "rapportVente-list"
        ];
        foreach($permissions as $permission){
            Permission::create(["name"=>$permission]);
        }
    }
}
