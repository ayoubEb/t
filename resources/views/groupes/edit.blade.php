@extends('layouts.master')
@section('title')
    Liste des groupes
@endsection
@section("content")
@include('sweetalert::alert')
<h4 class="title">
  <a href="{{ route('group.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light">
    <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
  </a>
  modification du group : {{ $group->nom }}
</h4>
<div class="row justify-content-center">
  <div class="col-lg-5">
    <div class="card">
      <div class="card-body p-2">
        <form action="{{ route('group.update',$group) }}" method="POST">
          @csrf
          @method("PUT")
          <div class="form-group mb-2">
              <label for="" class="form-label">Nom</label><span class="text-danger">&nbsp;*</span>
              <input type="text" name="nom" id="" class="form-control @error('nom') is-invalid @enderror" value="{{ $group->nom }}">
              @error('nom')
                  <span class="invalid-feedback">
                      {{ $message }}
                  </span>
              @enderror
          </div>
          <div class="form-group mb-2">
              <label for="" class="form-label">Remise</label><span class="text-danger">&nbsp;*</span>
              <input type="number" name="remise" id="" class="form-control @error('remise') is-invalid @enderror" min="0" max="100" step="any" value="{{ $group->remise }}">
              @error('remise')
              <span class="invalid-feedback">
                  {{ $message }}
              </span>
          @enderror
          </div>
          <div class="form-group mb-2">
              <label for="" class="form-label">Statut</label>
              <div class="form-check form-switch" dir="ltr">
                  <input class="form-check-input py-2 px-4" type="checkbox" name="statut" {{ $group->statut == 1 ? "checked" : ''}} id="SwitchCheckSizelg" value="1">
              </div>
          </div>
          <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-action waves-effect waves-light">mettre à jour</button>
          </div>
      </form>
      </div>
    </div>

  </div>
</div>


@endsection