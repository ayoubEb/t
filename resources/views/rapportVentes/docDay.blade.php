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
  <header class="headerRapport">
    <h4>
      liste des ventes : {{ $mois }}
    </h4>
    <h6>
      num : {{ $ligneRapport->num }}
    </h6>
  </header>
  <article class="headerInfo">
      <table>
        <thead>
          <tr>
            <th>nombre</th>
            <th>mois</th>
            <th>montant</th>
            <th>payer</th>
            <th>reste</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              {{ count($rapports) }}
            </td>
            <td>
              {{ $mois }}
            </td>
            <td>
              {{ number_format($rapports->sum("sum_mt") , 2 , "," ," ") }} dhs
            </td>
            <td>
              {{ number_format($rapports->sum("sum_payer") , 2 , "," ," ") }} dhs
            </td>
            <td>
              {{ number_format($rapports->sum("sum_reste") , 2 , "," ," ") }} dhs
            </td>
          </tr>

        </tbody>
      </table>

  </article>
  <article>
    <table>
      <thead>
        <tr>
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
              <td> {{ $rapport->jour }} </td>
              <td> {{ number_format($rapport->sum_mt , 2 , "," , " ")." dhs" }} </td>
              <td> {{ number_format($rapport->sum_payer , 2 , "," , " ")." dhs" }} </td>
              <td> {{ number_format($rapport->sum_reste , 2 , "," , " ")." dhs" }} </td>
            </tr>
          @endforeach
        </tr>
      </tbody>
    </table>
  </article>
</body>
</html>