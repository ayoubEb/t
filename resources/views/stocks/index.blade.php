@extends('layouts.master')
@section('title')
Liste des stocks
@endsection
@section('content')
@include('sweetalert::alert')
<h4 class="title mb-3">
  liste des stocks
</h4>
  <div class="card">
    <div class="card-body p-2">
      <form action="{{ route('stock.reference') }}" method="GET" target="_blank">
        <div class="row mb-2">
          <div class="col-lg-3">
            <div class="form-group">
              <select name="reference" id="" class="form-control select2">
                <option value="">Choisir le code</option>
                @foreach ($references as $pro_reference)
                  <option value="{{ $pro_reference->reference }}"> {{ $pro_reference->reference }} </option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-2">
            <button type="submit" class="btn btn-primary py-1px">
              Rechercher
            </button>
          </div>
        </div>
      </form>
      <div class="table-responsive">
        <table class="table table-bordered table-customize m-0">
          <thead>
            <tr>
              <th>référence</th>
              <th>désignation</th>
              <th>quantite</th>
              <th>disponible</th>
              <th>quantite achat</th>
              <th>quantite vente</th>
              <th>quantite augmenter</th>
              <th>min</th>
              <th>max</th>
              <th>date création</th>
              @canany(['stock-display', 'stock-modficiation','stockHisorique-nouveau'])
                <th>actions</th>
              @endcanany
            </tr>
          </thead>
          <tbody>
            @forelse ($produits as $produit)
              <tr>
                <td class="align-middle">
                    {{ $produit->reference ?? '' }}
                </td>
                <td class="align-middle">
                    {{ $produit->designation ?? '' }}
                </td>
                <td class="align-middle">
                  {!!
                    $produit->quantite != '' ?
                    $produit->quantite : 0
                  !!}
                </td>
                <td class="align-middle">
                  {!!
                    $produit->stock &&
                    $produit->stock->disponible != '' ?
                    $produit->stock->disponible : 0
                  !!}
                </td>
                <td class="align-middle">
                  {!!
                    $produit->stock &&
                    $produit->stock->qte_achat != '' ?
                    $produit->stock->qte_achat : 0
                  !!}
                </td>
                <td class="align-middle">
                  {!!
                    $produit->stock &&
                    $produit->stock->qte_vente != '' ?
                    $produit->stock->qte_vente : 0
                  !!}
                </td>
                <td class="align-middle">
                  {!!
                    $produit->stock &&
                    $produit->stock->qte_augmenter != '' ?
                    $produit->stock->qte_augmenter : 0
                  !!}
                </td>

                <td class="align-middle">
                  {!!
                    $produit->stock &&
                    $produit->stock->min != '' ?
                    $produit->stock->min : 0
                  !!}
                </td>
                <td class="align-middle">
                  {!!
                    $produit->stock &&
                    $produit->stock->max != '' ?
                    $produit->stock->max : 0
                  !!}
                </td>
                <td class="align-middle">
                  {!!
                    $produit->stock ?
                    date("d/m/Y",strtotime($produit->stock->created_at)) : ''
                  !!}
                </td>
                @canany(['stock-display', 'stock-modficiation', 'stock-suppression','stockHisorique-nouveau'])
                  <td class="align-middle">
                    @if ($produit->check_stock == 0)
                      @can('stock-nouveau')
                        <a href="{{ route('stock.add',$produit->id) }}" class="btn btn-dark p-icon waves-effect waves-light shadow-none">
                          <soan class="mdi mdi-plus-circle-outline"></soan>
                        </a>
                      @endcan
                    @else
                      <a href="{{ route('stock.show',$produit->stock->id) }}" class="btn btn-warning p-icon waves-effect waves-light shadow-none">
                        <span class="mdi mdi-eye-outline"></span>
                      </a>
                      <a href="{{ route('stock.edit',$produit->stock->id) }}" class="btn btn-primary p-icon waves-effect waves-light shadow-none">
                        <span class="mdi mdi-pencil-outline"></span>
                      </a>
                      @can('stockHistory-nouveau')
                        <button type="button" class="btn btn-dark waves-effect waves-light shadow-none p-icon" data-bs-toggle="modal" data-bs-target="#newAdd{{ $produit->id }}">
                          <span class="mdi mdi-plus-thick"></span>
                        </button>
                        <div class="modal fade" id="newAdd{{ $produit->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-body p-3">
                                <div class="d-flex justify-content-center">
                                  <span class="mdi mdi-plus-circle-outline mdi-48px text-success"></span>
                                </div>
                                <form action="{{ route('stockHistorique.augmenter',$produit->stock->id) }}" method="POST">
                                  @csrf
                                  <div class="form-group mb-3">
                                    <label for="" class="form-label">Quantié</label>
                                    <input type="number" name="qte_add" id="" min="1" class="form-control" required>
                                  </div>
                                  <div class="row justify-content-center">
                                    <div class="col-6">
                                      <button type="submit" class="btn btn-action waves-effect waves-light w-100">
                                        enregistrer
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
                        </div>

                        <button type="button" class="btn btn-danger waves-effect waves-light shadow-none p-icon" data-bs-toggle="modal" data-bs-target="#resign{{ $produit->id }}">
                            <span class="mdi mdi-minus"></span>
                        </button>
                        <div class="modal fade" id="resign{{ $produit->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-body">
                                <form action="{{ route('stockHistorique.resign',$produit->stock->id) }}" method="POST">
                                  @csrf
                                  <div class="d-flex justify-content-center mb-3">
                                    <span class="mdi mdi-minus-circle-outline mdi-48px text-danger"></span>
                                  </div>
                                  <div class="form-group mb-3">
                                    <label for="" class="form-label">Quantié</label>
                                    <input type="number" name="qte_demi" id="" min="1" max="{{ $produit->reste }}" class="form-control" required>
                                  </div>
                                  <div class="row justify-content-center">
                                    <div class="col-6">
                                      <button type="submit" class="btn btn-action waves-effect waves-light w-100">
                                        enregistrer
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
                        </div>
                      @endcan
                    @endif
                  </td>
                @endcanany
              </tr>
            @empty
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="d-flex justify-content-center mt-2">
        {{ $produits->links() }}
      </div>
    </div>
  </div>







@endsection