@extends('layouts.master')
@section('content')

<div class="card">
  <div class="card-body p-2">
      <div class="d-flex justify-content-center">
        <a href="{{ route('tresorerie.docCommande')}}" class="btn btn-header mb-2">
          document : {{ date('Y') }}
        </a>
      </div>
    <div class="table-responsive">
      <table class="table table-bordered plan m-0">
        <thead class="bg-primary">

          <tr>
            <th></th>
            @foreach ($months as $k => $row)
            <th class="text-white">
              {{ $k }}
            </th>
            @endforeach
            <th>
              {{ date("Y") }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="align-middle table-warning text-center" colspan="15">
              les ventes
            </td>
          </tr>

          {{-- motants --}}
          {{-- montant ttc commande --}}
          {{-- index : 0 --}}
          <tr>
            <td class="align-middle table-success fw-bold">
              montant ttc
            </td>
            @php
                $sum_ttc = 0;
            @endphp
            @foreach ($months as $k => $row)
              <td class="align-middle">
                @php
                  $arr = explode(' - ', $row);
                  $cmd_ttc = $arr[0] ?? ''; //
                  $sum_ttc += $arr[0];
                @endphp
                {{ number_format($cmd_ttc , 2 , "," ," ") . " dh" }}
              </td>
            @endforeach
            <td class="align-middle">
              <span class="mt">
                {{ number_format($sum_ttc,2,"," ," ") }} dh
              </span>
            </td>
          </tr>

          {{-- montant net à payer commande --}}
          {{-- index : 1 --}}
          <tr>
            <td class="align-middle table-success fw-bold">
              net à payer
            </td>
            @php
                $sum_netPayer = 0;
            @endphp
            @foreach ($months as $k => $row)
              <td class="align-middle">
                @php
                    $arr = explode(' - ', $row);
                    $cmd_netPayer = $arr[1] ?? ''; //
                    $sum_netPayer += $arr[1];
                @endphp
                {{ number_format($cmd_netPayer , 2 , "," ," ") . " dh" }}
              </td>
            @endforeach
            <td class="align-middle">
              <span class="mt">
                {{ number_format($sum_netPayer,2,"," ," ") }} dh
              </span>
            </td>
          </tr>

          {{-- montant payer commande --}}
          {{-- index : 2 --}}
          <tr>
            <td class="align-middle table-success fw-bold">
              payer
            </td>
            @php
                $sum_payer = 0;
            @endphp
            @foreach ($months as $k => $row)
              <td class="align-middle">
                <span class="text-success mt">
                  @php
                      $arr = explode(' - ', $row);
                      $cmd_payer = $arr[2] ?? ''; //
                      $sum_payer += $arr[2] ?? ''; //
                  @endphp
                  {{ number_format($cmd_payer , 2 , "," ," ") . " dh" }}
                </span>
              </td>
            @endforeach
            <td class="align-middle">
              <span class="mt">
                {{ number_format($sum_payer,2,"," ," ") }} dh
              </span>
            </td>
          </tr>

          {{-- montant reste commande --}}
          {{-- index : 3 --}}
          <tr>
            <td class="align-middle table-success fw-bold">
              reste
            </td>
            @php
                $sum_reste = 0;
            @endphp
            @foreach ($months as $k => $row)
              <td class="align-middle">
                <span class="text-danger mt">
                    @php
                        $arr = explode(' - ', $row);
                        $cmd_reste = $arr[3] ?? ''; //
                        $sum_reste += $arr[3] ?? ''; //
                    @endphp
                    {{ number_format($cmd_reste , 2 , "," ," ") . " dh" }}
                </span>
              </td>
            @endforeach
            <td class="align-middle">
              <span class="mt">
                {{ number_format($sum_reste,2,"," ," ") }} dh
              </span>
            </td>
          </tr>


          {{-- montant espèces --}}
          {{-- index : 4 --}}
          <tr>
            <td class="align-middle table-success fw-bold">
              espèces
            </td>
            @php
                $sum_especes = 0;
            @endphp
            @foreach ($months as $k => $row)
              <td class="align-middle">
                <span class="mt">
                  @php
                    $arr          = explode(' - ', $row);
                    $especes      = $arr[4] ?? '';        //
                    $sum_especes += $arr[4] ?? '';        //
                  @endphp
                  {{ number_format($especes , 2 , "," ," ") . " dh" }}
                </span>
              </td>
            @endforeach
            <td class="align-middle">
              <span class="mt">
                {{ number_format($sum_especes,2,"," ," ") }} dh
              </span>
            </td>
          </tr>

          {{-- montant chèques --}}
          {{-- index : 5 --}}
          <tr>
            <td class="align-middle table-success fw-bold">
              chèques
            </td>
            @php
              $sum_cheques = 0;
            @endphp
            @foreach ($months as $k => $row)
              <td class="align-middle">
                <span class="mt">
                    @php
                        $arr = explode(' - ', $row);
                        $cheques = $arr[5] ?? ''; //
                        $sum_cheques += $arr[5] ?? ''; //
                    @endphp
                    {{ number_format($cheques , 2 , "," ," ") . " dh" }}
                </span>
              </td>
            @endforeach
            <td class="align-middle">
              <span class="mt">
                {{ number_format($sum_cheques,2,"," ," ") }} dh
              </span>
            </td>
          </tr>

          {{-- montant chèques payé --}}
          {{-- index : 6 --}}
          <tr>
            <td class="align-middle table-success fw-bold">
              chèques payé
            </td>
            @php
              $sum_chequesPayer = 0;
            @endphp
            @foreach ($months as $k => $row)
              <td class="align-middle">
                <span class="mt">
                    @php
                        $arr = explode(' - ', $row);
                        $cheque_payer = $arr[6] ?? ''; //
                        $sum_chequesPayer += $arr[6] ?? ''; //
                    @endphp
                    {{ number_format($cheque_payer , 2 , "," ," ") . " dh" }}
                </span>
              </td>
            @endforeach
            <td class="align-middle">
              <span class="mt">
                {{ number_format($sum_chequesPayer,2,"," ," ") }} dh
              </span>
            </td>
          </tr>

          {{-- montant chèques impayé --}}
          {{-- index : 7 --}}
          <tr>
            <td class="align-middle table-success fw-bold">
              chèques impayé
            </td>
            @php
                $sum_chequeImpayer = 0;
            @endphp
            @foreach ($months as $k => $row)
              <td class="align-middle">
                <span class="mt">
                    @php
                        $arr = explode(' - ', $row);
                        $cheque_impayer = $arr[7] ?? ''; //
                        $sum_chequeImpayer += $arr[7] ?? ''; //
                    @endphp
                    {{ number_format($cheque_impayer , 2 , "," ," ") . " dh" }}
                </span>
              </td>
            @endforeach
            <td class="align-middle">
              <span class="mt">
                {{ number_format($sum_chequeImpayer,2,"," ," ") }} dh
              </span>
            </td>
          </tr>



        </tbody>

      </table>
    </div>
  </div>
</div>
@endsection