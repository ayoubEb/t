  @extends('layouts.master')
  @section('title')
    nouveau commande
  @endsection
  @section('content')
  <h4 class="title mb-3">
    <a href="{{ route('facture.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    nouveau commande
  </h4>
  @if ($customize_check == true)
    <form action="{{ route('facture.store') }}" method="post">
      @csrf
      <article id="add-commande">

        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-lg-7">
                <h5 class="title">
                  <span>basic information</span>
                </h5>
                <div class="d-flex justify-content-center loading">
                  <span></span>
                </div>
                <div id="basic-info">
                  <div class="row row-cols-md-2 row-cols-1">
                    <div class="col mb-2">
                      <div class="form-group">
                        <label for="" class="form-label">Client</label>
                        <select name="client" id="client" class="form-select @error('client') is-invalid @enderror">
                          <option value="">Choisir le client</option>
                          @forelse ($clients as $client)
                            <option value="{{$client->id}}" {{ old("client") == $client->id ? "selected": "" }} >{{ $client->raison_sociale }}</option>
                          @empty
                            <option value="">Aucun client exsite</option>
                          @endforelse
                        </select>
                        @error('client')
                          <strong class="invalid-feedback">
                            {{ $message }}
                          </strong>
                        @enderror
                      </div>
                    </div>


                    <div class="col mb-2">
                      <div class="form-group">
                        <label for="" class="form-label">date</label>
                        <input type="date" id="" name="date_facture" class="form-control" value="{{ old('date_facture') == null ? date('Y-m-d') : old('date_facture') }}">
                      </div>
                    </div>


                    @if (count($entreprises) > 1)
                      <div class="col mb-2">
                        <div class="form-group">
                          <label for="" class="form-label">Entreprise</label>
                          <select name="entreprise_id" id="" class="form-select @error('entreprise_id') is-invalid @enderror">
                            <option value="">Séléctionner l'entreprise</option>
                            @foreach ($entreprises as $entreprise)
                                <option value="{{ $entreprise->id }}" {{ old("entreprise_id") == null || old('entreprise_id') == 1 ? 'selected' : '' }} >{{ $entreprise->raison_sociale }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    @endif

                    <div class="col mb-2">
                      <div class="form-group">
                        <label for="" class="form-label">TVA</label>
                        <select name="tva" id="tva" class="form-select @error('tva') is-invalid @enderror" required>
                          <option value="">Choisir le tva</option>
                          @foreach ($tvas as $tva)
                            <option value="{{ $tva }}" {{ $tva == old("tva") || $tva == 20 ? "selected" : "" }}> {{ $tva }} % </option>
                          @endforeach
                        </select>
                        @error('tva')
                          <strong class="invalid-feedback"> {{ $message }} </strong>
                        @enderror
                      </div>
                    </div>


                  </div>
                </div>
              </div>
              <div class="col">
                <h5 class="title mt-3">
                  paiements
                </h5>
                <div class="table-responsive">
                  <table class="table table-bordered m-0 info">
                    <tbody>
                      <tr>
                        <td class="align-middle">ht</td>
                        <td class="align-middle">
                          0.00 dh
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle">ht tva</td>
                        <td class="align-middle">
                          0.00 dh
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle">ht remise %</td>
                        <td class="align-middle">
                          0.00 dh
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle">ttc remise %</td>
                        <td class="align-middle">
                          0.00 dh
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle">ttc</td>
                        <td class="align-middle">
                          0.00 dh
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle">net à payer</td>
                        <td class="align-middle">
                          <span class="text-primary mt">
                            0.00 dh
                          </span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="form-group mt-2">
                  <label for="" class="form-label">commentaire</label>
                  <textarea name="" id="" cols="30" rows="4" class="form-control">{{ old('commentaire') }}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card m-0">
          <div class="card-body p-3">
            <h5 class="title">
              <span>les produits</span>
            </h5>
            <div class="d-flex justify-content-center loading">
              <span></span>
            </div>
              <div @if (count($produits) >= 100) style="height: 30rem;  overflow-y: auto;" @endif id="infoPro">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered m-0 table-customize">
                    <thead>
                      <tr>
                        <th class="col-2">référence</th>
                        <th>nom</th>
                        <th class="col-1">prix</th>
                        <th class="col-1">quantité</th>
                        <th class="col-1">remise</th>
                        <th class="col-2">montant</th>
                        <th class="col-1">reste du stock</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($produits as $k => $produit)
                        <tr>
                          <td class="align-middle">
                            <div class="form-check">
                              <input type="checkbox" name="pro[]" id="p{{$produit->id}}" class="form-check-input pro"  value="{{ $produit->id }}">
                              <label for="p{{$produit->id}}" class="form-check-label">{{ $produit->reference }}</label>
                            </div>
                          </td>
                          <td class="align-middle">{{ $produit->designation }}</td>
                          <td class="align-middle">
                            <input type="number" name="prix[]" min="0" step="any" class="form-control form-control-sm price" value="{{ $produit->prix_vente ?? 0 }}" data-previous="{{ $produit->prix_vente ?? 0 }}">
                          </td>
                          <td class="align-middle">
                            <input type="number" name="qte[]" step="any" min="1"  id="" max="{{ $produit->disponible }}" class="form-control form-control-sm qte" value="{{old('qte')[$k] ?? 0}}"  data-previous="{{ old('qte')[$k] ?? 0 }}" disabled>
                          </td>
                          <td class="align-middle">
                            <input type="number" name="remise[]" step="any" max="100" min="0" disabled id="" class="form-control form-control-sm remise" data-previous="{{ old('remise')[$k] ?? 0 }}" value="{{ old('remise')[$k] ?? 0 }}">
                          </td>
                          <td class="align-middle">
                              <input type="number" step="any"  id="" class="form-control form-control-sm montant" value="0" readonly>
                          </td>

                          <td class="align-middle">
                              <h6 class="m-0">{{ $produit->quantite }}</h6>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-action waves-effect waves-light">
                  Enregistrer
                </button>
              </div>
            </div>
          </div>
        </form>
      </article>

  @else
    <div class="card">
      <div class="card-body py-3">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <h6 class="text-center text-transform text-uppercase mb-3">
              {{ $msg }}
            </h6>
            <form action="{{ route('venteReferences.default') }}" method="post">
              @csrf
              <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-action waves-effect waves-light">
                  genérer
                </button>
              </div>
            </form>
          </div>
        </div>
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


     // Set a timeout to execute a function after a 2-second delay
     setTimeout(function() {
      $('#infoPro').fadeIn();
      $('#basic-info').fadeIn();
      $(".loading").addClass("d-none");
      }, 50);


      function calculationMontant(e){
        let qte           = $(e.target).parent().parent().children("td").children(".qte").val();
        let price         = $(e.target).parent().parent().children("td").children(".price").val();
        let remiseProduit = $(e.target).parent().parent().children("td").children(".remise").val();
        var montant       = parseFloat(qte * price).toFixed(2);
        let ht            = parseFloat(montant * ( 1 - (remiseProduit/100))).toFixed(2)
        $(e.target).parent().parent().children("td").children(".montant").val(ht);
      }
      function calculation(){
        var remise = 0;
        var tva = $("#tva").val();
        var ht = 0;
        $('.montant').each(function() {
          var value = parseFloat($(this).val()) || 0;
          ht += value;
        });
        var ht_tva     = parseFloat(ht * ( 1 + tva / 100)).toFixed(2);
        var remise_ht  = parseFloat(ht * (remise / 100)).toFixed(2);
        var remise_ttc = parseFloat(remise_ht * ( 1 + (tva / 100))).toFixed(2);
        var net_ttc    = parseFloat(ht_tva - remise_ttc).toFixed(2);
        $(".info tr:nth-child(1) td:nth-child(2)").html(parseFloat(ht).toFixed(2) + " dh");
        $(".info tr:nth-child(2) td:nth-child(2)").html(ht_tva + " dh");
        $(".info tr:nth-child(3) td:nth-child(2)").html(remise_ht + " dh");
        $(".info tr:nth-child(4) td:nth-child(2)").html(remise_ttc + " dh");
        $(".info tr:nth-child(5) td:nth-child(2)").html(net_ttc + " dh");
        $(".info tr:nth-child(6) td:nth-child(2) span").html(net_ttc + " dh");
      }









      $(".qte , .price , .remise").on("keyup",function(e){
        calculationMontant(e);
        calculation();
      })

      $("#tva").on("change",function(){
        calculation();
      })



      $(document).on("change",".pro",function(e){
        if($(this).is(':checked'))
        {
          $(e.target).parent().parent().parent().children('td').children(".qte").prop("disabled",false);
          $(e.target).parent().parent().parent().css("background-color","#57C5B6");
          $(e.target).parent().parent().parent().children('td').children(".montant").prop("disabled",false);
          $(e.target).parent().parent().parent().children('td').children(".remise").prop("disabled",false);
          $(e.target).parent().parent().parent().children('td').children(".qte").val(1);
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
          $(e.target).parent().parent().parent().children('td').children(".qte").prop("disabled",true);
          $(e.target).parent().parent().parent().children('td').children(".remise").prop("disabled",true);
          $(e.target).parent().parent().parent().children('td').children(".montant").prop("disabled",true);
          $(e.target).parent().parent().parent().css("background-color","transparent");
          $(e.target).parent().parent().parent().children('td').children(".montant").val(0);
          $(e.target).parent().parent().parent().children('td').children(".qte").val(0);
        }
        var count_pro = $(".pro:checked").length;
        calculation();
      })

    });




    </script>
  @endsection