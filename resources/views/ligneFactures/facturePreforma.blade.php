<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/buy_sell.css">
  <title>facture préforma : {{ $facture->num_preforma }}</title>
</head>
<body>


  <header class="">
    <h5>
      facture préforma : {{ $facture->num_preforma }}
    </h5>
  </header>
  <div class="sub-header">
    <div class="user">
      <ul>
        <li>{{ $client->raison_sociale }} </li>
        <li> {{ $client->adresse }} </li>
        <li> {{ $client->ville }} </li>
        <li class="last"> {{ $client->telephone }} </li>
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
                {{ $facture->num }}
              </td>
              <td>
                {{ $facture->date_facture }}
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
            @foreach ($facture->produits as $facture_produit)
                <tr>
                    <td> {{ $facture_produit->produit->reference ?? ''}} </td>
                    <td> {{ $facture_produit->produit->designation ?? ''}} </td>
                    <td> {{ $facture_produit->quantite ?? ''}} </td>
                    <td> {{ number_format($facture_produit->prix , 2 , "," , " ")." dhs"}} </td>
                    <td> {{ $facture_produit->remise ?? ''}} </td>
                    <td> {{ number_format($facture_produit->montant , 2 , "," , " ")." dhs"}} </td>
                </tr>

            @endforeach
            @for ($i = 0; $i < 45 - count($facture->produits); $i++)
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

  <h5 style="text-transform:uppercase;margin:10px 0 0 0 ;font-size:12px;">
    {{ $letter_chiffre }} DHS
  </h5>
  <div class="resume">
    <table>
      <thead>
          <tr>
              <th>montant ht</th>
              <th>tva</th>
              <th>montant tva</th>
              <th>remise %</th>
              <th>ttc</th>
          </tr>
      </thead>
      <tbody>
        <tr>
            <td> {{ number_format($facture->ht , 2 , "," , " ")." dh"}} </td>
            <td> {{ number_format($facture->taux_tva , 2 , "," , " ")." %"}} </td>
            <td> {{ number_format($facture->ht_tva , 2 , "," , " ")." dh"}} </td>
            <td> {{ number_format($facture->remise , 2 , "," , " ")." %"}} </td>
            <td> {{ number_format($facture->ttc , 2 , "," , " ")." dh"}} </td>
        </tr>
      </tbody>

    </table>
  </div>
  @if ($entreprise != null)
    @include('layouts.footerDoc',["id"=>$entreprise->id])
  @endif


</body>
</html>


