@extends('layouts.master')
@section('title')
  Liste des achats
@endsection
@section('content')
@include('sweetalert::alert')
<div class="d-flex justify-content-between align-items-center mb-2">
  <h4 class="title m-0">
    liste des achats
  </h4>
  @can('ligneAchat-nouveau')
  <a href="{{ route('ligneAchat.create') }}" class="btn btn-header px-4 waves-effect waves-light">
    <span class="mdi mdi-plus-thick"></span>
  </a>
  @endcan
</div>
<div class="card">
  <div class="card-body p-2">
    <div class="table-responsive">
      <table class="table table-bordered table-sm m-0" id="dt">
        <thead>
          <tr>
            <th>numero</th>
            <th>fournisseur</th>
            <th>date</th>
            <th>nombre.pro</th>
            <th>montant ht</th>
            <th>montant ttc</th>
            <th>payer</th>
            <th>reste</th>
            <th>statut</th>
            <th>délai</th>
            <th>date paiement</th>
            @canany(['ligneAchat-modification','ligneAchat-display'])
              <th>actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @forelse ($ligneAchats as $k => $ligne)
            <tr>
              <td class="align-middle"> {{ $ligne->num_achat ?? '' }} </td>
              <td class="align-middle">
                {!!
                  $ligne->fournisseur->deleted_at == null ?
                  $ligne->fournisseur->raison_sociale : '<i class="text-muted">' . $ligne->fournisseur->raison_sociale . '</i>'
                !!}
              </td>
              <td class="align-middle"> {{ $ligne->date_achat ?? '' }} </td>
              <td class="align-middle"> {{ $ligne->nombre_achats ?? '' }} </td>
              <td class="align-middle text-uppercase fw-bold">
                {{ number_format($ligne->ht , 2 , ',' , ' ') }} dh
              </td>
              <td class="align-middle text-uppercase fw-bold "> {{ number_format($ligne->ttc , 2 , ',' , ' ') }} dh </td>
              <td class="align-middle text-uppercase text-success fw-bold"> {{ number_format($ligne->payer , 2 , ',' , ' ') }} dh </td>
              <td class="align-middle text-uppercase text-danger fw-bold"> {{ number_format($ligne->reste , 2 , ',' , ' ') }} dh </td>
              <td class="align-middle">
                @if ($ligne->statut == "validé")
                <span class="badge bg-success">
                  <span class="mdi mdi-check"></span>
                  {{ $ligne->statut }}
                </span>
                @elseif ($ligne->statut == "en cours")
                  <span class="mdi mdi-progress-check mdi-18px text-warning"></span>
                @else
                <span class="mdi mdi-cancel text-danger"></span>
                @endif
              </td>
              <td class="align-middle">
                @if ($ligne->delai == 0)
                  <span class="badge bg-success">aujourd'hui</span>
                @else
                {{ $ligne->delai }} jours
                @endif
              </td>
              <td class="align-middle">
                {{ $ligne->date_paiement }}
              </td>
              @canany(['ligneAchat-modification','ligneAchat-display'])
                <td class="align-middle">
                  @if ($ligne->fournisseur->deleted_at == null)
                    @if ($ligne->statut == "en cours")
                      @can('ligneAchat-modification')
                        {{-- <button type="button" class="btn btn-success p-icon  shadow-none" data-bs-toggle="modal" data-bs-target="#valider{{ $ligne->id }}">
                          <span class="mdi mdi-check-bold "></span>
                        </button>
                        <div class="modal fade" id="valider{{ $ligne->id }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                            <div class="modal-content">

                              <div class="modal-body">
                                <div class="d-flex justify-content-center">
                                  <span class="mdi mdi-check-circle-outline mdi-48px text-success"></span>
                                </div>
                                <form action="{{ route('ligneAchat.valider',$ligne) }}" method="post">
                                  @csrf
                                  @method("PUT")
                                  <h5 class="text-primary mb-2 text-center">Valider la facture séléctionner ?</h5>
                                  <h6 class="text-danger mb-2 text-center">{{ $ligne->num_achat ?? '' }}</h6>
                                  <h6 class="mb-3">Attention une fois validée , l'achat ne peux pas plus modifiables !</h6>
                                  <div class="row justify-content-center">
                                    <div class="col-6">
                                      <button type="submit" class="btn btn-action waves-effect waves-light w-100">
                                        Validé
                                      </button>
                                    </div>
                                    <div class="col-6">
                                      <button type="button" class="btn btn-bleu waves-effect waves-light w-100" data-bs-dismiss="modal" aria-label="btn-close">
                                        Annuler
                                      </button>
                                    </div>
                                  </div>
                                </form>

                              </div>
                            </div>
                          </div>
                        </div> --}}
                        <a href="{{ route('ligneAchat.checkDepot',$ligne) }}" class="btn btn-success p-icon  shadow-none">
                          <span class="mdi mdi-check-bold "></span>
                        </a>

                        <a href="{{ route('ligneAchat.edit',$ligne) }}" class="btn btn-primary p-icon  shadow-none">
                            <span class="mdi mdi-pencil-outline"></span>
                        </a>

                      @endcan

                      @can('ligneAchat-display')
                        <a href="{{ route('ligneAchat.demandePrice',$ligne) }}" class="btn btn-dark waves-effect waves-light p-icon " target="_blank">
                          <span class="mdi mdi-file-outline"></span>
                        </a>
                      @endcan
                    @else
                      @can('ligneAchat-display')
                        <a href="{{ route('ligneAchat.bon',$ligne) }}" class="btn btn-dark waves-effect waves-light p-icon " target="_blank">
                          <span class="mdi mdi-file-outline"></span>
                        </a>
                      @endcan
                      @can('achatPaiement-nouveau')
                        <a href="{{ route('achatPaiement.add',$ligne->id) }}" class="btn btn-success waves-effect waves-light p-icon ">
                          <span class="mdi mdi-plus-thick"></span>
                        </a>
                      @endcan
                    @endif
                  @else
                    <button type="button" class="btn btn-danger p-icon  waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#warn{{ $k }}">
                      <i class="mdi mdi-alert-outline"></i>
                    </button>
                    <div class="modal fade" id="warn{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-body">
                            <div class="text-center text-danger">
                              <span class="mdi mdi-alert-outline mdi-48px"></span>
                            </div>
                            <h5 class="text-center">
                              Le fournisseur <span class="text-danger"> {{ $ligne->fournisseur->raison_sociale }} </span> a été supprimer
                            </h5>

                            <div class="row justify-content-center mt-4">

                              <div class="col-lg-5">
                                <button type="button" class="btn btn-bleu waves-effect waves-light py-3 w-100" data-bs-dismiss="modal" aria-label="btn-close">
                                  fermer
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endif
                  @can('ligneAchat-display')
                    <a href="{{ route('ligneAchat.show',$ligne) }}" class="btn btn-warning p-icon  waves-effect waves-light">
                      <span class="mdi mdi-eye-outline "></span>
                    </a>
                  @endcan
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