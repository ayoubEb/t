@extends('layouts.master')
@section('title')
  fournisseur : nouveau
@endsection
@section('content')
@include('sweetalert::alert')
<h4 class="title">
  <a href="{{ route('fournisseur.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light me-2">
    <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
  </a>
  nouveau fournisseur
</h4>
<div class="card">
  <div class="card-body p-2">
    <form action="{{ route('fournisseur.store') }}" method="post">
      @csrf
      <div class="row row-cols-xl-3 row-cols-md-1 row-cols-1">
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Raison sociale <span class="text-danger"> * </span></label>
            <input type="text" name="raison_sociale" id="" class="form-control @error('raison_sociale') is-invalid @enderror" value="{{ old('raison_sociale') }}">
            @error('raison_sociale')
                <strong class="invalid-feedback"> {{ $message }} </strong>
            @enderror
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">ICE</label>
            <input type="text" name="ice" id="" class="form-control @error('ice') is-invalid @enderror" value="{{ old('ice') }}">
            @error('ice')
              <strong class="invalid-feedback"> {{ $message }} </strong>
            @enderror
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">RC</label>
            <input type="text" name="rc" id="" class="form-control @error('rc') is-invalid @enderror" value="{{ old('rc') }}">
            @error('rc')
              <strong class="invalid-feedback"> {{ $message }} </strong>
            @enderror
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">E-mail</label>
            <input type="email" name="email" id="" class="form-control" value="{{ old('email') }}">
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Téléphone <span class="text-danger"> * </span></label>
            <input type="text" name="telephone" id="" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}">
            @error('telephone')
              <strong class="invalid-feedback"> {{ $message }} </strong>
            @enderror
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Fix</label>
            <input type="text" name="fix" id="" class="form-control" value="{{ old('fix') }}">
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Adresse</label>
            <input type="text" name="adresse" id="" class="form-control" value="{{ old('adresse') }}">
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Ville</label>
            <input type="text" name="ville" id="" class="form-control" value="{{ old('ville') }}">
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Pays</label>
            <input type="text" name="pays" id="" class="form-control"  value="{{ old('pays')}}">
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Code postal</label>
            <input type="number" name="code_postal" id="" class="form-control" value="{{ old('code_postal') }}">
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">max paiement à payer <span class="text-danger"> * </span></label>
            <input type="number" name="maxMontantPayer" min="0" class="form-control @error('maxMontantPayer') is-invalid @enderror" value="{{ old('maxMontantPayer') }}">
            @error('maxMontantPayer')
                <strong class="invalid-feedback"> {{ $message }} </strong>
            @enderror
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-action waves-effect waves-light">
          <span>Enregistrer</span>
        </button>
      </div>
    </form>
  </div>
</div>
@endsection