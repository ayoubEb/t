@extends('layouts.master')
@section('title')
taux tva : {{ $tauxTva->valeur }}
@endsection
@section('content')
@include('sweetalert::alert')
<div class="d-md-flex justify-content-between align-items-center mb-3">
  <h4 class="title">
    <a href="{{ route('tauxTva.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    Modification taux tva : {{ $tauxTva->valeur }}
  </h4>
  @can('tauxTva-display')
    <a href="{{ route('tauxTva.show',$tauxTva) }}" class="btn btn-header waves-effect waves-light">
      <span class="mdi mdi-eye-outline align-middle"></span>
      détails
    </a>
  @endcan
</div>

<div class="card">
  <div class="card-body p-2">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <form action="{{ route('tauxTva.update',$tauxTva) }}" method="post">
          @csrf
          @method("PUT")
          <div class="form-group mb-2">
            <label for="">Valeur</label>
            <input type="text" name="valeur" id="" min="0" step="any" class="form-control @error('valeur') is-invalid @enderror" value="{{ $tauxTva->valeur }}">
            @error('valeur')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="">description</label>
            <textarea name="description" id="" rows="10" class="form-control">{{$tauxTva->description}}</textarea>
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-action waves-effect waves-light">
              <span>Mettre à jour</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

