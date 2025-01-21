@extends('layouts.master')

@section('content')

    <div class="card">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">numero</th>
                    <th scope="col">Montant.a</th>
                    <th scope="col">payer.a</th>
                    <th scope="col">reste.a</th>
                    <th scope="col">Montant.v</th>
                    <th scope="col">payer.v</th>
                    <th scope="col">reste.v</th>
                    <th scope="col">Details</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($ligneRapports as $ligneRapport)
                    <tr>
                      <td class="align-middle">
                        {{ $ligneRapport->num }}
                      </td>
                      <td class="align-middle">
                        {{ number_format($ligneRapport->montant_achat, 2 , ","," ") }} DHS
                      </td>
                      <td class="align-middle">
                        {{ number_format($ligneRapport->payer_achat, 2 , ","," ") }} DHS
                      </td>
                      <td class="align-middle">
                        {{ number_format($ligneRapport->reste_achat, 2 , ","," ") }} DHS
                      </td>
                      <td class="align-middle">
                        {{ number_format($ligneRapport->montant_vente, 2 , ","," ") }} DHS
                      </td>
                      <td class="align-middle">
                        {{ number_format($ligneRapport->payer_vente, 2 , ","," ") }} DHS
                      </td>
                      <td class="align-middle">
                        {{ number_format($ligneRapport->reste_vente, 2 , ","," ") }} DHS
                      </td>
                      <td>
                        <a href="{{route('ligneRapport.buySell', $ligneRapport->mois)}}" class="btn p-1 py-0 btn-warning">
                            <i class="mdi mdi-information-outline"></i>
                        </a>
                        <a href="{{route('ligneRapport.docBuySell', $ligneRapport->mois)}}" class="btn p-1 py-0 btn-warning">
                            <i class="mdi mdi-file-outline"></i>
                        </a>
                        <a href="{{route('ligneRapport.exportBuySell', $ligneRapport->mois)}}" class="btn p-1 py-0 btn-warning">
                          <span class="mdi mdi-microsoft-excel align-middle"></span>
                        </a>
                      </td>
                        {{--
                        <td>
                          {{ number_format($vente->reste_vente , 2 , ","," ") }} DHS
                        </td>
                        <td>
                            <a href="{{route('ligneRapport.docVente', $vente->mois)}}" class="btn p-1 py-0 btn-warning">
                                <i class="mdi mdi-file-ouline"></i>
                            </a>
                            <a href="{{route('ligneRapport.exportVente', $vente->mois)}}" class="btn p-1 py-0 btn-warning">
                                <i class="mdi mdi-file-ouline"></i>
                            </a>
                        </td> --}}
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection