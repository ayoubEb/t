@extends('layouts.master')
@section('content')

@include('ligneAchats.minInfo',["id" => $ligneAchat->id])
<h5 class="title">
  les produits
</h5>
<form action="{{ route('ligneAchat.valider',$ligneAchat) }}" method="post">
  @csrf
  @method("PUT")
  <div class="row row-cols-4">
    @foreach ($achats as $achat)
    <input type="hidden" name="achat[]" value="{{ $achat->id }}">
      <div class="col">
        <div class="card">
          <div class="card-body p-2">
            <ul class="list-group mb-2">
              <li class="list-group-item py-2">
                <h6 class="m-0">
                  {{ $achat->produit->reference }}
                </h6>
              </li>
              <li class="list-group-item py-2">
                <h6 class="m-0">
                  {{ $achat->produit->designation }}
                </h6>
              </li>
            </ul>

            <div class="form-group mb-2">
              <label for="" class="Form-label">quantité</label>
              <input type="number" name="quantite[]" id="" class="form-control" min="0" value="{{ $achat->quantite }}">
            </div>
            <div class="form-group">
              <label for="" class="form-label">depots</label>
              <select name="depot_select" id="" class="form-select">
                <option value="">-- Séléctionner --</option>
                @foreach ($achat->depots as $depot)
                  <option value="{{ $depot->id }}" {{ count($achat->depots) == 1 ? 'selected':'' }}>{{ $depot->num_depot }}</option>
                @endforeach
              </select>
            </div>
            @if ($check_depot == true && isset($achat->depot))
              <div class="form-group mt-2">
                <label for="" class="form-label">depot default</label>
                <input type="text" name="depot_default" id="" class="form-control" value="{{ isset($achat->depot) ? $achat->depot->num_depot : '' }}">
              </div>
            @endif

          </div>
        </div>
      </div>
    @endforeach
  </div>

  <button type="submit" class="btn btn-action">
    valider l'achat
  </button>

</form>
@endsection