@extends('layouts.master')
@section('title')
Ajouter une entreprise
@endsection
@section("content")
@include('sweetalert::alert')
<h4 class="title mb-3">
  <a href="{{ route('entreprise.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light">
    <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
  </a>
  Ajouter une entreprise
</h4>
<div class="card">
  <div class="card-body p-2">
    <form action="{{ route('entreprise.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="row row-cols-3">

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">logo</label>
            <input type="file" name="logo" id="" class="form-control">
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Raison Sociale <span class="text-danger"> * </span></label>
            <input type="text" name="raison_sociale" id="" class="form-control @error('raison_sociale') is-invalid @enderror" value="{{ old('raison_sociale') }}">
            @error('raison_sociale')
                <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">ICE <span class="text-danger"> * </span></label>
            <input type="text" name="ice" id="" class="form-control @error('ice') is-invalid @enderror" value="{{ old('ice') }}">
            @error('ice')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">RC <span class="text-danger"> * </span></label>
            <input type="text" name="rc" id="" class="form-control @error('rc') is-invalid @enderror" value="{{ old('rc') }}">
            @error('rc')
                <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">IF <span class="text-danger"> * </span></label>
            <input type="text" name="if" id="" class="form-control @error('if') is-invalid @enderror" value="{{ old('if') }}">
            @error('if')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Téléphone <span class="text-danger"> * </span></label>
            <input type="text" name="telephone" id="" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}">
            @error('telephone')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">fix</label>
            <input type="text" name="fix" id="" class="form-control" value="{{ old('fix') }}">
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Patente <span class="text-danger"> * </span></label>
            <input type="text" name="patente" id="" class="form-control @error('patente') is-invalid @enderror" value="{{ old('patente') }}">
            @error('patente')
                <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">E-mail <span class="text-danger"> * </span></label>
            <input type="email" name="email" id="" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
            @error('email')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Site <span class="text-danger"> * </span></label>
            <input type="text" name="site" id="" class="form-control @error('site') is-invalid @enderror" value="{{ old('site') }}">
            @error('site')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">CNSS <span class="text-danger"> * </span></label>
            <input type="text" name="cnss" id="" class="form-control @error('cnss') is-invalid @enderror" value="{{ old('cnss') }}">
            @error('cnss')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Adresse <span class="text-danger"> * </span></label>
            <input type="text" name="adresse" id="" class="form-control @error('adresse') is-invalid @enderror" value="{{ old('adresse') }}">
            @error('adresse')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Ville <span class="text-danger"> * </span></label>
            <input type="text" name="ville" id="" class="form-control @error('ville') is-invalid @enderror" value="{{ old('ville') }}">
            @error('ville')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Code postal <span class="text-danger"> * </span></label>
            <input type="text" name="code_postal" id="" class="form-control @error('code_postal') is-invalid @enderror" value="{{ old('code_postal') }}">
            @error('code_postal')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Document<span class="text-danger"> * </span></label>
            <select name="check_document" id="" class="form-select">
              <option value="">-- Sélectionner --</option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
        </div>

        <div class="col-8">
          <div class="form-group">
            <label for="" class="form-label">description</label>
          <textarea name="description" id="" rows="1" class="form-control">{{ old('description') }}</textarea>
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