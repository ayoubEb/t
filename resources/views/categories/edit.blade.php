@extends('layouts.master')
@section('title')
  Modification catégorie : {{ $categorie->nom }}
@endsection
@section('content')
  @include('sweetalert::alert')
    <h4 class="title">
        <a href="{{ route('categorie.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light me-2">
          <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
        </a>
        Modification catégorie : {{ $categorie->nom }}
    </h4>
  <div class="card">
    <div class="card-body p-2">
      <div class="row justify-content-center">
        <div class="col mb-2">
          @if (isset($categorie->image))
            <img src="{{ asset('storage/images/category/'.$categorie->image) }}" alt="" id="fileDeskop" class="img-fluid">
            @else
            <img src="{{ asset('images/default.jpg') }}" alt="" id="fileDeskop" class="img-fluid">
          @endif

        </div>
        <div class="col-lg-8">
          <form action="{{ route('categorie.update',$categorie) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="row row-cols-md-2 row-cols-1">
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Nom</label>
                  <input type="text" name="nom" id="" class="form-control @error('nom') is-invalid @enderror" value="{{ $categorie->nom }}">
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
                  <input type="file" name="img" id="fileImg" class="form-control">
                </div>
              </div>
            </div>
            <div class="form-group mb-2">
              <label for="" class="form-label">Description</label>
              <textarea name="description" rows="10" class="form-control">{{ $categorie->description }}</textarea>
            </div>

            <div class="row justify-content-between">



              <div class="col-lg-4 col mb-lg-0 mb-2">
                @can('categorie-display')
                  <a href="{{ route('categorie.show',$categorie) }}" class="btn btn-lien waves-effect waves-light w-100">
                        info + gestion des sous catégories
                  </a>
                @endcan

              </div>
              <div class="col-lg-2 col-md-3 mb-lg-2 mb-0">
                  <button type="submit" class="btn btn-action waves-effect waves-light w-100">
                      <span>mettre à jour</span>
                  </button>
              </div>
            </div>
          </form>
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
        }
      }
    });
  </script>
@endsection

