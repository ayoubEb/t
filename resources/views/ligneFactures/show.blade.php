@extends('layouts.master')
  @section('title')
      Facture : {{ $facture->num }}
  @endsection
@section('content')
  @include('sweetalert::alert')
  @if ($facture->client->deleted_at == null)

      <div class="col mb-2">
        <a href="{{ route('facture.showPdf',$facture) }}" class="btn btn-doc waves-effect waves-light" target="_blank">
          <span class="mdi mdi-file-outline align-middle"></span>
          facture
        </a>
      </div>




  @endif
  @include('ligneFactures.minInfo',["id"=>$facture->id])
  <div class="row justify-content-center">
    <div class="col-lg-3">
      <h5 class="title text-center border-bottom border-primary border-3 border-solid">
        détails
      </h5>
    </div>
  </div>
  <div class="card">
    <div class="card-body p-2">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs nav-justified" role="tablist">
        <li class="nav-item">
          <a class="nav-link @if(!Session::has('sup')) active @endif text-uppercase fw-bold" data-bs-toggle="tab" href="#infoFacture" role="tab">
            <span class="d-md-block d-none">information</span>
            <span class="d-md-none d-block mdi mdi-information-outline mdi-18px"></span>
          </a>
        </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#produits" role="tab">
              <span class="d-md-block d-none">produits</span>
              <span class="d-md-none d-block mdi mdi-cube-outline mdi-18px"></span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link @if(Session::has('sup')) active @endif" data-bs-toggle="tab" href="#paiements" role="tab">
              <span class="d-md-block d-none">paiements</span>
              <span class="d-md-none d-block mdi mdi-currency-usd mdi-18px"></span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#history" role="tab">
              <span class="d-md-block d-none">historiques</span>
              <span class="d-md-none d-block mdi mdi-history mdi-18px"></span>
            </a>
          </li>

      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        {{-- content détails --}}
        <div class="tab-pane @if(!Session::has('sup')) active @endif p-0 pt-3" id="infoFacture" role="tabpanel">
          <div class="row row-cols-md-2 row-cols-1">
            <div class="col mb-md-0 mb-2">
              <div class="table-responisve">
                <table class="table table-bordered m-0 info">
                  <tbody>
                    <tr>
                      <td class="align-middle">
                        référence
                      </td>
                      <td class="align-middle">
                        {{$facture->num}}
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle">
                        entreprise
                      </td>
                      <td class="align-middle">
                        {{
                          $facture->entreprise &&
                          $facture->entreprise->raison_sociale != '' ?
                          $facture->entreprise->raison_sociale : ''
                        }}
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle">
                        client
                      </td>
                      <td class="align-middle">
                        {{
                          $facture->client &&
                          $facture->client->raison_sociale != '' ?
                          $facture->client->raison_sociale : ''
                        }}
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle">
                        identifiant client
                      </td>
                      <td class="align-middle">
                        {{
                          $facture->client &&
                          $facture->client->identifiant != '' ?
                          $facture->client->identifiant : ''
                        }}
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle">
                        date du facture
                      </td>
                      <td class="align-middle">
                        {{ $facture->date_facture}}
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>
            <div class="col">
              <div class="table-responsive">
                <table class="table table-bordered m-0 info">
                  <tbody>


                    <tr>
                      <td class="align-middle">
                        taux tva
                      </td>
                      <td class="align-middle">
                        {{ $facture->taux_tva}} %
                      </td>
                    </tr>


                    <tr>
                      <td class="align-middle">
                        date création
                      </td>
                      <td class="align-middle">
                        {{ $facture->dateCreation}}
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle">
                        nombre produits
                      </td>
                      <td class="align-middle">
                        {{ $facture->nbrProduits}}
                      </td>
                    </tr>

                    <tr>
                      <td class="align-middle">
                        statut
                      </td>
                      <td class="align-middle">

                          <span class="text-success align-middle mdi mdi-check-bold"></span>
                          <span class="fw-bold text-success mt">
                            {{ $facture->statut }}
                          </span>

                      </td>
                    </tr>





                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        {{-- content des produits --}}
        <div class="tab-pane p-0 pt-3" id="produits" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-striped table-customize m-0">
              <thead class="">
                <tr>
                  <th>référence</th>
                  <th>désignation</th>
                  <th>quantité</th>
                  <th>reste</th>
                  <th>retour</th>
                  <th>remise</th>
                  <th>prix vente</th>
                  <th>montant</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($produits as $facture_produit)
                  <tr>
                    <td class="align-middle">{{ $facture_produit->produit->reference ?? '' }} </td>
                    <td class="align-middle">{{ $facture_produit->produit->designation ?? '' }} </td>
                    <td class="align-middle">{{ $facture_produit->quantite ?? '' }}</td>
                    <td class="align-middle">{{ $facture_produit->produit->reste ?? '' }}</td>
                    <td class="align-middle">{{ $facture_produit->qte_retour ?? '' }}</td>
                    <td class="align-middle">
                      <span class="mt fw-bold">
                        {{ number_format($facture_produit->remise,2,","," ") }} %
                      </span>
                    </td>
                    <td class="align-middle">
                      <span class="mt fw-bold">
                        {{ number_format($facture_produit->prix,2,","," ") }} DH
                      </span>
                    </td>
                    <td class="align-middle">
                      <span class="mt fw-bold">
                        {{ number_format($facture_produit->montant,2,","," ") }} DH
                      </span>
                    </td>

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        {{-- content les paiements --}}
        <div class="tab-pane p-0 pt-3 @if(Session::has('sup')) active @endif" id="paiements" role="tabpanel">
          <div class="table-repsonsive">
            <table class="table table-striped table-sm m-0">
              <thead class="table-primary">
                <tr>
                  <th>Type</th>
                  <th>payer</th>
                  <th>date</th>
                  <th>actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($paiements as $facture_paiement)
                  <tr>
                    <td class="align-middle text-capitalize">
                      @if ($facture_paiement->type_paiement == "chèque")
                        <button type="button" class="btn p-0 bg-transparent border-0 text-primary" data-bs-toggle="modal" data-bs-target="#paiementCheque{{ $facture_paiement->id }}">
                            chèque
                        </button>
                      @else
                        {{ $facture_paiement->type_paiement }}
                      @endif
                    </td>
                    <td class="align-middle">
                      <span class="mt fw-bold">
                        {{ number_format($facture_paiement->payer , 2 , ","," ") }} DH
                      </span>
                    </td>
                    <td class="align-middle">
                      {{ $facture_paiement->date_paiement }}
                    </td>
                    @can('suivi-suppression')
                    <td class="align-middle">
                        <button type="button" class="btn btn-danger waves-effect waves-light p-0 px-1" data-bs-toggle="modal" data-bs-target="#delete{{ $facture_paiement->id }}">
                          <span class="mdi mdi-trash-can"></span>
                        </button>
                        <div class="modal fade" id="delete{{ $facture_paiement->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-body">
                                <form action="{{ route('suivi.destroy',$facture_paiement) }}" method="POST">
                                  @csrf
                                  @method("DELETE")
                                  <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>
                                  <h6 class="mb-2 fw-bolder text-center text-muted">Voulez-vous supprimer défenitivement du paiement</h6>
                                  <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-action waves-effect waves-light me-2">
                                        Je confirme
                                    </button>

                                    <button  type="button" class="btn btn-bleu waves-effect waves-light px-5" data-bs-dismiss="modal" aria-label="btn-close" data-bs-toggle="modal" data-bs-target="#historyPaiement{{ $facture_paiement->facture->id }}">
                                        fermer
                                    </button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>

                        <a href="{{ route('suivi.recu',$facture_paiement) }}" class="btn btn-primary waves-effect waves-light p-0 px-1" target="_blank">
                          <span class="mdi mdi-file"></span>
                        </a>
                      </td>
                    @endcan
                  </tr>

                  <div class="modal fade" id="paiementCheque{{ $facture_paiement->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header py-2 bg-primary">
                          <h6 class="modal-title m-0 text-white" id="varyingModalLabel">Chèque : {{ $facture_paiement->cheque->numero ?? '' }}</h6>
                          <button type="button" class="btn btn-transparent p-0 text-white border-0" data-bs-dismiss="modal" aria-label="btn-close">
                            <span class="mdi mdi-close-thick"></span>
                          </button>
                        </div>
                        <div class="modal-body p-2">
                          <ul class="list-group">
                            <li class="list-group-item py-2">
                              <h6 class="m-0 fs-12 text-uppercase">
                                <span class="float-start">numéro</span>
                                <span class="float-end"> {{ $facture_paiement->cheque->numero ?? '' }} </span>
                              </h6>
                            </li>
                            <li class="list-group-item py-2">
                              <h6 class="m-0 fs-12 text-uppercase">
                                <span class="float-start">nom bancaire</span>
                                <span class="float-end"> {{ $facture_paiement->cheque->bancaire->nom_bank ?? '' }} </span>
                              </h6>
                            </li>
                            <li class="list-group-item py-2">
                              <h6 class="m-0 fs-12 text-uppercase">
                                <span class="float-start">date chèque</span>
                                <span class="float-end"> {{ $facture_paiement->cheque->date_cheque ?? '' }} </span>
                              </h6>
                            </li>
                            <li class="list-group-item py-2">
                              <h6 class="m-0 fs-12 text-uppercase">
                                <span class="float-start">date enquisement</span>
                                <span class="float-end"> {{ $facture_paiement->cheque->date_enquisement ?? '' }} </span>
                              </h6>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>




                @empty
                  <tr>
                    <td class="align-middle" colspan="5">
                      <h6 class="text-center m-0 text-uppercase text-danger py-1 fs-12">
                          Aucun paiement enregistrer
                      </h6>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        {{-- content suivis --}}
        <div class="tab-pane p-0 pt-3 @if(Session::has('sup')) active @endif" id="history" role="tabpanel">
          @if (isset($facture_suivis))
            <div class="table-repsonsive">
              <table class="table table-customize m-0">
                <thead>
                  <tr>
                    <th>action</th>
                    <th>utilisateur</th>
                    <th>date</th>
                    <th>temps</th>
                    <th>valeurs</th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($facture_suivis as $suivi)
                    <tr>
                      <td class="align-middle">
                        @if ($suivi->event == "created")
                          <span class="bg-success px-2 py-1 rounded text-white fw-bold">
                              Nouveau
                          </span>
                        @elseif ($suivi->event == "deleted")
                          <span class="bg-danger px-2 py-1 rounded text-white fw-bold">
                              Suppression
                          </span>
                        @elseif ($suivi->event == "updated")
                          <span class="bg-primary px-2 py-1 rounded text-white fw-bold">
                              Modification
                          </span>
                        @endif
                      </td>
                      <td class="align-middle">
                      {{ $suivi->user }}
                      </td>
                      <td class="align-middle">
                      {{ date("d/m/Y",strtotime($suivi->created_at)) }}
                      </td>
                      <td class="align-middle">
                      {{ date("H:i:s",strtotime($suivi->created_at)) }}
                      </td>
                      <td class="align-middle">
                        <button type="button" class="btn btn-primary waves-effect waves-light p-0 px-1" data-bs-toggle="modal" data-bs-target="#display{{ $suivi->id }}">
                          <span class="mdi mdi-eye-outline"></span>
                        </button>
                        <div class="modal fade" tabindex="-1" id="display{{ $suivi->id }}" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                      </button>
                                  </div>
                                  <div class="modal-body p-2">
                                      @php
                                            $array_insert = [];
                                            $array_sup = [];
                                            if($suivi->event == "created" ){
                                                foreach($suivi->properties['attributes'] ?? [] as $attribute => $value){
                                                  if(!is_null($value)){
                                                    $array_insert[] = [
                                                      "champ"=>$attribute,
                                                      "value"=>$value,
                                                    ];
                                                  }
                                              }
                                            }
                                            elseif ($suivi->event == "deleted") {
                                              foreach($suivi->properties['old'] ?? [] as $attribute => $value){
                                                if(!is_null($value)){
                                                  $array_sup[] = [
                                                    "champ"=>$attribute,
                                                    "value"=>$value,
                                                  ];
                                                }
                                            }

                                            }
                                      @endphp
                                      @php
                                        $properties = json_decode($suivi->properties, true);
                                        $changedAttributes = [];


                                        if (isset($properties['old']) && isset($properties['attributes'])) {
                                            foreach ($properties['attributes'] as $key => $newValue) {
                                                if (isset($properties['old'][$key]) && $properties['old'][$key] != $newValue) {
                                                    $changedAttributes[$key] = [
                                                        'old' => $properties['old'][$key],
                                                        'new' => $newValue
                                                    ];
                                                }
                                            }
                                        }

                                        // dd($properties);
                                      @endphp
                                      @if (count($changedAttributes) > 0)
                                        @foreach($changedAttributes as $key => $values)
                                          @if(count($changedAttributes) > 0)
                                            <ul class="list-group">
                                              <li class="list-group-item active text-center py-2">
                                                <b>{{ ucfirst($key) }}</b>
                                              </li>
                                              <li class="list-group-item text-center py-2">
                                                <div class="row row-cols-2">
                                                  <div class="col">
                                                    <h6>
                                                      avant
                                                    </h6>
                                                  </div>
                                                  <div class="col">
                                                    <h6>
                                                      nouveau
                                                    </h6>
                                                  </div>
                                                </div>
                                              </li>
                                              <li class="list-group-item d-flex justify-content-evenly align-items-center py-2">
                                                @if(is_array($values['old']))
                                                    @foreach($values['old'] as $oldValue)
                                                        {{ $oldValue }}
                                                      @endforeach
                                                @else
                                                  {{ $values['old'] }}
                                                @endif
                                                <span class="mdi mdi-arrow-right-thick"></span>
                                                @if(is_array($values['new']))
                                                @foreach($values['new'] as $newValue)
                                                    {{ $newValue }}
                                                @endforeach
                                                  @else
                                                    {{ $values['new'] }}
                                                  @endif
                                              </li>
                                            </ul>

                                          @else
                                            <small>No changes recorded</small>
                                          @endif

                                        @endforeach
                                      @elseif($suivi->event == "created")
                                      <h6 class="text-center title">
                                        {{ $suivi->event }}
                                      </h6>
                                        <ul class="list-group">
                                          @foreach ($array_insert as $attribute)

                                            <li class="list-group-item">
                                              <strong>{{ $attribute['champ'] }} : </strong>
                                              {{ $attribute['value'] }}

                                            </li>



                                          @endforeach

                                        </ul>
                                      @elseif($suivi->event == "deleted")
                                        <h6 class="text-center title">
                                          {{ $suivi->event }}
                                        </h6>
                                        <ul class="list-group">
                                          @foreach ($array_sup as $attribute)
                                            <li class="list-group-item">
                                              <strong>{{ $attribute['champ'] }} : </strong>
                                              {{ $attribute['value'] }}
                                            </li>
                                          @endforeach
                                        </ul>

                                      @endif
                                  </div>
                              </div>
                              <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                      </div>
                      </td>
                    </tr>
                @endforeach
                </tbody>
              </table>
            </div>

          @endif
        </div>

      </div>
    </div>
  </div>






@endsection
