@extends('layouts.master')
@section('content')
@php
    $check = "resume";
@endphp
  @include('ligneRapports.headeLinks',["id"=>$ligneRapport->id , "check" => $check])
  <div class="row row-cols-3">
    <div class="col">
      <h6 class="title">
        résumer vente validé
      </h6>
      <div class="card">
        <div class="card-body p-3">
          <div class="row row-cols-2">
            <div class="col mb-2">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  net à payer
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($net_payer_ventes,2,","," ") }} dh
                </h5>
              </div>
            </div>
            <div class="col mb-2">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  payer
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($payer_ventes,2,","," ") }} dh
                </h5>
              </div>
            </div>
            <div class="col mb-md-2 mb-0">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  reste
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($reste_ventes,2,","," ") }} dh
                </h5>
              </div>
            </div>
            <div class="col">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  nombre
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ $count_ventes }}
                </h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <h6 class="title">
        résumer devis
      </h6>
      <div class="card">
        <div class="card-body p-3">
          <div class="row row-cols-2">
            <div class="col mb-2">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  montant
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($montant_ventes,2,","," ") }} dh

                </h5>
              </div>
            </div>
            <div class="col mb-2">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  payer
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($devisPayer_ventes,2,","," ") }} dh
                </h5>
              </div>
            </div>
            <div class="col mb-md-2 mb-0">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  reste
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($devisReste_ventes,2,","," ") }} dh
                </h5>
              </div>
            </div>
            <div class="col">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  nombre
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ $devisCount_ventes }}
                </h5>
              </div>
            </div>
          </div>






        </div>
      </div>
    </div>

    <div class="col">
      <h6 class="title">
        résumer des ventes du mois
      </h6>
      <div class="card">
        <div class="card-body p-3">
          <div class="row row-cols-2">
            <div class="col mb-2">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  montant
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($ligneRapport->montant_vente,2,","," ") }} dh

                </h5>
              </div>
            </div>
            <div class="col mb-2">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  payer
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($ligneRapport->payer_vente,2,","," ") }} dh
                </h5>
              </div>
            </div>
            <div class="col mb-md-2 mb-0">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  reste
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($ligneRapport->reste_vente,2,","," ") }} dh
                </h5>
              </div>
            </div>
            <div class="col">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  nombre
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ $totalCount_ventes }}
                </h5>
              </div>
            </div>
          </div>






        </div>
      </div>
    </div>

    <div class="col">
      <h6 class="title">
        résumer achat validé
      </h6>
      <div class="card">
        <div class="card-body p-3">
          <div class="row row-cols-2">
            <div class="col mb-2">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  net à payer
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($net_payer_achats,2,","," ") }} dh

                </h5>
              </div>
            </div>
            <div class="col mb-2">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  payer
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($payer_achats,2,","," ") }} dh
                </h5>
              </div>
            </div>
            <div class="col mb-md-2 mb-0">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  reste
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($reste_achats,2,","," ") }} dh
                </h5>
              </div>
            </div>
            <div class="col">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  nombre
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ $count_achats }}
                </h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <h6 class="title">
        résumer demandes
      </h6>
      <div class="card">
        <div class="card-body p-3">
          <div class="row row-cols-2">
            <div class="col mb-2">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  montant
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($montant_achats,2,","," ") }} dh

                </h5>
              </div>
            </div>
            <div class="col mb-2">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  payer
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($devisPayer_achats,2,","," ") }} dh
                </h5>
              </div>
            </div>
            <div class="col mb-md-2 mb-0">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  reste
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($devisReste_achats,2,","," ") }} dh
                </h5>
              </div>
            </div>
            <div class="col">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  nombre
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ $devisCount_achats }}
                </h5>
              </div>
            </div>
          </div>






        </div>
      </div>
    </div>

    <div class="col">
      <h6 class="title">
        résumer des achats du mois
      </h6>
      <div class="card">
        <div class="card-body p-3">
          <div class="row row-cols-2">
            <div class="col mb-2">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  montant
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($ligneRapport->montant_achat,2,","," ") }} dh

                </h5>
              </div>
            </div>
            <div class="col mb-2">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  payer
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($ligneRapport->payer_achat,2,","," ") }} dh
                </h5>
              </div>
            </div>
            <div class="col mb-md-2 mb-0">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  reste
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ number_format($ligneRapport->reste_achat,2,","," ") }} dh
                </h5>
              </div>
            </div>
            <div class="col">
              <div class="border border-2 border-solid border-success text-center py-2 rounded">
                <h6 class="mb-2 text-uppercase">
                  nombre
                </h6>
                <h5 class="m-0 text-uppercase">
                  {{ $totalCount_achats }}
                </h5>
              </div>
            </div>
          </div>






        </div>
      </div>
    </div>
  </div>
@endsection