@extends('layouts.master')
@section('title')
  catégorie : nouveau
@endsection
@section('content')
  @include('sweetalert::alert')
  <h4 class="title">
    <a href="{{ route('categorie.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light me-2">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    nouveau catégorie
  </h4>
  <div class="card">
    <div class="card-body p-2">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <form action="{{ route('categorie.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row row-cols-xl-3 row-cols-md-2 row-cols-1">
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Nom <span class="text-danger"> * </span> </label>
                  <input type="text" name="nom" id="" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}">
                  @error('nom')
                    <strong class="invalid-feedback">
                        {{ $message }}
                    </strong>
                  @enderror
                </div>
              </div>
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">image</label>
                  <input type="file" name="img" id="fileImg" class="form-control" value="{{ old('img') }}">
                </div>
              </div>
              <div class="col mb-2 d-md-none d-block">
                <div class="form-group">
                  <label for="" class="form-label">voir</label>
                  <img id="fileMobile" src="" class="img-fluid d-block" alt="Image de fiche" />
                </div>
              </div>
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">sous catégorie</label>
                  <input type="text" name="nom_sous" id="" class="form-control" value="{{ old('nom_sous') }}">
                </div>

              </div>
            </div>
            <div class="form-group mb-2">
              <label for="" class="form-label">Description</label>
              <textarea name="description" rows="10" class="form-control">{{ old("description")}}</textarea>
            </div>


            <div class="form-check mb-2">
              <input type="checkbox" name="autre_sous" id="autreSous" class="form-check-input" @if(old('autre_sous')=='autre')) checked @endif value="autre">
              <label for="autreSous" class="form-check-label">Ajouter plusieurs sous catégories</label>
            </div>

            <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-action waves-effect waves-light">
                <span>Enregistrer</span>
              </button>
            </div>
          </form>
        </div>
        <div class="col d-none d-md-block form-group">
          <label for="" class="form-label d-block">photo</label>
          <img id="fileDeskop" src="{{ asset('images/default.jpg') }}" class="img-fluid" alt="" />
        </div>
      </div>

      </div>
    </div>

@endsection
@section('script')
  <script>
    $(document).ready(function () {

      fileImg.onchange = evt => {
        const [file] = fileImg.files
        if (file) {
          fileDeskop.src = URL.createObjectURL(file)
          fileMobile.src = URL.createObjectURL(file)
          $("#imgDefault").addClass("d-none");
        }
      }
    });
  </script>
@endsection
