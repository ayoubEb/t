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
  modification fournisseur : {{ $fournisseur->identifiant }}
</h4>
<div class="card">
  <div class="card-body p-2">
    <form action="{{ route('fournisseur.update',$fournisseur) }}" method="post">
      @csrf
      @method("PUT")
      <div class="row row-cols-xl-3 row-cols-md-2 row-cols-1">

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Raison sociale <span class="text-danger"> * </span></label>
            <input type="text" name="raison_sociale" id="" class="form-control @error('raison_sociale') is-invalid @enderror" value="{{ $fournisseur->raison_sociale }}">
            @error('raison_sociale')
                <strong class="invalid-feedback"> {{ $message }} </strong>
            @enderror
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">ICE</label>
            <input type="text" name="ice" id="" class="form-control @error('ice') is-invalid @enderror" value="{{ $fournisseur->ice }}">
            @error('ice')
              <strong class="invalid-feedback"> {{ $message }} </strong>
            @enderror
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">RC</label>
            <input type="text" name="rc" id="" class="form-control @error('rc') is-invalid @enderror" value="{{ $fournisseur->rc }}">
            @error('rc')
              <strong class="invalid-feedback"> {{ $message }} </strong>
            @enderror
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">E-mail</label>
            <input type="email" name="email" id="" class="form-control" value="{{ $fournisseur->email }}">
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Téléphone <span class="text-danger"> * </span></label>
            <input type="text" name="telephone" id="" class="form-control @error('telephone') is-invalid @enderror" value="{{ $fournisseur->telephone }}">
            @error('telephone')
              <strong class="invalid-feedback"> {{ $message }} </strong>
            @enderror
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Fix</label>
            <input type="text" name="fix" id="" class="form-control" value="{{ $fournisseur->fix }}">
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Adresse</label>
            <input type="text" name="adresse" id="" class="form-control" value="{{ $fournisseur->adresse }}">
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Ville</label>
            <input type="text" name="ville" id="" class="form-control" value="{{ $fournisseur->ville }}">
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Pays</label>
            <input type="text" name="pays" id="" class="form-control"  value="{{ $fournisseur->pays}}">
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Code postal</label>
            <input type="number" name="code_postal" id="" class="form-control" value="{{ $fournisseur->code_postal }}">
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Max paiement à payer <span class="text-danger"> * </span></label>
            <input type="number" name="maxMontantPayer" min="1" class="form-control @error('maxMontantPayer') is-invalid @enderror" step="any" value="{{ $fournisseur->maxMontantPayer }}">
            @error('maxMontantPayer')
                <strong class="invalid-feedback"> {{ $message }} </strong>
            @enderror
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-action waves-effect waves-light">
          <span>mettre à jour</span>
        </button>
      </div>
    </form>
  </div>
</div>
@endsection