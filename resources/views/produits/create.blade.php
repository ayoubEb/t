@extends('layouts.master')
@section('title')
  Nouveau produit
@endsection
@section('content')
  <h4 class="title mb-3">
    <a href="{{ route('produit.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    Ajouter une produit
  </h4>
  <div class="card">
    <div class="card-body p-2">
      <form action="{{ route('produit.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-xxl-8">
            <div class="row row-cols-xl-2 row-cols-1">
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Designation du produit <span class="text-danger"> * </span></label>
                  <input type="text" name="designation" id="" class="form-control @error('designation') is-invalid @enderror" value="{{old('designation')}}">
                  @error('designation')
                    <strong class="invalid-feedback">
                        {{ $message }}
                    </strong>
                  @enderror
                </div>
              </div>
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Référence</label>
                  <input type="text" name="reference" id="" class="form-control @error('reference') is-invalid @enderror" value="{{ old('reference') }}">
                  @error("reference")
                      <strong class="invalid-feedback">{{ $message }}</strong>
                  @enderror
                </div>
              </div>
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Prix d'achat</label>
                  <input type="number" name="prix_achat" id="" class="form-control  @error('prix_achat') is-invalid @enderror" min="0" step="any" value="{{ old('prix_achat') ?? 0 }}">
                  @error('prix_achat')
                    <strong class="invalid-feedback">
                      {{ $message }} ex : 0/0.00
                    </strong>
                  @enderror
                </div>
              </div>
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Prix de vente <span class="text-danger"> * </span></label>
                  <input type="number" name="prix_vente" id="" class="form-control  @error('prix_vente') is-invalid @enderror" min="0" step="any" value="{{ old('prix_vente') ?? 0 }}">
                  @error('prix_vente')
                  <strong class="invalid-feedback">
                      {{ $message }} ex : 0/0.00
                  </strong>
                  @enderror
                </div>
              </div>



              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Catégorie <span class="text-danger"> * </span></label>
                  <select name="categorie[]" id="" class="form-control @error('categorie') is-invalid @enderror select2 select2-multiple" multiple="multiple">
                    <option value="">Choisir la catégorie</option>
                    @foreach ($categories as $categorie)
                      <option value="{{ $categorie->id }}">{{ $categorie->nom ?? '' }} </option>
                    @endforeach
                  </select>
                  @error('categorie')
                    <strong class="invalid-feedback"> {{ $message }} </strong>
                  @enderror
                </div>
              </div>
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Sous-catégorie</label>
                  <select name="sous[]" id="" class="form-control @error('sous') is-invalid @enderror select2 select2-multiple" multiple="multiple">
                    <option value="">Choisir le sous-catégorie</option>
                    @foreach ($categories as $categorie)
                      @if (count($categorie->sous)>0)
                        <optgroup label="{{ $categorie->nom }}">
                          @foreach ($categorie->sous as $sous)
                            <option value="{{ $sous->id }}">{{ $sous->nom }}</option>
                          @endforeach
                        </optgroup>
                        @endif
                    @endforeach
                  </select>
                  @error('sous')
                    <strong class="invalid-feedback"> {{ $message }} </strong>
                  @enderror
                </div>
              </div>
            </div>
            <div class="form-group mb-2">
              <div class="form-group">
                <label for="" class="form-label">Description</label>
                <textarea name="description" id=""  rows="5" class="form-control" value="{{ old('description') }}"></textarea>
                @error('description')
                  <span class="invalid-feedback">{{$message}}</span>
                @enderror
              </div>
            </div>
          </div>
          <div class="col-xxl-4 col-lg-6">
            <div class="form-group mb-2">
              <label for="" class="form-label">Image</label>
              <input type="file" name="img" id="fileImg" class="form-control">
              <img src="" alt="" id="filePicture" class="img-fluid">
            </div>
            <div class="form-group mb-2">
              <label for="" class="form-label">fiche technique</label>
              <input type="file" name="file" id="" class="form-control">
            </div>
          </div>


          <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-action waves-effect waves-light">
              <span>Enregistrer</span>
            </button>
          </div>
        </div>

      </form>

    </div>
  </div>
@endsection


@section('script')
  <script>
    $(document).ready(function () {

      fileImg.onchange = evt => {
        const [file] = fileImg.files
        if (file) {
          filePicture.src = URL.createObjectURL(file)
        }
      }
    });
  </script>
@endsection