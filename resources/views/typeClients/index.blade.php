@extends('layouts.master')
@section('title')
    Liste des types client
@endsection
@section('content')
@include('sweetalert::alert')
<div class="d-flex justify-content-between align-items-center mb-2">
  <h4 class="title m-0">
    liste des types client
  </h4>
  @can('typeClient-nouveau')
  <a href="{{ route('typeClient.create') }}" class="btn btn-header px-4 waves-effect waves-light">
    <span class="mdi mdi-plus-thick"></span>
  </a>
  @endcan
</div>
<div class="card">
  <div class="card-body p-2">
    <div class="table-responsive">
      <table id="" class="table table-bordered table-customize m-0 datatable">
        <thead>
          <tr>
            <th>Name</th>
            <th>statut</th>
            @canany(['typeClient-modification', 'typeClient-suppression','typeClient-display'])
              <th>Actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @foreach ($type_clients as $type_client)
            <tr>
              <td class="align-middle">{{ $type_client->nom }}</td>
              <td class="align-middle">
                {!! $type_client->statut == 1 ? '<span class="text-success mdi mdi-check-bold mdi-18px"></span>' : '<span class="text-danger mdi mdi-close-thick mdi-18px"></span>'  !!}
              </td>
                @canany(['typeClient-modification', 'typeClient-suppression','typeClient-display'])
                  <td class="align-middle">
                    @can('typeClient-display')
                      <a href="{{ route('typeClient.show',$type_client) }}" class="btn btn-warning waves-effect waves-light p-icon">
                        <span class="mdi mdi-eye-outline"></span>
                      </a>
                    @endcan
                    @can('typeClient-modification')
                      <a href="{{ route('typeClient.edit',$type_client) }}" class="btn btn-primary waves-effect waves-light p-icon">
                        <span class="mdi mdi-pencil-outline"></span>
                      </a>
                    @endcan
                    @can('typeClient-suppression')
                      <button type="button"  class="btn btn-danger waves-effect waves-light p-icon" data-bs-toggle="modal" data-bs-target="#destroy{{ $type_client->id }}">
                        <span class="mdi mdi-trash-can-outline"></span>
                      </button>
                      <div class="modal fade" id="destroy{{ $type_client->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-body">
                              <form action="{{ route('typeClient.destroy',$type_client) }}" method="post">
                                @csrf
                                @method("DELETE")
                                <div class="d-flex justify-content-center">
                                  <span class="mdi mdi-trash-can-outline mdi-48px text-danger"></span>
                                </div>
                                <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>
                                <h6 class="mb-2 fw-bolder text-center text-muted">
                                    Voulez-vous vraiment suppression du type client ?
                                </h6>
                                <h6 class="text-danger mb-2 text-center">{{ $type_client->nom }}</h6>
                                <div class="row justify-content-evenly">
                                  <div class="col-6">
                                    <button type="submit" class="btn btn-action waves-effet waves-light w-100 py-md-2 py-3">
                                      Je confirme
                                    </button>
                                  </div>
                                  <div class="col-6">
                                    <button type="button" class="btn btn-bleu waves-effect waves-light w-100 py-md-2 py-3" data-bs-dismiss="modal" aria-label="btn-close">
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
