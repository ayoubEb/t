@extends('layouts.master')
@section('title')
    N.A
@endsection
@section('content')
@if ($count_default == 0)
  <div class="card">
    <div class="card-body p-3">
      <div class="d-flex flex-column align-items-center">
        <h6 class="title">
          S'îl voûs plaît générer la forme des références default pour continuer l'opération
        </h6>
        <form action="{{ route('achatReferences.default') }}" method="post">
          @csrf
          <button type="submit" class="btn btn-action waves-effect waves-light">
            générer
          </button>
        </form>
      </div>
    </div>
  </div>
@else
<h4 class="title">
  <a href="{{ route('ligneAchat.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light">
    <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
  </a>
  nouveau d'achat
</h4>
<div class="card">
  <div class="card-body p-2">
    <form action="{{ route('ligneAchat.store') }}" method="post">
      @csrf
      <div class="row">
        {{-- ======================== start bloc base information ========================= --}}
        <div class="col-lg-8">
          <h5 class="title mt-2">
            <span class="">
              base informations
            </span>
          </h5>
          <div class="row row-cols-2">
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Fournisseur</label>
                <select name="fournisseur" class="form-select @error('fournisseur') is-invalid @enderror">
                  <option value="">Choisir le fournisseur</option>
                  @forelse ($fournisseurs as $fournisseur)
                    <option value="{{$fournisseur->id}}"  {{ old('fournisseur') == $fournisseur->id ? "selected" : "" }}>{{ $fournisseur->raison_sociale }}</option>
                  @empty
                    <option value="">Aucun fournisseur exsite</option>
                  @endforelse
                </select>
                @error('fournisseur')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Statut</label>
                <select name="statut" id="" class="form-select @error('statut') is-invalid @enderror">
                  <option value="">Choisir le statut</option>
                  <option value="en cours" {{ old("statut") == "en cours" || old("statut") == "" ? "selected" : 'seleced' }} >En cours</option>
                  <option value="validé" {{ old("statut") == "validé" ? "selected" : '' }}>Validé</option>
                </select>
                @error('statut')
                  <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Date</label>
                <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old("date") == null ? date('Y-m-d') : old('date') }}">
                @error('date')
                  <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Date Paiement</label>
                <input type="date" name="date_paiement" class="form-control @error('date_paiement') is-invalid @enderror" value="{{ old("date_paiement") == null ? date('Y-m-d') : old('date_paiement') }}">
                @error('date_paiement')
                  <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">TVA</label>
                <select name="tva" id="tva" class="form-select @error('tva') is-invalid @enderror">
                  <option value="">Choisir le tva</option>
                  @forelse ($tvas as $tva_valeur)
                    <option value="{{ $tva_valeur }}" {{ old("tva") == $tva_valeur || $tva_valeur == 20 ? "selected" : "" }}> {{ $tva_valeur }}% </option>
                  @empty
                  @endforelse
                </select>
                @error('tva')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>
            @if (count($entreprises) > 1)
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">entreprise</label>
                  <select name="entreprise" class="form-select @error('tva') is-invalid @enderror">
                    <option value="">Choisir l'entreprise</option>
                    @forelse ($entreprises as $entreprise)
                      <option value="{{ $entreprise->id }}" {{ old("entreprise") == $entreprise->id || $entreprise->id == 1 ? "selected" : "" }}> {{ $entreprise->raison_sociale }}</option>
                    @empty
                    @endforelse
                  </select>
                  @error('entreprise')
                    <strong class="invalid-feedback">
                      {{ $message }}
                    </strong>
                  @enderror
                </div>
              </div>
            @endif
          </div>
        </div>
        {{-- ======================== end bloc base information ========================= --}}
        {{-- ======================== start bloc resume paiement ========================= --}}
          <div class="col">
            <h5 class="title mt-2">
                paiements
            </h5>
            <div class="table-responsiv">
              <table class="table table-bordered m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">
                      <span class="fw-bold">
                        montant ht
                      </span>
                    </td>
                    <td class="align-middle">
                      <span class="fw-bold mt">
                        0.00 dh
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      <span class="fw-bold">
                        tva montant
                      </span>
                    </td>
                    <td class="align-middle">
                      <span class="fw-bold mt">
                        0.00 dh
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      <span class="fw-bold">
                        montant ttc
                      </span>
                    </td>
                    <td class="align-middle">
                      <span class="fw-bold mt">
                        0.00 dh
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        {{-- ======================== end bloc resume paiement ========================= --}}
        </div>

        <h5 class="title mt-2">
            produits
        </h5>
        <div  @if(count($produits) > 8) style="height: 30rem;  overflow-y: auto;" @endif>
          <div class="table-responsive">
            <table class="table table-bordered m-0 table-customize">
              <thead>
                <tr>
                  <th class="col-2">référence</th>
                  <th class="col">nom</th>
                  <th class="col-1">prix</th>
                  <th class="col-1">quantité</th>
                  <th class="col-1">remise ( % )</th>
                  <th class="col-2">montant</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($produits as $k => $produit)
                  <tr>
                    <td class="align-middle">
                      <div class="form-check fs-12">
                        <input type="checkbox" name="pro[]" id="p{{$produit->id}}" class="form-check-input pro" value="{{ $produit->id }}">
                        <label for="p{{$produit->id}}" class="form-check-label">{{ $produit->reference }}</label>
                      </div>
                    </td>
                    <td class="align-middle fs-12">{{ $produit->designation }}</td>
                    <td class="align-middle fw-bold">
                      <input type="number" min="0" name="prix[]" class="form-control form-control-sm price" value="{{ $produit->prix_achat ?? 0 }}">
                    </td>
                    <td class="align-middle">
                      <input type="number" name="quantite[]" step="any" min="0"  id="" class="form-control form-control-sm qte" value="{{ old('quantite')[$k] ?? 0 }}" disabled>
                    </td>
                    <td class="align-middle">
                        <input type="number" name="remise[]" step="any" min="0" max="100"  id="" class="form-control form-control-sm remise" value="{{ old('remise')[$k] ?? 0 }}" disabled>
                    </td>
                    <td class="align-middle">
                        <input type="number" step="any"  id="" class="form-control form-control-sm montant" disabled>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

          <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-action waves-effect waves-light">
                Enregistrer
            </button>


        </div>
    </form>
  </div>
</div>
@endif
<style>
    /* #nouveau{
        display: none;
    } */
</style>
@endsection
 @section('script')
 <script>

  $(document).ready(function(){
    var valuesArray = []; // Initialize an empty array
        // Loop through each input field
        $('.qte').each(function() {
            var value = $(this).val(); // Get the value of the input

            // Check if the value is empty
            if (value == 0) {
                valuesArray.push(0); // Add 0 if the field is empty
            } else {
                valuesArray.push(parseFloat(value)); // Add the actual value
            }
        });
        var index = valuesArray.indexOf(0);
        // console.log(index);

        if (index != 0) {
        var rows = $(".qte");
        for (let i = 0; i < rows.length; i++) {
          var row = $(rows[i]); // Get the current row as a jQuery object
          if(row.val() > 0)
            {
              var qte = row.val();
              var remiseProduit = row.parent().parent().children("td").children(".remise").val();
              var price = row.parent().parent().children("td").children(".price").val();
              row.parent().parent().children("td").children("div").children(".pro").prop('checked',true);
              row.parent().parent().addClass("table-success");
              var montant       = parseFloat(qte * price).toFixed(2);
              var ht            = parseFloat((qte * price) * ( 1 - (remiseProduit/100))).toFixed(2)
              row.parent().parent().children("td").children(".montant").val(ht);
              calculation();


            }
        }
      }





    function calculationMontant(e){
      var qte           = $(e.target).parent().parent().children("td").children(".qte").val();
      var price         = $(e.target).parent().parent().children("td").children(".price").val();
      var remiseProduit = $(e.target).parent().parent().children("td").children(".remise").val();
      var montant       = parseFloat(qte * price).toFixed(2);
      var ht            = parseFloat(montant * ( 1 - (remiseProduit/100))).toFixed(2)
      $(e.target).parent().parent().children("td").children(".montant").val(ht);

    }

    function calculation(){
      var tva = $("#tva").val();
      var ht  = 0;
        $('.montant').each(function() {
          var value = parseFloat($(this).val()) || 0;
          ht += value;
        });
        var ttc = parseFloat((ht  + (ht * (tva/100)))).toFixed(2);
        var mt_tva = parseFloat(ttc - ht).toFixed(2);
      $(".info tbody tr:nth-child(1) td:nth-child(2) span").html(parseFloat(ht).toFixed(2) + " dh");
      $(".info tbody tr:nth-child(2) td:nth-child(2) span").html(mt_tva + " dh");
      $(".info tbody tr:nth-child(3) td:nth-child(2) span").html(ttc + " dh");
    }



    $(document).on("change",".pro",function(e){
        if($(this).is(':checked')){
            var count_pro = $(".pro:checked").length;
            $(e.target).parent().parent().parent().addClass("bg-soft-success");
            $(e.target).parent().parent().parent().children('td').children(".qte").val(1);
            $(e.target).parent().parent().parent().children('td').children(".remise").val(0);
            $(e.target).parent().parent().parent().children('td').children(".qte").prop("disabled",false);
            $(e.target).parent().parent().parent().children('td').children(".remise").prop("disabled",false);
            let qte         = $(e.target).parent().parent().parent().children("td").children(".qte").val();
          let price         = $(e.target).parent().parent().parent().children("td").children(".price").val();
          let remiseProduit = $(e.target).parent().parent().parent().children("td").children(".remise").val();
          var montant       = parseFloat(qte * price).toFixed(2);
          let ht            = parseFloat(montant * ( 1 - (remiseProduit/100))).toFixed(2)
          $(e.target).parent().parent().parent().children("td").children(".montant").val(ht);
          var remise = $("#RGroup").val();
          var tva = $("#tva").val();
          $('.montant').each(function() {
            var value = parseFloat($(this).val()) || 0;
            ht += value;
          });

          }
          else
          {
            $(e.target).parent().parent().parent().css("background-color","transparent");
            $(e.target).parent().parent().parent().children('td').children(".qte").val(0);
            $(e.target).parent().parent().parent().children('td').children(".qte").prop("disabled",true);
            $(e.target).parent().parent().parent().children('td').children(".remise").prop("disabled",true);
            $(e.target).parent().parent().parent().removeClass("bg-soft-success");
            $(e.target).parent().parent().parent().children('td').children(".montant").val(0);
          }
        calculation();
    })


    $('.qte , .remise , .price').on("keyup",function(e){
      calculationMontant(e);
      calculation();
    })

    $("#tva").on("change",function(){
      calculation();
    })


  });




  </script>
 @endsection