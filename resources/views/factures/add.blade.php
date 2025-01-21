@extends('layouts.master')
@section('title')
    nouveau produit de vente : {{ $facture->num ?? '' }}
@endsection
@section('content')
  @include('sweetalert::alert')
  @include('ligneFactures.minInfo',[ "id"=>$facture->id ])
  <h6 class="title mb-2">
    <span>les produits</span>
  </h6>
  <div class="card mb-0">
    <div class="card-body p-2" @if(count($produits_news) > 8) style="height: 27rem;overflow-y:auto;" @endif>
      <form action="{{ route('factureProduit.store') }}" method="post">
        @csrf

            <input type="hidden" name="facture_id" value="{{ $facture->id }}">
            <input type="hidden" id="tva" value="{{ $facture->taux_tva }}">
            <div class="table-responsive">
              <table class="table table-sm table-bordered m-0" id="new">
                <thead class="bg-primary">
                  <tr>
                    <th class="text-white">nom</th>
                    <th class="col-1 text-white">prix</th>
                    <th class="col-1 text-white">quantité</th>
                    <th class="col-1 text-white">remise</th>
                    <th class="col-2 text-white">montant</th>
                    <th class="text-white">quantité réserver</th>
                    <th class="text-white">reste de stock</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($produits_news as $produit)
                    <tr>
                      <td class="align-middle">
                        <div class="form-check fs-12">
                          <input type="checkbox" name="pro[]" id="p{{$produit->id}}" class="form-check-input pro" value="{{ $produit->id }}">
                          <label for="p{{$produit->id}}" class="form-check-label">{{ $produit->designation }}</label>
                        </div>
                      </td>
                      <td class="align-middle">
                        <input type="number" name="prix[]" class="form-control price" value="{{ $produit->prix_vente }}">
                      </td>
                      <td class="align-middle">
                        <input type="number" name="quantite[]" step="any" min="1"  id="" max="{{ $produit->disponible - $produit->qte_venteRes }}" class="form-control form-control-sm qte" value="{{ $facture_produit->quantite ?? ''}}" disabled>
                      </td>
                      <td class="align-middle">
                        <input type="number" name="remise[]" step="any"  id="" class="form-control form-control-sm remise" value="{{$facture_produit->remise ?? ''}}" disabled>
                      </td>
                      <td class="align-middle">
                        <input type="number" step="any"  id="" class="form-control form-control-sm montant" readonly value="{{ $produit->prix_achat ?? ''}}" disabled>
                        <td class="align-middle">
                          {{ $produit->qte_venteRes}}

                        </td>
                        <td class="align-middle">
                          {{ $produit->reste}}

                        </td>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>


          <div class="row justify-content-center">
            <div class="col-lg-8">
              <div class="d-flex justify-content-between mt-2">
                <a href="{{ route('facture.edit',$facture) }}" class="btn btn-retour waves-effect waves-light">
                  retour
                </a>
                <button type="submit" class="btn btn-action waves-effect waves-light">
                  <span>Enregistrer</span>
                </button>
              </div>

            </div>
          </div>

      </form>
    </div>
  </div>

  @endsection

  @section('script')
  <script>
    $(document).ready(function () {
      function calculation($montant){
        var sum_ht = 0;
        var tva = $("#tva").val();
        $('.montant').each(function() {
          var value = parseFloat($(this).val()) || 0;
          sum_ht += value;
        });
        var ttc = parseFloat(sum_ht  + (sum_ht * (tva/100))).toFixed(2);
        $("#ht").html(parseFloat(sum_ht).toFixed(2) + ' dh');
        $("#ttc").html(ttc + ' dh');
      }

      $(".pro").on("change",function(e)
      {
        if($(this).is(':checked'))
        {
          var count_pro = $(".pro:checked").length;
          var sum = 0;
          $(e.target).parent().parent().parent().children('td').children(".qte").prop("disabled",false);
          $(e.target).parent().parent().parent().children('td').children(".montant").prop("disabled",false);
          $(e.target).parent().parent().parent().children('td').children(".remise").prop("disabled",false);
          $(e.target).parent().parent().parent().addClass("table-success");
          $(e.target).parent().parent().parent().children('td').children(".qte").val(1);
          $(e.target).parent().parent().parent().children('td').children(".remise").val(0);

        }
        else
        {
          $(e.target).parent().parent().parent().removeClass("table-success");
          $(e.target).parent().parent().parent().children('td').children(".qte").prop("disabled",true);
          $(e.target).parent().parent().parent().children('td').children(".montant").prop("disabled",true);
          $(e.target).parent().parent().parent().children('td').children(".remise").prop("disabled",true);
          $(e.target).parent().parent().parent().children('td').children(".qte").val('');
          $(e.target).parent().parent().parent().children('td').children(".remise").val('');
          $(e.target).parent().parent().parent().children('td').children(".montant").val('');
        }
        var qte     = $(e.target).parent().parent().parent().children('td').children(".qte").val();
        var price   = $(e.target).parent().parent().parent().children('td').children(".price").val();
        var remise  = $(e.target).parent().parent().parent().children('td').children(".remise").val();
        var montant = parseFloat(qte * price).toFixed(2);
        $(e.target).parent().parent().parent().children('td').children(".montant").val(montant);
        calculation(montant);
      })

      $(".qte").on("keyup",function(e){
        var qte     = $(e.target).val();
        var price   = $(e.target).parent().parent().children("td").children(".price").val();
        var remise  = $(e.target).parent().parent().children("td").children(".remise").val();
        var montant = parseFloat(qte * price).toFixed(2);
        var ht      = parseFloat(montant * ( 1 - (remise/100))).toFixed(2);
        $(e.target).parent().parent().children("td").children(".montant").val(ht);
        calculation(ht);
      })

      $(".remise").on("keyup",function(e){
        var remise  = $(e.target).val();
        var price   = $(e.target).parent().parent().children("td").children(".price").val();
        var qte     = $(e.target).parent().parent().children("td").children(".qte").val();
        var montant = parseFloat(qte * price).toFixed(2);
        var ht      = parseFloat(montant * ( 1 - (remise/100))).toFixed(2);
        $(e.target).parent().parent().children("td").children(".montant").val(ht);
        calculation(ht);
      })

    })
  </script>

@endsection