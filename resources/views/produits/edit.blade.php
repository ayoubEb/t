@extends('layouts.master')
@section('title')
Modifier le produit : {{ $produit->reference ?? "" }}
@endsection
@section('content')
@include('sweetalert::alert')
<div class="d-md-flex justify-content-between align-items-center">
  <h4 class="title">
    <a href="{{ route('produit.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light me-2">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    modification le produit : {{ $produit->reference }}
  </h4>

  @canany(['produitAttribut-nouveau','produit-display'])
    <div class="">
      @can('produitAttribut-nouveau')
        <a href="{{ route('produit.attributes',$produit) }}" class="btn btn-header waves-effect waves-light mb-md-0 mb-2">
          <span class="mdi mdi-plus-thick"></span>
          caractéristiques
        </a>
      @endcan

      @can('produit-display')
        <a href="{{ route('produit.show',$produit) }}" class="btn btn-header waves-effect waves-light mb-md-0 mb-2">
          <span class="mdi mdi-eye-outline"></span>
          détails
        </a>
      @endcan
    </div>
  @endcanany

</div>

<form action="{{route('produit.update',$produit)}}" method="post" enctype="multipart/form-data">
  @csrf
  @method("PUT")
  <div class="card">
    <div class="card-body p-2">
      <div class="row">
        <div class="col-lg-8">
          <h5 class="title my-2">
            basic information
          </h5>
          <div class="row row-cols-md-2 row-cols-1">
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Designation du produit <span class="text-danger"> * </span></label>
                <input type="text" name="designation" id="" class="form-control @error('designation') is-invalid @enderror" value="{{ $produit->designation }}">
                @error('designation')
                  <strong class="invalid-feedback">
                      {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Référence <span class="text-danger"> * </span></label>
                <input type="text" name="reference" id="" class="form-control @error('reference') is-invalid @enderror" value="{{ $produit->reference }}">
                @error("reference")
                    <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Prix d'achat <span class="text-danger"> * </span></label>
                <input type="number" name="prix_achat" id="" class="form-control  @error('prix_achat') is-invalid @enderror" min="0" step="any" value="{{ $produit->prix_achat }}">
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
                <input type="number" name="prix_vente" id="" class="form-control  @error('prix_vente') is-invalid @enderror" min="0" step="any" value="{{ $produit->prix_vente }}">
                @error('prix_vente')
                <strong class="invalid-feedback">
                    {{ $message }} ex : 0/0.00
                </strong>
                @enderror
              </div>
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="" class="form-label">Description</label>
            <textarea name="description" id="" cols="30" rows="9" class="form-control"> {{ $produit->description }} </textarea>
          </div>
        </div>
        <div class="col">
          <h5 class="title my-2">
            catégories & sous catégories
          </h5>
          @if (Session::has("error"))
            <strong class="text-danger">
              {{ Session::get("error") }}
            </strong>
          @endif
          <div class="form-group mb-2">
            <label for="" class="form-label">Catégorie</label>
            <div class="list-group">
              @foreach ($categories as $categorie)
              <label class="list-group-item m-0 py-2" style="cursor: pointer">
                <input class="form-check-input me-1" type="checkbox" name="categorie[]" value="{{ $categorie->id }}" @if (in_array($categorie->id , $proCategorie)) checked @endif>
                {{ $categorie->nom ?? '' }}
              </label>
              @endforeach
            </div>
          </div>

          <div class="form-group mb-2">
            <label for="" class="form-label">Sous Catégorie</label>
            <div class="list-group">
              @foreach ($sousCategories as $sousCategorie)
                <label class="list-group-item m-0 py-2" style="cursor: pointer">
                  <input class="form-check-input me-1" type="checkbox" name="sous[]" value="{{ $sousCategorie->id }}" @if (in_array($sousCategorie->id , $proSousCategorie)) checked @endif>
                  {{ $sousCategorie->nom ?? '' }} => {{ $sousCategorie->categorie->nom }}
                </label>
              @endforeach
            </div>
          </div>

          <div class="form-group">
            <input type="file" name="img" id="fileImg" class="form-control mb-2">
          </div>
          @if($produit->image != null)
          <img src="{{ asset('storage/images/produits/'.$produit->image ?? '') }}" alt="" class="img-fluid" id="filePicture">
          @else
            <img src="{{ asset('images/produit_default.png') }}" alt="" class="w-100 " id="filePicture">
          @endif
        </div>
      </div>

      <div class="d-flex justify-content-center mt-2">
        <button type="submit" class="btn btn-action waves-effect waves-light">
            <span>mettre à jour</span>
        </button>
      </div>
    </div>
  </div>
</form>







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