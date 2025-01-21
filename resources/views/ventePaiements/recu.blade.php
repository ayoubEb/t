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
         reçu du paiement : {{ $facturePaiement->numero_operation ?? '' }}
      </h6>
    </div>

    <article class="infoBasic">
      <table>
        <tbody>
          <tr>
              <td>numéro opération</td>
              <td> {{ $facturePaiement->numero_operation ?? '' }} </td>
          </tr>
          <tr>
              <td>mode</td>
              <td> {{ $facturePaiement->type_paiement ?? '' }} </td>
          </tr>
          <tr>
              <td>date</td>
              <td> {{ $facturePaiement->date_paiement ?? '' }} </td>
          </tr>
          <tr>
              <td>montant payer</td>
              <td> {{ $facturePaiement->payer ?? 0 }} DH </td>
          </tr>
          <tr>
              <td>numéro</td>
              <td> {{ $facture->num ?? '' }} </td>
          </tr>
        </tbody>
    </table>
   </article>





  @if ($facturePaiement->type_paiement == "chèque")
  <article class="infoCheque">
    <div>
      <table>
          <tbody>

            <tr>
                <td>numéro</td>
                <td> {{ $facturePaiement->cheque->numero ?? '' }} </td>
            </tr>

            <tr>
                <td>date chèque</td>
                <td> {{ $facturePaiement->cheque->date_cheque ?? '' }} </td>
            </tr>
          </tbody>
      </table>
    </div>
    <div>
      <table>
          <tbody>
            <tr>
                <td>date enquisement</td>
                <td> {{ $facturePaiement->cheque->date_enquisement ?? '' }} </td>
            </tr>
            <tr>
                <td>banque</td>
                <td> {{ $facturePaiement->cheque->bank->nom_bank ?? '' }} </td>
            </tr>



          </tbody>
      </table>
    </div>
  </article>
@endif


<hr>
@if (isset($entreprise))
  @include('layouts.footerDoc',["id"=>$entreprise->id]);
@endif



</body>
</html>