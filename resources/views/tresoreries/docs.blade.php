<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./css/rapport.css">
  <title>plan trésoririer : {{ date('Y') }}</title>
</head>
<body>
    <style>
        h6{
            text-align:center;
            margin-bottom:1rem;
            text-transform:uppercase;
            letter-spacing:1px;
        }
    </style>
    
    <h6>
        plan trésoririer : {{ date('Y') }}
    </h6>
<article>
  <table class="table table-bordered plan m-0">
    <thead class="bg-primary">

      <tr>
        <th></th>
        @foreach ($months as $k => $row)
        <th class="">
          {{ $k }}
        </th>
        @endforeach
        <th>
          {{ date("Y") }}
        </th>
      </tr>
    </thead>
 <tbody>

          {{-- motants --}}
          {{-- montant ttc commande --}}
          {{-- index : 0 --}}
          <tr>
            <td style="background:wheat;">
              montant ttc
            </td>
            @php
                $sum_ttc = 0;
            @endphp
            @foreach ($months as $k => $row)
              <td>
                @php
                  $arr = explode(' - ', $row);
                  $cmd_ttc = $arr[0] ?? ''; //
                  $sum_ttc += $arr[0];
                @endphp
                {{ number_format($cmd_ttc , 2 , "," ," ") . " dh" }}
              </td>
            @endforeach
            <td>
              <span class="mt">
                {{ number_format($sum_ttc,2,"," ," ") }} dh
              </span>
            </td>
          </tr>

          {{-- montant net à payer commande --}}
          {{-- index : 1 --}}
          <tr>
            <td class="">
              net à payer
            </td>
            @php
                $sum_netPayer = 0;
            @endphp
            @foreach ($months as $k => $row)
              <td>
                @php
                    $arr = explode(' - ', $row);
                    $cmd_netPayer = $arr[1] ?? ''; //
                    $sum_netPayer += $arr[1];
                @endphp
                {{ number_format($cmd_netPayer , 2 , "," ," ") . " dh" }}
              </td>
            @endforeach
            <td>
              <span class="mt">
                {{ number_format($sum_netPayer,2,"," ," ") }} dh
              </span>
            </td>
          </tr>

          {{-- montant payer commande --}}
          {{-- index : 2 --}}
          <tr>
            <td class="">
              payer
            </td>
            @php
                $sum_payer = 0;
            @endphp
            @foreach ($months as $k => $row)
              <td>
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
            <td>
              <span class="mt">
                {{ number_format($sum_payer,2,"," ," ") }} dh
              </span>
            </td>
          </tr>

          {{-- montant reste commande --}}
          {{-- index : 3 --}}
          <tr>
            <td class="">
              reste
            </td>
            @php
                $sum_reste = 0;
            @endphp
            @foreach ($months as $k => $row)
              <td>
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
            <td>
              <span class="mt">
                {{ number_format($sum_reste,2,"," ," ") }} dh
              </span>
            </td>
          </tr>


          {{-- montant espèces --}}
          {{-- index : 4 --}}
          <tr>
            <td class="">
              espèces
            </td>
            @php
                $sum_especes = 0;
            @endphp
            @foreach ($months as $k => $row)
              <td>
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
            <td>
              <span class="mt">
                {{ number_format($sum_especes,2,"," ," ") }} dh
              </span>
            </td>
          </tr>

          {{-- montant chèques --}}
          {{-- index : 5 --}}
          <tr>
            <td class="">
              chèques
            </td>
            @php
              $sum_cheques = 0;
            @endphp
            @foreach ($months as $k => $row)
              <td>
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
            <td>
              <span class="mt">
                {{ number_format($sum_cheques,2,"," ," ") }} dh
              </span>
            </td>
          </tr>

          {{-- montant chèques payé --}}
          {{-- index : 6 --}}
          <tr>
            <td class="">
              chèques payé
            </td>
            @php
              $sum_chequesPayer = 0;
            @endphp
            @foreach ($months as $k => $row)
              <td>
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
            <td>
              <span class="mt">
                {{ number_format($sum_chequesPayer,2,"," ," ") }} dh
              </span>
            </td>
          </tr>

          {{-- montant chèques impayé --}}
          {{-- index : 7 --}}
          <tr>
            <td class="">
              chèques impayé
            </td>
            @php
                $sum_chequeImpayer = 0;
            @endphp
            @foreach ($months as $k => $row)
              <td>
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
            <td>
              <span class="mt">
                {{ number_format($sum_chequeImpayer,2,"," ," ") }} dh
              </span>
            </td>
          </tr>



        </tbody>

  </table>
</article>

</body>
</html>