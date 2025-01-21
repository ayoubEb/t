@extends('layouts.master')
@section('title')
liste des depôts
@endsection
@section('content')
@include('sweetalert::alert')
<div class="d-flex justify-content-between align-items-center mb-2">
  <h4 class="title m-0">
    liste des depôts
  </h4>
  @can('depot-nouveau')
    <a href="{{ route('depot.create') }}" class="btn btn-header px-4 waves-effect waves-light">
      <span class="mdi mdi-plus-thick"></span>
    </a>
  @endcan
</div>
<div class="card">
  <div class="card-body p-2">
    <div class="table-responisive">
      <table class="table table-bordered table-customize m-0">
        <thead>
          <tr>
            <th>num</th>
            <th>adresse</th>
            <th>quantite</th>
            <th>disponible</th>
            <th>entre</th>
            <th>sortie</th>
            @canany(['depot-display', 'depot-modification', 'depot-suppression'])
            <th>opérations</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @foreach ($depots as $k =>  $depot)
            <tr>
              <td class="align-middle">
                {{ $depot->num_depot }}
              </td>
              <td class="align-middle">
                {{ $depot->adresse }}
              </td>
              <td class="align-middle">
                {{ $depot->quantite }}
              </td>
              <td class="align-middle">
                {{ $depot->disponible }}
              </td>
              <td class="align-middle">
                {{ $depot->entre }}
              </td>
              <td class="align-middle">
                {{ $depot->sortie }}
              </td>
              @canany(['depot-display', 'depot-modification', 'depot-suppression'])
              <td class="align-middle">

                @can('depot-display')
                  <a href="{{ route('depot.show',$depot) }}" class="btn p-icon btn-warning waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="détail">
                    <span class="mdi mdi-eye-outline"></span>
                  </a>
                @endcan
                @can('depot-modification')
                  <a href="{{ route('depot.edit',$depot) }}" class="btn p-icon btn-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="modification">
                    <span class="mdi mdi-pencil-outline"></span>
                  </a>
                @endcan
                @can('depot-suppression')
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
                          <form action="{{ route('depot.destroy',$depot) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <h4 class="text-danger mb-3 text-center">Confirmer la suppression</h4>
                            <h6 class="mb-2 fw-bolder text-center">
                                Voulez-vous vraiment suppression du depôt ?
                            </h6>
                            <h6 class="text-primary mb-2 text-center">{{ $depot->nom }}</h6>
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
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection