@extends('layouts.master')
@section('content')
<div class="card">
  <div class="card-body p-3">

        <h6 class="title text-center">
          information de paiement
        </h6>
        <div class="row row-cols-2">
          <div class="col">
            <div class="table-reposnisve">
              <table class="table table-bordered m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">
                      client
                    </td>
                    <td class="align-middle">
                      {{ $client->raison_sociale }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      identifnat client
                    </td>
                    <td class="align-middle">
                      {{ $client->identifiant }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      ice client
                    </td>
                    <td class="align-middle">
                      {{ $client->ice }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      type paiement
                    </td>
                    <td class="align-middle">
                      {{ $facturePaiement->type_paiement }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col">
            <div class="table-reposnisve">
              <table class="table table-bordered m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">
                      facture
                    </td>
                    <td class="align-middle">
                      {{ $facture->num }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      net à payer
                    </td>
                    <td class="align-middle">
                      <span class="mt">
                        {{ number_format($facture->net_payer , 2 , "," , " ") }} dhs
                      </span>
                    </td>
                  </tr>

                  <tr>
                    <td class="align-middle">
                      montant payer reçu
                    </td>
                    <td class="align-middle">
                      <span class="mt">
                        {{ number_format($facturePaiement->payer , 2 , "," , " ") }} dhs
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      montant reste
                    </td>
                    <td class="align-middle">
                      <span class="mt">
                        {{ number_format($facture->reste , 2 , "," , " ") }} dhs
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        @if ($facturePaiement->type_paiement == "chèque")
        <h6 class="title my-2">
          info chèque
        </h6>
          <div class="table-responsive">
            <table class="table table-bordered m-0 info">
              <tbody>
                <tr>
                  <td class="align-middle">
                    numéro
                  </td>
                  <td class="align-middle">
                    {{ $facturePaiement->cheque && $facturePaiement->cheque->numero != '' ? $facturePaiement->cheque->numero : ''}}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    banque
                  </td>
                  <td class="align-middle">
                    {{ $facturePaiement->cheque && $facturePaiement->cheque->bank && $facturePaiement->cheque->bank->nom_bank != '' ? $facturePaiement->cheque->bank->nom_bank : ''}}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    date
                  </td>
                  <td class="align-middle">
                    {{ $facturePaiement->cheque && $facturePaiement->cheque->date_cheque != '' ? $facturePaiement->cheque->date_cheque : ''}}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    date enquisement
                  </td>
                  <td class="align-middle">
                    {{ $facturePaiement->cheque && $facturePaiement->cheque->date_enquisement != '' ? $facturePaiement->cheque->date_enquisement : ''}}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        @endif
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="mt-2 bg-vert-light py-3 border-2 border-solid border-primary border-rounded">
              <h6 class="text-center m-0">
                Votre paiement a été accepter
              </h6>
            </div>
            <div class="row row-cols-2">
              <div class="col mb-2">
                <a href="{{ route('facturePaiement.index') }}" class="btn btn-noBack waves-effect waves-light w-100 text-start">liste des paiements</a>
              </div>
              <div class="col mb-2">
                <a href="{{ route('facture.show',$facture) }}" class="btn btn-noBack waves-effect waves-light w-100 text-start">liste des paiement du cette facture</a>
              </div>
              <div class="col mb-2">
                <a href="{{ route('facturePaiement.recu',$facturePaiement) }}" class="btn btn-noBack waves-effect waves-light w-100 text-start">Imprimer le reçu</a>
              </div>
              <div class="col mb-2">
                <a href="{{ route('facturePaiement.show',$facturePaiement) }}" class="btn btn-noBack waves-effect waves-light w-100 text-start">display le reçu</a>
              </div>
              @if ($facture->reste != 0)
                <div class="col mb-2">
                  <a href="{{ route('facturePaiement.add',$facture) }}" class="btn btn-noBack waves-effect waves-light w-100 text-start">autre paiement</a>
                </div>

              @endif
            </div>
          </div>

        </div>



  </div>
</div>
@endsection