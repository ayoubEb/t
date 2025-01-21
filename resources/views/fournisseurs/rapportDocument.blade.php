<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=devif-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./css/rapport.css">
  <title>Document</title>
</head>
<body>
  <header>
    <h5>
      rapport de fournisseur : {{ $fournisseur->raison_sociale }}
    </h5>
  </header>
  <article class="infoClient">
      <table>
        <tbody>
          <tr>
            <td>identifiant</td>
            <td> {{ $fournisseur->identifiant }} </td>
          </tr>
          <tr>
            <td>raison sociale</td>
            <td> {{ $fournisseur->raison_sociale }} </td>
          </tr>

          <tr>
            <td>adresse</td>
            <td> {{ $fournisseur->adresse }} </td>
          </tr>
          <tr>
            <td>ville</td>
            <td> {{ $fournisseur->ville }} </td>
          </tr>
          <tr>
            <td>ice</td>
            <td> {{ $fournisseur->ice }} </td>
          </tr>
          <tr>
            <td>rc</td>
            <td>
              {{ $fournisseur->rc }}
            </td>
          </tr>
          <tr>
            <td>téléphone</td>
            <td>
              {{ $fournisseur->telephone }}
            </td>
          </tr>
          <tr>
            <td>code postal</td>
            <td>
              {{ $fournisseur->code_postal }}
            </td>
          </tr>
          <tr>
            <td>email</td>
            <td>
              {{ $fournisseur->email }}
            </td>
          </tr>
          <tr>
            <td>pays</td>
            <td>
              {{ $fournisseur->pays }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </article>

<article style="margin-top: 15px;">
  <table>
    <thead>
      <tr>
        <th>identifiant</th>
        <th>montant</th>
        <th>payer</th>
        <th>reste</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          {{ $fournisseur->identifiant }}
        </td>
        <td>
          {{ number_format($fournisseur->montant , 2 , "," , " ") }} dh
        </td>
        <td>
          {{ number_format($fournisseur->payer , 2 , "," , " ") }} dh
        </td>
        <td>
          {{ number_format($fournisseur->reste , 2 , "," , " ") }} dh
        </td>
      </tr>
    </tbody>
  </table>
</article>

  <article>
    <h6 class="sub-title">
      les achats
    </h6>
    <table>
      <thead>
        <tr>
          <th>référence</th>
          <th>ht</th>
          <th>ttc</th>
          <th>payer</th>
          <th>reste</th>
          <th>status</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($achats as $achat)
          <tr>
            <td> {{ $achat->num_achat }} </td>
            <td> {{ number_format($achat->ht , 2 , "," ," ") }} dhs </td>
            <td> {{ number_format($achat->ttc , 2 , "," ," ") }} dhs </td>
            <td> {{ number_format($achat->payer , 2 , "," ," ") }} dhs </td>
            <td> {{ number_format($achat->reste , 2 , "," ," ") }} dhs </td>
            <td> {{ $achat->status }} </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </article>

  @if (count($paiements) > 0)
    <article>
      <h6 class="title">
        les paiements
      </h6>
      <table>
        <thead>
          <tr>
            <th>facture</th>
            <th>numéro opération</th>
            <th>type</th>
            <th>date</th>
            <th>montant</th>
            <th>status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($paiements as $paiement)
            <tr>
              <td>
                {{ $paiement->facture->num }}
              </td>
              <td>
                {{ $paiement->numero_operation }}
              </td>
              <td>
                {{ $paiement->type_paiement }}
              </td>
              <td>
                {{ $paiement->date_paiement }}
              </td>
              <td>
                {{ $paiement->payer }}
              </td>
              <td>
                {{ $paiement->status }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </article>
  @endif
</body>
</html>