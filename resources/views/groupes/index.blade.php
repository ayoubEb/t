@extends('layouts.master')
@section('title')
    Liste des groupes
@endsection
@section("content")
@include('sweetalert::alert')
<div class="d-flex justify-content-between align-items-center mb-2">
  <h4 class="title m-0">
    liste des groupes
  </h4>
  @can('groupe-nouveau')
  <a href="{{ route('group.create') }}" class="btn btn-header px-4 waves-effect waves-light">
    <span class="mdi mdi-plus-thick"></span>
  </a>
  @endcan
</div>
<div class="card">
  <div class="card-body p-2">
    <div class="table-responsive">
      <table class="table table-bordered table-sm m-0 datatable">
        <thead class="table-success">
          <tr>
            <th>Nom</th>
            <th>Remise</th>
            <th>Statut</th>
            @canany(['groupe-modification', 'groupe-suppression','groupe-display'])
              <th>Actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @forelse ($groupes as $groupe)
            <tr>
              <td class="align-middle">{{ $groupe->nom }}</td>
              <td class="align-middle">{{ $groupe->remise." %" }}</td>
              <td class="align-middle">
                {!! $groupe->statut == 1 ? '<span class="text-success mdi mdi-check-bold mdi-18px"></span>' : '<span class="text-danger mdi mdi-close-thick mdi-18px"></span>'  !!}
              </td>
              @canany(['groupe-modification', 'groupe-suppression' , 'groupe-display'])
                <td class="align-middle">
                  @can("groupe-display")
                    <a href="{{ route('group.show',$groupe) }}" class="btn btn-warning p-icon waves-effect waves-light shadow-none">
                        <span class="mdi mdi-eye-outline"></span>
                    </a>
                  @endcan
                  @can("groupe-modification")
                    <a href="{{ route('group.edit',$groupe) }}" class="btn btn-primary p-icon waves-effect waves-light shadow-none">
                        <span class="mdi mdi-pencil-outline"></span>
                    </a>
                  @endcan
                  @can("groupe-suppression")
                    <button type="button" class="btn btn-danger p-icon waves-effect waves-light shadow-none" data-bs-toggle="modal" data-bs-target="#delete{{ $groupe->id }}">
                        <span class="mdi mdi-trash-can"></span>
                    </button>
                    <div class="modal fade" id="delete{{ $groupe->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-body">
                            <form action="{{ route('group.destroy',$groupe) }}" method="POST">
                              @csrf
                              @method("DELETE")
                              <div class="d-flex justify-content-center">
                                <span class="mdi mdi-trash-can-outline mdi-48px text-danger"></span>
                              </div>
                              <h4 class="text-danger mb-3 text-center">Confirmer la suppression</h4>
                              <h6 class="mb-2 fw-bolder text-center">
                                Êtes-vous sûr de vouloir supprimer la group ?
                              </h6>
                              <h6 class="text-primary mb-2 text-center">{{ $group->nom ?? '' }}</h6>
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
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header py-2 bg-primary">
                <h6 class="modal-title m-0 text-white" id="varyingModalLabel">Ajouter un groupe</h6>
                <button type="button" class="btn btn-transparent p-0 text-white" data-bs-dismiss="modal" aria-label="btn-close">
                    <i class="mdi mdi-close-thick"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('group.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="" class="form-label fw-normal">Nom</label><span class="text-danger">&nbsp;*</span>
                        <input type="text" name="nom" id="" class="form-control form-control-sm @error('nom') is-invalid @enderror" value="{{ old('nom') }}">
                        @error('nom')
                            <span class="badge bg-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="form-label fw-normal">Remise</label></span>
                        <input type="text" name="remise" id="" class="form-control form-control-sm"  value="{{ old('remise') }}">
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="form-label fw-normal">Statut</label>
                        <div class="form-check form-switch" dir="ltr">
                            <input class="form-check-input py-2 px-3" type="checkbox" name="statut" id="SwitchCheckSizelg" value="activer">
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary w-100 shadow-none">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection