@extends('layouts.master')
@section('content')

@include('ligneFactures.minInfo',["id" => $facture->id])
<h5 class="title">
  les produits
</h5>
<form action="{{ route('facture.valider',$facture) }}" method="post">
  @csrf
  @method("PUT")
  <div class="row row-cols-4">
    @foreach ($commandes as $commande)
    <input type="hidden" name="commande[]" value="{{ $commande->id }}">
      <div class="col">
        <div class="card">
          <div class="card-body p-2">
            <ul class="list-group mb-2">
              <li class="list-group-item py-2">
                <h6 class="m-0">
                  {{ $commande->produit->reference }}
                </h6>
              </li>
              <li class="list-group-item py-2">
                <h6 class="m-0">
                  {{ $commande->produit->designation }}
                </h6>
              </li>
            </ul>

            <div class="form-group mb-2">
              <label for="" class="Form-label">quantité</label>
              <input type="number" name="quantite[]" id="" class="form-control" min="0" max="{{ $commande->stock->disponible }}" value="{{ $commande->quantite }}">
            </div>
            <div class="form-group">
              <label for="" class="form-label">depots</label>
              <select name="depot_select[]" id="" class="form-select">
                <option value="">-- Séléctionner --</option>
                @foreach ($commande->depots as $depot)
                  <option value="{{ $depot->id }}" {{ count($commande->depots) == 1 ? 'selected':'' }}>{{ $depot->num_depot }}</option>
                @endforeach
              </select>
            </div>
            @if ($check_depot == true)
              <div class="form-group mt-2">
                <label for="" class="form-label">depot default</label>
                <input type="text" name="depot_default[]" id="" class="form-control" value="{{ $commande->depot->num_depot }}">
              </div>
            @endif

          </div>
        </div>
      </div>
    @endforeach
  </div>

  <button type="submit" class="btn btn-action">
    valider la commande
  </button>

</form>
@endsection