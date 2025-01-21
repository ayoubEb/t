@extends('layouts.master')
@section('title')
  new stock
@endsection
@section('content')
@include('sweetalert::alert')

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="title m-0">
    <a href="{{ route('stock.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light me-2">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    modification le stock : {{ $stock->num }}
  </h4>

  @can('stock-display')
    <a href="{{ route('stock.show',$stock) }}" class="btn btn-header waves-effect waves-light mb-md-0 mb-2">
      <span>détails</span>
    </a>
  @endcan


</div>

<div class="row justify-content-center">
  <div class="col-xxl-9">
    <div class="card">
      <div class="card-body p-2">
        <form action="{{ route('stock.update',$stock) }}" method="post">
          @csrf
          @method("PUT")
          <div class="row row-cols-2">
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">référence</label>
                <input type="text" name="reference" id="" class="form-control @error('reference') is-invalid @enderror" readonly value="{{ $stock->num }}">
                @error('reference')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>


            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Initial</label>
                <input type="number" name="initial" id="" class="form-control @error('initial') is-invalid @enderror" min="1" value="{{ $stock->initial }}">
                @error('initial')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Min</label>
                <input type="number" name="qte_min" id="" class="form-control @error('qte_min') is-invalid @enderror" min="1" value="{{ $stock->min }}">
                @error('qte_min')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Max</label>
                <input type="number" name="qte_max" id="" class="form-control @error('qte_max') is-invalid @enderror" min="0" value="{{ $stock->max }}">
                @error('qte_max')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>



          </div>
          <div class="d-flex justify-content-center">

            <button type="submit" class="btn btn-action waves-effect waves-light">
              mettre à jour
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection