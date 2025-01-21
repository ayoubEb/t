@extends('layouts.master')
@section('title')
Liste des factures
@endsection
@section('content')
@include('sweetalert::alert')
<div class="d-flex justify-content-between">
  <h6 class="title">
    liste des commandes
  </h6>
  <div class="">
    @can('facture-nouveau')
      <a href="{{ route('facture.create') }}" class="btn btn-header px-3 py-1 rounded-pill waves-effect waves-light">
        <span class="mdi mdi-plus-thick mdi-18px"></span>
      </a>
    @endcan
    @can('facture-list')
      <a href="{{ route('facture.index') }}" class="btn btn-header px-3 py-1 rounded-pill waves-effect waves-light">
        <span class="mdi mdi-menu mdi-18px"></span>
      </a>
      <a href="{{ route('facture.create') }}" class="btn btn-header px-3 py-1 rounded-pill waves-effect waves-light">
        <span class="mdi mdi-calendar-check-outline mdi-18px"></span>
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
            <th>Prix TTC</th>
            <th>net à payer</th>
            <th>payer</th>
            <th>reste</th>
            <th>Taux TVA</th>
            <th>Remise</th>
            <th>Statut</th>
            <th>retour</th>
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
                <span class="fw-bold mt">
                  {{ number_format($facture->ttc , 2 , ',' , ' ')." DHS" }}
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
                {{ $facture->taux_tva ?? '0' }} %
              </td>
              <td class="align-middle">
                {{ $facture->remise }} %
              </td>
              <td class="align-middle">
                <span @class([
                  "badge",
                  "bg-warning"=>$facture->status == "en cours",
                  "bg-success"=>$facture->status == "validé",
                  "bg-danger"=>$facture->status == "annuler",
                ])>
                  {{ $facture->status }}
                </span>
              </td>
              <td class="align-middle">
                {!! $facture->etat_retour != 1 ? '<span class="text-danger mdi mdi-close"></span>' : '<span class="text-success mdi mdi-check-bold"></span>'  !!}
              </td>
              @canany(['facture-display','facture-modification','ligneAvoire-nouveau'])
                <td class="align-middle">

                  @if ($facture->client->deleted_at == null)
                    @if ($facture->status == "validé")
                      @can('ligneAvoire-nouveau')
                        @if ( $facture->etat_retour == 0 )
                          <a href="{{ route('facture.addRetour',$facture) }}" class="btn btn-secondary waves-effect waves-light p-0 px-1">
                              <span class="mdi mdi-restore"></span>
                          </a>
                        @endif
                      @endcan

                      @can('facture-display')
                        @if (!isset($facture->adresse_livraison))
                          <a href="{{ route('facture.addLivraison',$facture) }}" class="btn btn-dark waves-effect waves-light p-0 px-1">
                            <span class="mdi mdi-truck-delivery-outline"></span>
                          </a>
                        @else
                          <button type="button" class="btn btn-dark waves-effect waves-light p-0 px-1" data-bs-toggle="modal" data-bs-target="#displayAdresse{{ $facture->id }}">
                            <span class="mdi mdi-truck-check-outline"></span>
                          </button>
                          <div class="modal fade modal-lg" id="displayAdresse{{ $facture->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-body p-2">
                                  <div class="table-repsonsive">
                                    <table class="table table-bordered m-0 info">
                                      <tbody>
                                        <tr>
                                          <td class="align-middle">
                                            libellé
                                          </td>
                                          <td class="align-middle">
                                            {{
                                              $facture->adresse_livraison &&
                                              $facture->adresse_livraison->livraison &&
                                              $facture->adresse_livraison->livraison->libelle != '' ?
                                              $facture->adresse_livraison->livraison->libelle : ''
                                            }}
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="align-middle">
                                            ville
                                          </td>
                                          <td class="align-middle">
                                            {{
                                              $facture->adresse_livraison &&
                                              $facture->adresse_livraison->livraison &&
                                              $facture->adresse_livraison->livraison->ville != '' ?
                                              $facture->adresse_livraison->livraison->ville : ''
                                            }}
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="align-middle">
                                            adresse
                                          </td>
                                          <td class="align-middle">
                                            {{
                                              $facture->adresse_livraison &&
                                              $facture->adresse_livraison->adresse != '' ?
                                              $facture->adresse_livraison->adresse : ''
                                            }}
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="align-middle">
                                            status
                                          </td>
                                          <td class="align-middle">
                                            {{
                                              $facture->adresse_livraison &&
                                              $facture->adresse_livraison->statut_livraison != '' ?
                                              $facture->adresse_livraison->statut_livraison : ''
                                            }}
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="align-middle">
                                            date
                                          </td>
                                          <td class="align-middle">
                                            {{
                                              $facture->adresse_livraison &&
                                              $facture->adresse_livraison->date_livraison != '' ?
                                              $facture->adresse_livraison->date_livraison : ''
                                            }}
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="align-middle">
                                            montant
                                          </td>
                                          <td class="align-middle">
                                            {{
                                              $facture->adresse_livraison &&
                                              $facture->adresse_livraison->montant != '' ?
                                              number_format($facture->adresse_livraison->montant , 2 , "," , " ") . " dh" : ''
                                            }}
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                  <div class="row row-cols-md-3 row-cols-1 mt-2">
                                    <div class="col mb-md-0 mb-2">
                                      <a href="{{ route('facture.bonLivraison',$facture) }}" target="_blank" class="btn btn-doc waves-effect waves-light w-100" target="_blank">
                                        document pdf
                                        <span class="mdi mdi-share-outline align-middle"></span>
                                      </a>
                                    </div>
                                    <div class="col mb-md-0 mb-2">
                                      <a href="{{ route('factureLivraison.edit',$facture->adresse_livraison) }}" class="btn btn-lien waves-effect waves-light w-100">
                                        modification
                                        <span class="mdi mdi-share-outline align-middle"></span>
                                      </a>
                                    </div>
                                    <div class="col mb-md-0 mb-2">
                                      <button type="button" class="btn btn-bleu waves-effect waves-light w-100" data-bs-dismiss="modal" aria-label="btn-close">
                                        fermer
                                      </button>
                                    </div>

                                  </div>

                                </div>
                              </div>
                            </div>
                          </div>
                        @endif


                      @endcan
                    @else
                      @can('facture-modification')
                        <a href="{{ route('facture.edit',$facture->id) }}" class="{{ $facture->status == "validé" ? 'd-none':'' }} btn btn-primary waves-effect waves-light p-0 px-1">
                            <span class="mdi mdi-pencil"></span>
                        </a>
                        <button type="button" class="btn btn-success waves-effect waves-light p-0 px-1" data-bs-toggle="modal" data-bs-target="#validation{{ $facture->id }}">
                          <span class="mdi mdi-check-bold"></span>
                        </button>
                        <div class="modal fade" id="validation{{ $facture->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-body p-4">
                                <form action="{{ route('facture.valider',$facture) }}" method="post">
                                  @csrf
                                  @method("PUT")
                                  <h5 class="text-primary mb-2 text-center">Valider la facture séléctionner ?</h5>
                                  <h6 class="text-danger mb-2 text-center">{{ $facture->num ?? '' }}</h6>
                                  <h6 class="mb-3">Attention une fois validée , la facture ne peux pas plus modifiables !</h6>
                                  <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-action waves-effect waves-light px-5 me-2">
                                      Validé
                                    </button>
                                    <button type="button" class="btn btn-bleu waves-effect waves-light px-5" data-bs-dismiss="modal" aria-label="btn-close">
                                      Annuler
                                    </button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endcan
                    @endif

                    @if ($facture->reste != 0)
                      @can('facturePaiement-nouveau')
                        <a href="{{ route('facture.newPaiement',$facture->id) }}" class="btn btn-success waves-effect waves-light p-0 px-1">
                          <span class="mdi mdi-plus-thick"></span>
                        </a>
                      @endcan
                    @endif

                    @can('facture-display')
                      <button type="button" class="btn btn-success waves-effect waves-light p-0 px-1" data-bs-toggle="modal" data-bs-target="#files{{ $facture->id }}">
                        <span class="mdi mdi-file"></span>
                      </button>
                      <div class="modal fade modal-md" id="files{{ $facture->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body p-2">
                              <a href="{{ route('facture.devis',$facture) }}" class="btn btn-doc waves-effect aves-light mb-2 w-100" target="_blank">
                                devis
                                <span class="mdi mdi-share-outline align-middle"></span>
                              </a>
                              <a href="{{ route('facture.preforma',$facture) }}" class="btn btn-doc waves-effect aves-light mb-2 w-100" target="_blank">
                                préforma
                                <span class="mdi mdi-share-outline align-middle"></span>
                              </a>
                              @if (isset($facture->adresse_livraison))
                              <a href="{{ route('facture.bonLivraison',$facture) }}" class="btn btn-doc waves-effect aves-light mb-2 w-100" target="_blank">
                                bon livraison
                                <span class="mdi mdi-share-outline align-middle"></span>
                              </a>
                              @endif
                              @if ($facture->etat_retour == 1)
                              <a href="{{ route('ligneAvoire.pdf',$facture->ligne_avoire) }}" class="btn btn-doc waves-effect aves-light mb-2 w-100" target="_blank">
                                avoire
                                <span class="mdi mdi-share-outline align-middle"></span>
                              </a>
                              @endif
                              @if ($facture->status == "validé")
                              <a href="{{ route('facture.showPdf',$facture) }}" class="btn btn-doc waves-effect aves-light mb-2 w-100" target="_blank">
                                facture
                                <span class="mdi mdi-share-outline align-middle"></span>
                                </a>
                              @endif
                              <div class="d-flex justify-content-center mt-2">

                                <button type="button" class="btn btn-bleu waves-effect waves-light px-5" data-bs-dismiss="modal" aria-label="btn-close">
                                  Annuler
                                </button>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <a href="{{ route('facture.show',$facture) }}" class="btn btn-warning waves-effect waves-light p-0 px-1">
                        <i class="mdi mdi-eye-outline"></i>
                      </a>
                    @endcan
                  @else
                    <button type="button" class="btn btn-danger p-0 px-1 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#warn{{ $k }}">
                    <i class="mdi mdi-alert-outline"></i>
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
                            Il ne peux pas faire des modification pour {{ $facture->status == "en cours" ? "devis" : "facture" }} .
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
