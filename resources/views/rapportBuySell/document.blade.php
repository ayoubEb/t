<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./css/rapport.css">
  <title>liste des ventes et achats </title>
</head>
<body>
  <header>
    <h4>
      liste des ventes et achats : {{ $mois }}
    </h4>
    <h6>
      num : {{ $ligneRapport->num }}
    </h6>
  </header>
  <article class="resume">
      <table>
        <caption>
          achats
        </caption>
        <thead>
          <tr>
            {{-- <th>nombre</th> --}}
            <th>montant</th>
            <th>payer</th>
            <th>reste</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            {{-- <td> {{ $nbr_rapports }} </td> --}}
            <td> {{ number_format($ligneRapport->montant_achat, 2 ,","," ") }} dhs </td>
            <td> {{ number_format($ligneRapport->payer_achat, 2 ,","," ") }} dhs </td>
            <td> {{ number_format($ligneRapport->reste_achat, 2 ,","," ") }} dhs </td>
          </tr>
        </tbody>
      </table>

  </article>
  <article class="resume">
      <table>
        <caption>
          ventes
        </caption>
        <thead>
          <tr>
            {{-- <th>nombre</th> --}}
            <th>montant</th>
            <th>payer</th>
            <th>reste</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            {{-- <td> {{ $nbr_rapports }} </td> --}}
            <td> {{ number_format($ligneRapport->montant_vente, 2 ,","," ") }} dhs </td>
            <td> {{ number_format($ligneRapport->payer_vente, 2 ,","," ") }} dhs </td>
            <td> {{ number_format($ligneRapport->reste_vente, 2 ,","," ") }} dhs </td>
          </tr>
        </tbody>
      </table>

  </article>
  <article class="all">
    <table>
      <caption>all</caption>
      <thead>
        <tr>
          <th>référence</th>
          <th>montant</th>
          <th>payer</th>
          <th>reste</th>
          <th>status</th>
          <th>affecter</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          @foreach ($rapports as $rapport)
            <tr>
              <td> {{ $rapport->reference }} </td>
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
              <td>
                @if ($rapport->affecter == "achat")
                  <span class="text-bleu"> achat </span>
                @elseif ($rapport->affecter == "vente")
                  <span class="text-vert"> vente </span>
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
          <td class="">-</td>
        @endfor
      </tbody>
    </table>
  </article>


</body>
</html>