@extends('layouts.master')
@section('title')
    Liste des types client
@endsection
@section('content')
<h4 class="title">
  <a href="{{ route('typeClient.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light">
    <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
  </a>
   Modification type client : {{ $typeClient->nom }}
</h4>
<div class="row justify-content-center">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body p-2">
        <form action="{{ route('typeClient.update',$typeClient) }}" method="post">
          @csrf
          @method("PUT")
          <div class="form-group mb-2">
            <label for="" class="form-label">Name</label>
            <input type="text" name="nom" id="" class="form-control @error('nom') is-invalid @enderror" value="{{ $typeClient->nom }}">
            @error('nom')
                <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>

          <div class="form-group mb-2">
            <label for="" class="form-label fw-normal">Statut</label>
            <div class="form-check form-switch" dir="ltr">
                <input class="form-check-input py-2 px-4" type="checkbox" name="statut" {{ $typeClient->statut == 1 ? 'checked' : '' }} id="SwitchCheckSizelg" value="1">
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
  </div>
</div>





@endsection
