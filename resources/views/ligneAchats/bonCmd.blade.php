<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/buy_sell.css">
  <title>bon de commande : {{ $reference }} </title>
</head>
<body>


  <header class="">
    <h5>
      bon de commande : {{ $reference }}
    </h5>
  </header>
  <div class="sub-header">
    <div class="user">
      <ul>
        <li>{{ $fournisseur->raison_sociale }} </li>
        <li> {{ $fournisseur->adresse }} </li>
        <li> {{ $fournisseur->ville }} </li>
        <li class="last"> {{ $fournisseur->telephone }} </li>
      </ul>
    </div>
    <div class="entreprise">
      <ul>
        <li><span>Tél&nbsp;:&nbsp;</span>{{ $entreprise->telephone}}</li>
        <li><span>fix&nbsp;:&nbsp;</span>{{ $entreprise->fix}}</li>
        <li><span>site&nbsp;:&nbsp;</span>{{ $entreprise->site}}</li>
        <li class="last"><span>mail&nbsp;:&nbsp;</span>{{ $entreprise->email}}</li>
      </ul>
      <div class="min">
        <table>
          <thead>
            <tr>
              <th>référence</th>
              <th>date</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                {{ $ligneAchat->num_achat }}
              </td>
              <td>
                {{ $ligneAchat->date_achat }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
</div>


  <div class="produits">
    <table>
        <thead>
            <tr>
                <th>référence</th>
                <th>designation</th>
                <th>qté</th>
                <th>p.u (h.t)</th>
                <th>remise %</th>
                <th>montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($achats as $achat)
                <tr>
                    <td>
                      {{ $achat->produit->reference ?? ''}}
                    </td>
                    <td> {{ $achat->produit->designation ?? ''}} </td>
                    <td> {{ $achat->quantite ?? ''}} </td>
                    <td> {{ number_format($achat->prix , 2 , "," , " ")." dhs"}} </td>
                    <td> {{ $achat->remise ?? ''}} </td>
                    <td> {{ number_format($achat->montant , 2 , "," , " ")." dhs"}} </td>
                </tr>

            @endforeach
            @for ($i = 1; $i <= 45 - count($achats); $i++)
                <tr class="rowsNull">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
            @endfor
        </tbody>

    </table>

  </div>

  <div class="resume">
    <table>
      <thead>
          <tr>
              <th>montant ht</th>
              <th>tva</th>
              <th>ttc</th>
              <th>montant tva</th>
              <th>remise %</th>
              <th>net à payer</th>
          </tr>
      </thead>
      <tbody>
        <tr>
            <td> {{ number_format($ligneAchat->ht , 2 , "," , " ")." dhs"}} </td>
            <td> {{ number_format($ligneAchat->taux_tva , 2 , "," , " ")." %"}} </td>
            <td> {{ number_format($ligneAchat->ttc , 2 , "," , " ")." dhs"}} </td>
            <td> {{ number_format($ligneAchat->mt_tva , 2 , "," , " ")." dhs"}} </td>
            <td> {{ number_format($ligneAchat->remise , 2 , "," , " ")." %"}} </td>
            <td> {{ number_format($ligneAchat->net_payer , 2 , "," , " ")." dhs"}} </td>
        </tr>
      </tbody>

    </table>
  </div>

  @if (isset($entreprise))
    @include('layouts.footerDoc',["id"=>$entreprise->id])
  @endif
</body>
</html>


