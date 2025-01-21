@extends('layouts.master')
@section('title')
nouveau depôt
@endsection
@section('content')
<h4 class="title">
  @can('stock-display')
    <a href="{{ route('stock.show',$stock) }}" class="btn btn-retour px-4 py-1 waves-effect waves-light me-2">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
  @endcan
  nouveau depôt de stock : {{ $stock->num }}
</h4>
<div class="card">
  <div class="card-body p-2">
    <div class="table-responsive">
      <table class="table table-bordered info m-0">
        <tbody>
          <tr>
            <td class="align-middle">
              stock
            </td>
            <td class="align-middle">
              {{ $stock->num }}
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              produit ( référence )
            </td>
            <td class="align-middle">
              {{ $stock->produit->reference }}
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              produit ( désignation )
            </td>
            <td class="align-middle">
              {{ $stock->produit->designation }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

@if (count($depots) > 0)
  <h5 class="title">
    nouveau depôt
  </h5>
  <form action="{{ route('stockDepot.store') }}" method="post">
    @csrf
    <input type="hidden" name="stock_id" value="{{ $stock->id }}">
    <div class="card">
      <div class="card-body p-2">
        <div class="row justify-content-center">
          <div class="col-lg-9">
            <div class="row row-cols-2">
              <div class="col">
                <div class="form-group">
                  <label for="" class="form-label">depôt</label>
                  <select name="depot" id="" class="form-select">
                    <option value="">-- Séléctionner --</option>
                    @foreach ($depots as $depot)
                      <option value="{{ $depot->id }}" {{ $depot->id == old('depot') }} > {{ $depot->num_depot }} </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col">
                <div class="form-group">
                  <label for="" class="form-label">quantite</label>
                  <input type="number" name="quantite" min="0" id="" class="form-control" value="{{ old('qte') }}">
                </div>
              </div>

              {{-- <div class="col">
                <div class="form-group">
                  <label for="" class="form-label">depot default</label>
                  <select name="depot" id="" class="form-select">
                    <option value="">-- Séléctionner --</option>
                    @foreach ($depots as $depot)
                      <option value="{{ $depot->id }}" {{ $depot->id == old('depot') }} > {{ $depot->num_depot }} </option>
                    @endforeach
                  </select>
                </div>
              </div> --}}
            </div>

            <div class="row justify-content-center mt-2">
              <div class="col-lg-2">
                <button type="submit" class="btn btn-action waves-effect Waves-light w-100">
                  enregistrer
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
@endif

<h5 class="title">
  liste depôts
</h5>
<div class="card">
  <div class="card-body p-2">
    <div class="table-responsive">
      <table class="table table-bordered table-customize">
        <thead>
          <tr>
            <th>depot</th>
            <th>adresse</th>
            <th>quantite</th>
            <th>disponible</th>
            <th>entré</th>
            <th>sortie</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($liste_depots as $dep)
            <tr>
              <td class="align-middle">
                {{ $dep->num_depot }}
              </td>
              <td class="align-middle">
                {{ $dep->adresse }}
              </td>
              <td class="align-middle">
                {{
                  $dep->pivot &&
                  $dep->pivot->quantite != '' ?
                  $dep->pivot->quantite : ''
                }}
              </td>
              <td class="align-middle">
                {{
                  $dep->pivot &&
                  $dep->pivot->disponible != '' ?
                  $dep->pivot->disponible : ''
                }}
              </td>
              <td class="align-middle">
                {{
                  $dep->pivot &&
                  $dep->pivot->entre != '' ?
                  $dep->pivot->entre : ''
                }}
              </td>
              <td class="align-middle">
                {{
                  $dep->pivot &&
                  $dep->pivot->sortie != '' ?
                  $dep->pivot->sortie : ''
                }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection