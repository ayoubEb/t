@extends('layouts.master')
@section('title')
modification achat du ligne d'achat : {{ $achat->produit->reference ?? '' }}
@endsection
@section('content')
@include('sweetalert::alert')
<h4 class="title">
  <a href="{{ route('ligneAchat.edit',$achat->ligne_achat_id) }}" class="btn btn-retour px-4 py-1 waves-effect waves-light me-2">
    <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
  </a>
  Modifier d'achat : {{ $achat->produit->designation ?? '' }}
</h4>
@include('ligneAchats.minInfo',["id"=>$achat->ligne_achat_id])
  <div class="card">
    <div class="card-body p-2">
      <input type="hidden" id="prixHt" value="{{ $achat->ligneAchat->ht }}">
      <input type="hidden" id="prixTtc" value="{{ $achat->ligneAchat->ttc }}">
      <input type="hidden" id="tauxTva" value="{{ $achat->ligneAchat->taux_tva }}">
      <input type="hidden" id="price" value="{{ $achat->prix }}">
          <form action="{{ route('achat.update',$achat) }}" method="post">
            @csrf
            @method("PUT")
            <div class="row row-cols-3">
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">
                    quantite
                  </label>
                  <input type="number" name="quantite" id="qteValeur" min="1" class="form-control @error('quantite') is-invalid @enderror" value="{{ $achat->quantite ?? 1 }}">
                  @error('quantite')
                    <strong class="invalid-feedback">
                      {{ $message }}
                    </strong>
                  @enderror
                </div>
              </div>
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">
                    remise
                  </label>
                  <input type="number" name="remise" id="remiseValeur" min="0" step="any" class="form-control @error('remise') is-invalid @enderror" value="{{ $achat->remise ?? 0 }}">
                  @error('remise')
                    <strong class="invalid-feedback">
                      {{ $message }}
                    </strong>
                  @enderror
                </div>
              </div>
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">
                    montant
                  </label>
                  <input type="number" id="mtValeur" min="0" step="any" class="form-control montant" value="{{ $achat->montant ?? 0 }}">
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

@endsection


@section('script')
  <script>
    $(document).ready(function () {
      $("#qteValeur").on("keyup",function(){
        var qte    = $(this).val();
        var price  = $("#price").val();
        var remise = $("#remiseValeur").val();
        var montant = price * qte;
        var ht     = parseFloat(montant * ( 1 - (remise/100))).toFixed(2);
        $("#mtValeur").val(ht);
      })

      $("#remiseValeur").on("keyup",function(e){
        var remise = $(this).val();
        var price  = $("#price").val();
        var qte    = $("#qteValeur").val();
        var montant = price * qte;
        var ht     = parseFloat(montant * ( 1 - (remise/100))).toFixed(2);
        $("#mtValeur").val(ht);
      })

    })
  </script>

@endsection