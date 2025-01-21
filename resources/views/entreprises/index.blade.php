@extends('layouts.master')
@section('title')
    Liste des entreprises
@endsection
@section('content')
@include('sweetalert::alert')
<div class="d-flex justify-content-between align-items-center mb-2">
  <h4 class="title">
    Liste des entreprises
  </h4>
  @can('entreprise-nouveau')
    <a href="{{ route('entreprise.create') }}" class="btn btn-header py-1 px-4 waves-effect waves-light">
      <span class="mdi mdi-plus-thick"></span>
    </a>
  @endcan
</div>
<div class="card">
  <div class="card-body p-2">
    <div class="table-responsive">
      <table class="table table-bordered table-customize m-0">
        <thead>
          <tr>
            <th>Logo</th>
            <th>Raison Social</th>
            <th>ICE</th>
            <th>E-mail</th>
            <th>Téléphone</th>
            @canany(['entreprise-display', 'entreprise-modification', 'entreprise-suppression','entreprise-display'])
              <th>opérations</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @forelse ($entreprises as $k => $entreprise)
            <tr>
              <td class="align-middle">
                @if ($entreprise->logo != null)
                    <img src="{{ asset('storage/images/entreprises/'.$entreprise->logo) }}" alt="" class="avatar-md">
                @else
                    Aucun logo
                @endif
              </td>
              <td class="align-middle">{{ $entreprise->raison_sociale }}</td>
              <td class="align-middle">{{ $entreprise->ice }}</td>
              <td class="align-middle">{{ $entreprise->email }}</td>
              <td class="align-middle">{{ $entreprise->telephone }}</td>
              @canany(['entreprise-display', 'entreprise-modification', 'entreprise-suppression'])
                <td class="align-middle">
                  @can("entreprise-modification")
                    <a href="{{ route('entreprise.edit',$entreprise) }}" class="btn btn-primary waves-effect waves-light p-icon">
                      <span class="mdi mdi-pencil-outline"></span>
                    </a>
                  @endcan
                  @can("entreprise-display")
                    <a href="{{ route('entreprise.show',$entreprise) }}" class="btn btn-warning waves-effect waves-light p-icon">
                      <span class="mdi mdi-eye-outline"></span>
                    </a>
                  @endcan
                  @if (count($entreprises) > 1)
                    @can("entreprise-suppression")
                      <button type="button"  class="btn btn-danger waves-effect waves-light p-icon" data-bs-toggle="modal" data-bs-target="#destroy{{ $entreprise->id }}">
                        <span class="mdi mdi-trash-can"></span>
                      </button>
                      <div class="modal fade" id="destroy{{ $entreprise->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-body">
                              <form action="{{ route('entreprise.destroy',$entreprise) }}" method="post">
                                @csrf
                                @method("DELETE")
                                <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>
                                <h6 class="mb-2 text-center text-muted">
                                  Voulez-vous vraiment suppression d'entreprises ?
                                </h6>
                                <h6 class="mb-2 fw-bolder text-center text-uppercase text-danger fs-12">
                                  {{ $entreprise->raison_sociale ?? '' }}
                                </h6>
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