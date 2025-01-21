@extends('layouts.master')
@section('title')
Liste des factures
@endsection
@section('content')
@include('sweetalert::alert')
<div class="d-flex justify-content-between align-items-center">
  <h4 class="title">
    liste des commandes
  </h4>
  <div class="">
    @can('facture-nouveau')
      <a href="{{ route('facture.create') }}" class="btn btn-header px-4 rounded waves-effect waves-light">
        <span class="mdi mdi-plus-thick"></span>
      </a>
    @endcan
    @can('facture-list')
      <a href="{{ route('facture.today') }}" class="btn btn-header px-4 rounded waves-effect waves-light">
        <span class="mdi mdi-calendar-check-outline"></span>
      </a>
    @endcan
  </div>
</div>
<div class="card">
  <div class="card-body p-2">
    <div class="table-responsive">
      <table class="table table-bordered mb-0 table-sm" id="dt">
        <thead class="table-success">
          <tr>
            <th>#ID</th>
            <th>Numero du facture</th>
            <th>Raison sociale</th>
            <th>Date du facture</th>
            <th>Prix HT</th>
            <th>net à payer</th>
            <th>payer</th>
            <th>reste</th>
            <th>délai</th>

            @canany(['facture-modification', 'facture-display', 'facture-suppression'])
              <th>Actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @forelse ($factures as $k => $facture)
            <tr>
              <td class="align-middle">
                  {{"#" . $facture->id ?? '' }}
              </td>
              <td class="align-middle">
                  {{ $facture->num ?? '' }}
              </td>
              <td class="align-middle">
                {{ $facture->client->raison_sociale }}
              </td>
              <td class="align-middle">
                {{ $facture->date_facture ?? '' }}
              </td>
              <td class="align-middle">
                <span class="fw-bold mt">
                  {{ number_format($facture->ht , 2 , ',' , ' ')." DHS" }}
                </span>
              </td>
              <td class="align-middle">
                <span class="fw-bold text-primary mt">
                  {{ number_format($facture->net_payer , 2 , ',' , ' ')." DHS" }}
                </span>
              </td>
              <td class="align-middle">
                <span class="fw-bold text-success mt">
                  {{ number_format($facture->payer , 2 , ',' , ' ')." DHS" }}
                </span>
              </td>
              <td class="align-middle">
                <span class="fw-bold text-danger mt">
                  {{ number_format($facture->reste , 2 , ',' , ' ')." DHS" }}
                </span>
              </td>




              <td class="align-middle">
                @if ($facture->delai == 0)
                <span class="badge bg-success">aujourd'hui</span>
                @else
                {{ $facture->delai }} jours
                @endif
              </td>

              @canany(['facture-display','facture-modification','ligneAvoire-nouveau'])
                <td class="align-middle">

               
                    @if ($facture->client->deleted_at == null)
                      @can('facture-display')
                      <a href="{{ route('facture.showPdf',$facture) }}" class="btn btn-primary waves-effect waves-light p-icon">
                          <span class="mdi mdi-file-outline align-middle"></span>
                      </a>

                        <a href="{{ route('facture.show',$facture) }}" class="btn btn-warning waves-effect waves-light p-icon">
                          <i class="mdi mdi-eye-outline align-middle"></i>
                        </a>
                      @endcan
                      
                      @if ($facture->reste != 0)
                        @can('facturePaiement-nouveau')
                          <a href="{{ route('facturePaiement.add',$facture->id) }}" class="btn btn-success waves-effect waves-light p-icon">
                            <span class="mdi mdi-plus-thick align-middle"></span>
                          </a>
                        @endcan
                      @endif
                  @else
                    <button type="button" class="btn btn-danger p-icon waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#warn{{ $k }}">
                    <i class="mdi mdi-alert-outline align-middle"></i>
                  </button>
                  <div class="modal fade" id="warn{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-body">
                          <div class="text-center text-danger">
                            <span class="mdi mdi-alert-outline mdi-48px"></span>
                          </div>

                          <h6 class="text-center text-primary">
                            Le client : {{ $facture->client->raison_sociale }} a été suppression
                          </h6>
                          <p class="text-center fw-bold">
                            Il ne peux pas faire des modification pour la commande
                          </p>
                          <div class="row justify-content-center mt-4">
                            <div class="col-lg-5">
                              <button type="button" class="btn btn-bleu waves-effect waves-light py-3 w-100" data-bs-dismiss="modal" aria-label="btn-close">
                                Annuler
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
                </td>
              @endcanany
            </tr>
          @empty

          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection


@section('script')
<script>
 $(document).ready(function() {
    $('#dt').DataTable({
        "columnDefs": [
            {
                "targets": 0, // Assuming the ID column is the first column (index 0)
                "type": "num" // Forces numeric sorting
            }
        ]
    });

});

</script>
@endsection
