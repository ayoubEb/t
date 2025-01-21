<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/recu.css">
    <title>reçu du paiement espéce de client</title>
</head>
<body>

    <div class="topPage">
      <h6 class="title">
         reçu du paiement : {{ $achatPaiement->numero_operation ?? '' }}
      </h6>

    </div>
  <article class="infoBasic">
     <table>
        <tbody>
           <tr>
              <td>fournisseur</td>
              <td> {{ $fournisseur->raison_sociale ?? '' }} </td>
           </tr>
           <tr>
              <td>identifiant</td>
              <td> {{ $fournisseur->identifiant ?? '' }} </td>
           </tr>
           <tr>
              <td>numéro opération</td>
              <td> {{ $achatPaiement->numero_operation ?? '' }} </td>
           </tr>
           <tr>
              <td>mode</td>
              <td> {{ $achatPaiement->type_paiement ?? '' }} </td>
           </tr>
           <tr>
              <td>date</td>
              <td> {{ $achatPaiement->date_paiement ?? '' }} </td>
           </tr>
           <tr>
              <td>montant payer</td>
              <td> {{ $achatPaiement->payer ?? 0 }} DH </td>
           </tr>
           <tr>
              <td>numéro</td>
              <td> {{ $ligneAchat->num_achat ?? '' }} </td>
           </tr>
        </tbody>
     </table>
  </article>





  <hr>
  @if (isset($entreprise))
    @include('layouts.footerDoc',["id"=>$entreprise->id]);
  @endif



</body>
</html>