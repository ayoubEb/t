@extends('layouts.master')
@section('title')
   liste des catégories
@endsection
@section('content')
  @include('sweetalert::alert')
  <div class="d-flex justify-content-between align-items-center mb-2">
    <h4 class="title m-0">
      liste des catégories
    </h4>
    @can('categorie-nouveau')
    <a href="{{ route('categorie.create') }}" class="btn btn-header px-4 rounded waves-effect waves-light">
      <span class="mdi mdi-plus-thick"></span>
    </a>
    @endcan
  </div>

  <div class="card">
    <div class="card-body p-2">
      <div class="table-responsive">
        <table class="table table-bordered mb-0 table-customize datatable">
          <thead>
            <tr>
              <th>Nom</th>
              <th>description</th>
              @canany(['categorie-display', 'categorie-modification', 'categorie-suppression'])
                <th>actions</th>
              @endcanany
            </tr>
          </thead>
          <tbody>
            @forelse ($categories as $k => $categorie)
              <tr>
                <td class="align-middle">
                  {{ $categorie->nom }}
                </td>
                <td class="align-middle">
                  {{ Str::limit($categorie->description, 30, '...') ?? 'N/A' }}
                </td>
                @canany(['categorie-display', 'categorie-modification', 'categorie-suppression'])
                  <td class="align-middle">

                    @can('categorie-display')
                      <a href="{{ route('categorie.show',$categorie->id) }}" class="btn p-icon btn-warning waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="détail">
                        <span class="mdi mdi-eye-outline"></span>
                      </a>
                    @endcan
                    @can('categorie-modification')
                      <a href="{{ route('categorie.edit',$categorie->id) }}" class="btn p-icon btn-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="modification">
                        <span class="mdi mdi-pencil-outline"></span>
                      </a>
                    @endcan
                    @can('categorie-suppression')
                      <button type="button" class="btn p-icon btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#destroy{{ $k }}"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="suppression">
                        <span class="mdi mdi-trash-can-outline"></span>
                      </button>
                      <div class="modal fade" id="destroy{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body">
                              <div class="d-flex justify-content-center">
                                <span class="mdi mdi-trash-can text-danger mdi-48px"></span>
                              </div>
                              <form action="{{ route('categorie.destroy',$categorie->id) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <h4 class="text-danger mb-3 text-center">Confirmer la suppression</h4>
                                <h6 class="mb-2 fw-bolder text-center">
                                    Voulez-vous vraiment suppression du catégorie ?
                                </h6>
                                <h6 class="text-primary mb-2 text-center">{{ $categorie->nom }}</h6>
                                <div class="row justify-content-center">
                                  <div class="col">
                                    <button type="submit" class="btn btn-action waves-effect waves-light py-md-2 py-3 w-100">
                                      Je confirme
                                    </button>
                                  </div>
                                  <div class="col">
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
                  </td>
                @endcanany
              </tr>

            @empty
              <tr>
                <td colspan="3">
                  <h6 class="text-center m-0">
                    Aucun catégorie saisir
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







