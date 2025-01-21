<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./css/rapport.css">
  <title>liste des achats</title>
</head>
<body>
  <header>
    <h4>
      liste des achats : {{ $mois }}
    </h4>
    <h6>
      num : {{ $ligneRapport->num }}
    </h6>
  </header>
  <article class="resume">
      <table>
        <thead>
          <tr>
            <th>nombre</th>
            <th>montant</th>
            <th>payer</th>
            <th>reste</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td> {{ $nbr_rapports }} </td>
            <td> {{ number_format($montant_achat, 2 ,","," ") }} dhs </td>
            <td> {{ number_format($payer_achat, 2 ,","," ") }} dhs </td>
            <td> {{ number_format($reste_achat, 2 ,","," ") }} dhs </td>
          </tr>
        </tbody>
      </table>

  </article>
  <article class="all">
    <table>
      <thead>
        <tr>
          <th>référence</th>
          <th>raison sociale</th>
          <th>identifiant</th>
          <th>montant</th>
          <th>payer</th>
          <th>reste</th>
          <th>status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          @foreach ($rapports as $rapport)
            <tr>
              <td> {{ $rapport->reference }} </td>
              <td> {{ $rapport->raison_sociale }} </td>
              <td> {{ $rapport->identifiant }} </td>
              <td> {{ number_format($rapport->montant , 2 , "," , " ")." dhs" }} </td>
              <td> {{ number_format($rapport->payer , 2 , "," , " ")." dhs" }} </td>
              <td> {{ number_format($rapport->reste , 2 , "," , " ")." dhs" }} </td>
              <td>
                @if ($rapport->status == "en cours")
                  <span class="text-bleu"> en cours </span>
                @elseif ($rapport->status == "validé")
                  <span class="text-vert"> validé </span>
                @else
                  <span class="text-red"> annuler </span>
                @endif
              </td>
            </tr>
          @endforeach
        </tr>
        @for ($i = 1; $i <= 33 - count($rapports); $i++)
        <tr>
          <td class="">-</td>
          <td class="">-</td>
          <td class="">-</td>
          <td class="">-</td>
          <td class="">-</td>
        @endfor
      </tbody>
    </table>
  </article>


</body>
</html>