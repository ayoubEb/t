<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/buy_sell.css">
  <title>facture : </title>
</head>
<body>


<header>
  <div class="logo">
    <img src="{{ public_path('storage/images/entreprises/' . $entreprise->logo) }}" alt="">
    <p> {{ $entreprise->adresse }} </p>
    <p>
      <span style="font-weight: bold;">Tél : </span>
      {{ $entreprise->telephone }}
    </p>
    <p>
      <span style="font-weight: bold;">Email : </span>
      {{ $entreprise->email }}
    </p>
    <p>
      <span style="font-weight: bold;">ICE : </span>
      {{ $entreprise->ice }}
    </p>
  </div>
  <div class="min-info">

    <div class="client">
        <ul>
          <li>{{ $client->raison_sociale }} </li>
          <li>{{ $client->adresse }} </li>
          <li>{{ $client->ville }} </li>
          <li class="last"> <span style="font-weight:bold;">ICE : </span>{{ $client->telephone }} </li>
        </ul>

    </div>
      <table>
        <body>
          <tr>
            <td>
              référence
            </td>
            <td>
              {{ $facture->num }}
            </td>
          </tr>
          <tr>
            <td>
              date création
            </td>
            <td>
              {{ $facture->date_facture }}
            </td>
          </tr>
        </body>
      </table>
  </div>
</header>
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
            @for ($i = 1; $i <= 24 - count($facture->produits); $i++)
                <tr>
                  <td colspan="6"><span style="visibility: hidden">Aucun Data trouvé</span></td>
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
              <th>net à payer</th>
          </tr>
      </thead>
      <tbody>
        <tr>
            <td> {{ number_format($facture->ht , 2 , "," , " ")." dh"}} </td>
            <td> {{ number_format($facture->taux_tva , 2 , "," , " ")." %"}} </td>
            <td> {{ number_format($facture->ht_tva , 2 , "," , " ")." dh"}} </td>
            <td> {{ number_format($facture->remise , 2 , "," , " ")." %"}} </td>
            <td> {{ number_format($facture->ttc , 2 , "," , " ")." dh"}} </td>
            <td> {{ number_format($facture->net_payer , 2 , "," , " ")." dh"}} </td>
        </tr>
      </tbody>

    </table>
  </div>
  @if ($entreprise != null)
    @include('layouts.footerDoc',["id"=>$entreprise->id])
  @endif


</body>
</html>


