@php
    $facture = \App\Models\Facture::find($id);
@endphp
<div class="row justify-content-center">
  <div class="col-lg-3">
    <h5 class="title text-center border-bottom border-primary border-3 border-solid">
      base information
    </h5>
  </div>
</div>
<div class="card">
  <div class="card-body p-2">
    <div class="row row-cols-md-2 row-cols-1 my-2">
      <div class="col mb-md-0 mb-2">
        <div class="table-reponsive">
          <table class="table table-bordered m-0 info">
            <tbody>
              <tr>
                <td class="align-middle">prix ht</td>
                <td class="align-middle">
                  {{ number_format($facture->ht , 2 , "," , " ") }} dh
                </td>
              </tr>
              <tr>
                <td class="align-middle">prix ttc</td>
                <td class="align-middle">
                  {{ number_format($facture->ttc , 2 , "," , " ") }} dh
                </td>
              </tr>
              <tr>
                <td class="align-middle">remise</td>
                <td class="align-middle">
                  {{ number_format($facture->remise , 2 , "," , " ") }} %
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col">
        <div class="table-reponsive">
          <table class="table table-bordered m-0 info">
            <tbody>
              <tr>
                <td class="align-middle">net à payer</td>
                <td class="align-middle">
                  {{ number_format($facture->net_payer , 2 , "," , " ") }} dh
                </td>
              </tr>
              <tr>
                <td class="align-middle">payer</td>
                <td class="align-middle">
                  {{ number_format($facture->payer , 2 , "," , " ") }} dh

                </td>
              </tr>
              <tr>
                <td class="align-middle">reste</td>
                <td class="align-middle">
                  {{ number_format($facture->reste , 2 , "," , " ") }} dh

                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    </div>
  </div>

