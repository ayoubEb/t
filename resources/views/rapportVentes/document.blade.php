<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./css/rapport.css">
  <title>liste des ventes : {{ $mois }}</title>
</head>
<body>
@include('layouts.heading_doc')
  <article>
      <table>
        <thead>
          <tr>
            <th>nombre</th>
            <th>montant</th>
            <th>payer</th>
            <th>reste</th>
            <th>devis</th>
            <th>valides</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td> {{ $nbr_rapports }} </td>
            <td> {{ number_format($montant_vente, 2 ,","," ") }} dhs </td>
            <td> {{ number_format($payer_vente, 2 ,","," ") }} dhs </td>
            <td> {{ number_format($reste_vente, 2 ,","," ") }} dhs </td>
            <td> {{ number_format($sum_devis, 2 ,","," ") }} dhs </td>
            <td> {{ number_format($sum_factures, 2 ,","," ") }} dhs </td>
          </tr>
        </tbody>
      </table>

  </article>
  <article>
    <table>
      <thead>
        <tr>
          <th>référence</th>
          <th>raison sociale</th>
          <th>identifiant</th>
          <th>jour</th>
          <th>montant</th>
          <th>payer</th>
          <th>reste</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          @foreach ($rapports as $rapport)
            <tr>
              <td> {{ $rapport->reference }} </td>
              <td> {{ $rapport->raison_sociale }} </td>
              <td> {{ $rapport->identifiant }} </td>
              <td> {{ $rapport->jour }} </td>
              <td> {{ number_format($rapport->montant , 2 , "," , " ")." dhs" }} </td>
              <td> {{ number_format($rapport->payer , 2 , "," , " ")." dhs" }} </td>
              <td> {{ number_format($rapport->reste , 2 , "," , " ")." dhs" }} </td>
            </tr>
          @endforeach
        </tr>
      </tbody>
    </table>
  </article>

  @if ($entreprise != null)
    @include('layouts.footerDoc',["id"=>$entreprise->id])
  @endif

</body>
</html>