@extends('layouts.master')
@section('title')
  liste des stocks ( depôts )
@endsection
@section('content')
@include('sweetalert::alert')
  <h4 class="title">
    liste des stocks ( depôts )
  </h4>
  <div class="card">
    <div class="card-body p-2">
      <div class="table-responsive">
        <table class="table table-bordered m-0 table-customize">
          <thead>
            <tr>
              <th>depot</th>
              <th>stock</th>
              <th>produit</th>
              <th>quantite</th>
              <th>disponible</th>
              <th>default</th>
              <th>default</th>
              @canany(['stockDepot-display', 'stockDepot-modification'])
                <th>actions</th>
              @endcanany
            </tr>
          </thead>
          <tbody>
            @foreach ($stock_depots as $k => $stock_dep)
              <tr>
                <td class="align-middle">
                  {{ $stock_dep->depot->num_depot }}
                </td>
                <td class="align-middle">
                  {{ $stock_dep->stock->num }}
                </td>
                <td class="align-middle">
                  {{ $stock_dep->stock->produit->designation }}
                </td>
                <td class="align-middle">
                  {{ $stock_dep->quantite }}
                </td>
                <td class="align-middle">
                  {{ $stock_dep->disponible }}
                </td>
                <td class="align-middle">
                  {!! $stock_dep->check_default == 1 ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close-thick text-danger"></span>' !!}
                </td>
                <td class="align-middle">
                  {!! $stock_dep->statut == "active" ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close-thick text-danger"></span>' !!}

                </td>
                @canany(['stockDepot-display','stockDepot-modification'])
                  <td class="align-middle">
                    @can('stockDepot-display')
                      <a href="{{ route('stockDepot.show',$stock_dep) }}" class="btn btn-primary p-icon waves-effect waves-light">
                        <span class="mdi mdi-eye-outline"></span>
                      </a>
                    @endcan
                    @can("stockDepot-modification")
                      @if ($stock_dep->statut == "active" )
                        <button type="button" class="btn btn-danger p-icon waves-effect waves-light shadow-none" data-bs-toggle="modal" data-bs-target="#inactive{{ $k }}">
                          <span class="mdi mdi-close-thick "></span>
                        </button>
                        <div class="modal fade" id="inactive{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-body">
                                <form action="{{ route('stockDepot.inactive',$stock_dep->id) }}" method="POST">
                                  @csrf
                                  @method("PUT")
                                  <div class="d-flex justify-content-center">
                                    <span class="mdi mdi-close-thick mdi-48px text-danger"></span>
                                  </div>
                                  <h6 class="mb-2 fw-bolder text-center">
                                    Êtes-vous sûr de vouloir désactivé de depôt  pour le stock ?
                                  </h6>
                                  <h6 class="text-primary mb-2 text-center">{{ $produit->reference ?? '' }}</h6>
                                  <div class="row justify-content-center">
                                    <div class="col-6">
                                      <button type="submit" class="btn btn-action waves-efect waves-light w-100">
                                        <span class="mdi mdi-check-bold align-middle"></span>
                                        <span>
                                          Je confirme
                                        </span>
                                      </button>
                                    </div>
                                    <div class="col-6">
                                      <button type="button" class="btn btn-bleu waves-effect wave-light w-100" data-bs-dismiss="modal" aria-label="btn-close">
                                        <span class="mdi mdi-close align-middle"></span>
                                        Annuler
                                      </button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      @else
                        <button type="button" class="btn btn-success p-icon waves-effect waves-light shadow-none" data-bs-toggle="modal" data-bs-target="#active{{ $k }}">
                          <span class="mdi mdi-check-bold "></span>
                        </button>
                        <div class="modal fade" id="active{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-body">
                                <form action="{{ route('stockDepot.active',$stock_dep->id) }}" method="POST">
                                  @csrf
                                  @method("PUT")
                                  <div class="d-flex justify-content-center">
                                    <span class="mdi mdi-check-bold mdi-48px text-success"></span>
                                  </div>
                                  <h6 class="mb-2 fw-bolder text-center">
                                    Êtes-vous sûr de vouloir active de depôt  pour le stock ?
                                  </h6>
                                  <h6 class="text-primary mb-2 text-center">{{ $produit->reference ?? '' }}</h6>
                                  <div class="row justify-content-center">
                                    <div class="col-6">
                                      <button type="submit" class="btn btn-action waves-efect waves-light w-100">
                                        <span class="mdi mdi-check-bold align-middle"></span>
                                        <span>
                                          Je confirme
                                        </span>
                                      </button>
                                    </div>
                                    <div class="col-6">
                                      <button type="button" class="btn btn-bleu waves-effect wave-light w-100" data-bs-dismiss="modal" aria-label="btn-close">
                                        <span class="mdi mdi-close align-middle"></span>
                                        Annuler
                                      </button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                    @endif
                  @endcan
                  </td>
                @endcanany
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection