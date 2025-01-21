@extends('layouts.master')
@section('title')
  catégorie : {{ $categorie->nom }}
@endsection
@section('content')
@include('sweetalert::alert')
  <h4 class="title">
      <a href="{{ route('categorie.edit',$categorie) }}" class="btn btn-retour px-4 py-1 waves-effect waves-light me-2">
        <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
      </a>
      catégorie : {{ $categorie->nom }}
  </h4>
<div class="row justify-content-center">
  <div class="col-lg-4 col-md-6">
    <h5 class="title">
      nouveau sous catégorie
    </h5>
    <div class="card">
      <div class="card-body p-2">
        <div class="form-group mb-2">
          <label for="" class="form-label d-block">image</label>
          @if (isset($categorie->image))
            <img src="{{ asset('storage/images/category/'.$categorie->image) }}" alt="" class="img-fluid">
          @else
            <img src="{{ asset('images/default.jpg') }}" alt="" class="img-fluid">
          @endif
        </div>
        <div class="form-group mb-2">
          <label for="" class="form-label">catégorie parent</label>
          <input type="text" disabled class="form-control" value="{{ $categorie->nom }}">
        </div>
        <div class="form-group mb-2">
          <label for="" class="form-label">description</label>
          {{ $categorie->description }}
        </div>
        @can('sousCategorie-nouveau')
          <form action="{{ route('sousCategorie.store') }}" method="post">
            @csrf
            <input type="hidden" name="categorie" class="" value="{{ $categorie->id }}">
            <div class="form-group mb-2">
              <label for="" class="form-label">sous catégorie</label>
              <input type="text" name="nom_sous" id="" class="form-control @error('nom_sous') is-invalid @enderror" value="{{ old("nom_sous") }}">
              @error('nom_sous')
                <strong class="invalid-feedback">
                    {{ $message }}
                </strong>
              @enderror
            </div>
            <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-action waves-effect waves-light">
                <span>enrgistrer</span>
              </button>
            </div>
          </form>
        @endcan
      </div>
    </div>
  </div>
  <div class="col">
    <h5 class="title mt-md-0 mt-4">
      liste des sous catégories
    </h5>
    <div class="card">
      <div class="card-body p-2">
        <div class="table-responsive">
          <table class="table table-bordered m-0 table-customize">
            <thead>
              <tr>
                <th>nom</th>
                @canany(['sousCategorie-modification', 'sousCategorie-suppression','sousCategorie-display'])
                  <th>actions</th>
                @endcanany
              </tr>
            </thead>
            <tbody>
              @forelse($sous_categories as $k => $sous_categorie)
                <tr>
                  <td class="align-middle">
                    {{ $sous_categorie->nom }}
                  </td>
                  @canany(['sousCategorie-modification', 'sousCategorie-suppression','sousCategorie-display'])
                    <td class="align-middle">
                      @can('sousCategorie-modification')
                        <button type="button" class="btn btn-primary p-icon waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#editSous{{ $k }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="modifier">
                          <i class="mdi mdi-pencil-outline"></i>
                        </button>
                        <div class="modal fade" id="editSous{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-md">
                            <div class="modal-content">
                              <div class="modal-header bg-primary py-2">
                                <h6 class="modal-title text-white m-0" id="varyingModalLabel">Modifier la catégorie : {{ $categorie->nom }}</h6>
                                <button type="button" class="btn btn-transparent p-0 text-white" data-bs-dismiss="modal" aria-label="btn-close">
                                  <span class="mdi mdi-close-thick"></span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="{{ route('sousCategorie.update',$sous_categorie) }}" method="post">
                                  @csrf
                                  @method("PUT")
                                  <div class="form-group mb-2">
                                      <label for="" class="form-label">Nom</label>
                                      <input type="text" name="sous_u" id="" class="form-control" value="{{ $sous_categorie->nom ?? '' }}" required>
                                  </div>
                                  <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-action waves-effect waves-light">
                                      <i class="mdi mdi-checkbox-marked-circle-outline align-middle"></i>
                                      <span>Mettre à jour</span>
                                    </button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endcan
                      @can('sousCategorie-suppression')
                        <button type="button" class="btn p-icon waves-effect waves-light btn-danger" data-bs-toggle="modal" data-bs-target="#destroySous{{ $k }}">
                          <i class="mdi mdi-trash-can"></i>
                        </button>
                        <div class="modal fade" id="destroySous{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-body">
                                <div class="d-flex justify-content-center mb-2">
                                  <span class="mdi mdi-trash-can-outline text-danger mdi-48px"></span>
                                </div>
                                <form action="{{ route('sousCategorie.destroy',$sous_categorie) }}" method="POST">
                                  @csrf
                                  @method("DELETE")
                                  <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>
                                  <h6 class="mb-2 text-center">Voulez-vous vraiment supprimé du sous catégorie ?</h6>
                                  <h6 class="text-danger mb-2 text-center">{{ $sous_categorie->nom }}</h6>
                                  <div class="row justify-content-evenly row-cols-2">
                                    <div class="col">
                                      <button type="submit" class="btn btn-action waves-effect waves-light w-100">
                                        <span>
                                          Je confirme
                                        </span>
                                      </button>
                                    </div>
                                    <div class="col">
                                      <button type="button" class="btn btn-bleu waves-effect waves-light w-100" data-bs-dismiss="modal" aria-label="btn-close">
                                        <span>
                                          Annuler
                                        </span>
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
                  <td class="align-middle" @canany(['sousCategorie-modification', 'sousCategorie-suppression']) colspan="2" @else colspan="1" @endcanany>
                    <h6 class="text-center text-danger">
                      Aucun sous catégorie
                    </h6>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
