@extends('layouts.master')
@section('title')
    Liste des groupes
@endsection
@section("content")
@include('sweetalert::alert')
<h4 class="title mb-3">
  <a href="{{ route('group.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light">
    <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
  </a>
  nouveau groupe
</h4>
<div class="card">
  <div class="card-body p-2">
    <div class="row justify-content-center">
      <div class="col-lg-5">
        <form action="{{ route('group.store') }}" method="POST">
          @csrf
          <div class="form-group mb-2">
            <label for="" class="form-label fw-normal">Nom</label><span class="text-danger">&nbsp;*</span>
            <input type="text" name="nom" id="" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}">
            @error('nom')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="" class="form-label fw-normal">Remise</label><span class="text-danger">&nbsp;*</span>
            <input type="number" name="remise" id="" class="form-control @error('remise') is-invalid @enderror" step="any" min="0" max="100" step="any" value="{{ old('remise') }}">
            @error('remise')
            <span class="invalid-feedback">
                {{ $message }}
            </span>
          @enderror
          </div>
          <div class="form-group mb-2">
            <label for="" class="form-label fw-normal">Statut</label>
            <div class="form-check form-switch" dir="ltr">
                <input class="form-check-input py-2 px-4" type="checkbox" name="statut" id="SwitchCheckSizelg" value="1">
            </div>
          </div>
          <div class="form-group d-flex justify-content-center">
              <button type="submit" class="btn btn-action waves-effect waves-light">Enregistrer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection