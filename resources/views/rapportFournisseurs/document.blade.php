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
  <header>
    <h4>
      liste des ventes : {{ $mois }}
    </h4>
    <h6>
      num : {{ $ligneRapport->num }}
    </h6>
  </header>

  <article>
    <table>
      <thead>
        <tr>
          <th>identifiant</th>
          <th>raison sociale</th>
          <th>jour</th>
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
              <td> {{ $rapport->identifiant }} </td>
              <td> {{ $rapport->name }} </td>
              <td> {{ $rapport->jour }} </td>
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
      </tbody>
    </table>
  </article>


</body>
</html>