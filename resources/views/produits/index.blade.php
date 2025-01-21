@extends('layouts.master')
@section('title')
    Liste des produits
@endsection
@section('content')
@include('sweetalert::alert')
<div class="d-flex justify-content-between align-items-center mb-2">
  <h4 class="title m-0">
    liste des produits
  </h4>
  <div class="">
    @can('produit-nouveau')
    <a href="{{ route('produit.create') }}" class="btn btn-header px-4 waves-effect waves-light">
      <span class="mdi mdi-plus-thick"></span>
    </a>
    @endcan
    <button type="button" class="btn btn-header waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">
      importer
    </button>
      <a href="{{ route('produit.example') }}" class="btn btn-header px-4 waves-effect waves-light">
      example import
    </a>
    <div class="modal fade bs-example-modal-center" tabindex="-1" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title mt-0">importer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
              </div>
              <div class="modal-body p-2">

                <div class="table-responsive">
                  <table class="table table-customize mb-2">
                    <thead>
                      <tr>
                        <th>nom</th>
                        <th>prix</th>
                        <th>quantite</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="align-middle">
                          NOM PRO 1
                        </td>
                        <td class="align-middle">
                          1
                        </td>
                        <td class="align-middle">
                          5
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle">
                          NOM PRO 2
                        </td>
                        <td class="align-middle">
                          1
                        </td>
                        <td class="align-middle">
                          5
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <form action="{{ route('produit.import') }}" method="post" enctype="multipart/form-data">
                  @csrf
                  <input type="file" name="file" class="form-control" id="">
                  <div class="mt-2 d-flex justify-content-center">
                    <button type="submit" class="btn btn-action waves-effect waves-light">
                      enregistrer
                    </button>
                  </div>
                </form>
              </div>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  </div>
</div>
<div class="card">
  <div class="card-body p-2">
    <div class="table-responsive">
      <table id="datatable" class="table table-bordered mb-0 table-sm datatable">
        <thead class="table-success">
          <tr>
            <th>Référrence</th>
            <th>Désignation</th>
            <th>P.A</th>
            <th>P.V</th>
            <th>P.R</th>
            <th>quantité</th>
            <th>disponible</th>
            <th>statut</th>
            @canany(['produit-display', 'produit-modification', 'produit-suppression'])
              <th>Actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @forelse ($produits as $k => $produit)
            <tr>
              <td class="align-middle">
                {{ $produit->reference ?? '' }}
              </td>
              <td class="align-middle">{{ $produit->designation }}</td>
              <td class="align-middle fw-bold fs-small">
                {{ number_format($produit->prix_achat , 2 , ',' , ' ') . ' DH' }}
              </td>
              <td class="align-middle fw-bold fs-small">
                {{ number_format($produit->prix_vente , 2 , ',' , ' ') . ' DH' }}
              </td>
              <td class="align-middle fw-bold fs-small">
                {{ number_format($produit->prix_revient , 2 , ',' , ' ') . ' DH' }}
              </td>
              <td class="align-middle">
                {{ $produit->quantite }}
              </td>


                <td class="align-middle">
                  <span @class([
                    'badge',
                    'bg-danger' => $produit->disponible == 0,
                    'bg-success' => $produit->disponible != 0,
                  ])>
                    {{ $produit->disponible ?? '0' }}
                  </span>
                </td>

                <td class="align-middle">
                  {!!
                    $produit->statut == 1 ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close-thick text-danger"></span>'
                  !!}
                </td>

              @canany(['produit-display', 'produit-modification', 'produit-suppression'])
                <td class="align-middle">
                  @can('produit-display')
                    <a href="{{ route('produit.edit',$produit) }}" class="btn btn-primary p-icon waves-effect waves-light shadow-none">
                      <span class="mdi mdi-pencil-outline"></span>
                    </a>
                  @endcan
                  @can("produit-suppression")
                    <button type="button" class="btn btn-danger p-icon waves-effect waves-light shadow-none" data-bs-toggle="modal" data-bs-target="#delete{{ $k }}">
                      <span class="mdi mdi-trash-can"></span>
                    </button>
                    <div class="modal fade" id="delete{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-body">
                            <form action="{{ route('produit.destroy',$produit) }}" method="POST">
                              @csrf
                              @method("DELETE")
                              <div class="d-flex justify-content-center">
                                <span class="mdi mdi-trash-can-outline mdi-48px text-danger"></span>
                              </div>
                              <h4 class="text-danger mb-3 text-center">Confirmer la suppression</h4>
                              <h6 class="mb-2 fw-bolder text-center">
                                Êtes-vous sûr de vouloir supprimer la produit ?
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
                  @endcan
                  @can("produit-display")
                    <a href="{{ route('produit.show',$produit) }}" class="btn btn-warning p-icon waves-effect waves-light shadow-none">
                      <span class="mdi mdi-eye-outline" style="font-size: 0.90rem;"></span>
                    </a>
                  @endcan
                </td>
              @endcanany
            </tr>
          @empty
            <tr>
              <td colspan="9">
                <h6 class="text-center m-0">
                  Aucun produit saisir
                </h6>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>






@endsection


@section('script')
<script>
    if ($(".selecttwo").length) {
    $(".selecttwo").select2({
        dropdownParent: $(".fade")
      });
  }
</script>
@endsection