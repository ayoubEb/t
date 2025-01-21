@extends('layouts.master')
@section('title')
Liste des taux tva
@endsection
@section('content')
@include('sweetalert::alert')
<div class="d-flex justify-content-between align-items-center mb-2">
  <h4 class="title m-0">
    liste des taux tva
  </h4>
  @can('tauxTva-nouveau')
  <a href="{{ route('tauxTva.create') }}" class="btn btn-header px-4 waves-effect waves-light">
    <span class="mdi mdi-plus-thick"></span>
  </a>
  @endcan
</div>
<div class="card">
  <div class="card-body p-2">
    <div class="table-responsive">
      <table class="table table-bordered table-customize m-0 datatable">
        <thead>
          <tr>
            <th>valeur</th>
            <th>description</th>
            @canany(['tauxTva-modification', 'tauxTva-suppression','tauxTva-display'])
              <th>actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @forelse ($tauxTvas as $k =>  $tauxTva)
            <tr>
              <td class="align-middle"> {{ $tauxTva->valeur ?? '' }}% </td>
              <td class="align-middle"> {{ $tauxTva->description ?? '' }} </td>
                @canany(['tauxTva-modification', 'tauxTva-suppression','tauxTva-diosplay'])
                  <td class="align-middle">
                    @can('tauxTva-display')
                      <a href="{{ route('tauxTva.show',$tauxTva) }}" class="btn btn-warning p-icon waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="dispay">
                        <span class="mdi mdi-eye-outline"></span>
                      </a>
                    @endcan
                    @can('tauxTva-modification')
                      <a href="{{ route('tauxTva.edit',$tauxTva) }}" class="btn btn-primary p-icon waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="modifier">
                        <span class="mdi mdi-pencil-outline"></span>
                      </a>
                    @endcan
                    @can('tauxTva-suppression')
                      <button type="button" class="btn btn-danger p-icon waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#delete{{ $k }}"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="supprimer">
                        <span class="mdi mdi-trash-can-outline"></span>
                      </button>
                      <div class="modal fade" id="delete{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body">
                              <form action="{{ route('tauxTva.destroy',$tauxTva) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>
                                <h6 class="mb-2 fw-bolder text-center text-muted">
                                  Voulez-vous vraiment suppression du tauxTva ?
                                </h6>
                                <h6 class="text-danger mb-2 text-center">{{ number_format($tauxTva->valeur , 2 , "." ," ") }} %</h6>
                                <div class="row justify-content-evenly">
                                  <div class="col-6">
                                    <button type="submit" class="btn btn-action waves-effet waves-light py-md-2 py-3 w-100">
                                      Je confirme
                                    </button>
                                  </div>
                                  <div class="col-6">
                                    <button type="button" class="btn btn-bleu waves-effect waves-light w-100  py-md-2 py-3" data-bs-dismiss="modal" aria-label="btn-close">
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
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>





@endsection
