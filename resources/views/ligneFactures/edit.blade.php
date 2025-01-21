@extends('layouts.master')
@section('title')
Modifier la facture : {{ $facture->num ?? '' }}
@endsection
@section('content')
@include('sweetalert::alert')


<div class="d-md-flex justify-content-between mb-2">
  <h4 class="title">
    <a href="{{ route('facture.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    commande : {{ $facture->num }}
  </h4>

    <div class="">
      @can('facture-display')
      <a href="{{ route('facture.show',$facture) }}" class="btn btn-header waves-effect waves-light">
        <span class="mdi mdi-eye-outline align-middle"></span>
        détails
      </a>
      @endcan

        <a href="{{ route('factureProduit.add',$facture->id) }}" class="btn btn-header waves-effect waves-light">
          <span class="mdi mdi-plus-thick align-middle"></span>
          <span>nouveau produits</span>
        </a>



    </div>


</div>
<div class="row">
  <div class="col-lg-8">
    <h6 class="title">
      information basic
    </h6>
    <div class="card">
      <div class="card-body p-2">
        <form action="{{ route('facture.update',$facture) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="row row-cols-lg-2 row-cols-1">
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Client</label>
                <select name="client" id="client" class="form-select">
                  <option value="">Séléctionner le client</option>
                  @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ $client->id == $facture->client_id ? "selected":"" }}>{{ $client->raison_sociale }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Date du facture</label>
                <input type="date" name="date_facture" id="" class="form-control" value="{{ $facture->date_facture }}">
              </div>
            </div>



            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">TVA</label>
                <select name="tva" id="tva" class="form-select @error('tva') is-invalid @enderror">
                  <option value="">Choisir le tva</option>
                  @foreach ($tvas as $tva)
                    <option value = "{{ $tva }}" {{ $tva == $facture->taux_tva ? "selected" : "" }}> {{ $tva }} % </option>
                  @endforeach
                </select>
              </div>
            </div>



          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-action waves-effect waves-light px-5">mettre à jour</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col">
    <h6 class="title mb-2">
      paiements & commentaire
    </h6>
    <div class="card">
      <div class="card-body p-2">
        <div class="table-reponsive">
          <table class="table table-bordered m-0 info">
            <tbody>
              <tr>
                <td class="align-middle">
                  prix ht
                </td>
                <td class="align-middle">
                  <span class="mt">
                    {{ number_format($facture->ht , 2 , "," ," ") . " dh" }}
                  </span>
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  HT TVA
                </td>
                <td class="align-middle">
                  <span class="mt">
                    {{ number_format($facture->ht_tva , 2 , "," ," ") . " dh" }}
                  </span>
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  HT remise
                </td>
                <td class="align-middle">
                  <span class="mt">
                    {{ number_format($facture->remise_ht , 2 , "," ," ") . " dh" }}
                  </span>
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  TTC remise
                </td>
                <td class="align-middle">
                  <span class="mt">
                    {{ number_format($facture->remise_ttc , 2 , "," ," ") . " dh" }}
                  </span>
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  prix ttc
                </td>
                <td class="align-middle">
                  <span class="mt">
                    {{ number_format($facture->ttc , 2 , "," ," ") . " dh" }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="form-group mt-2">
          <label for="" class="form-label">commentaire</label>
          <textarea name="commentaire" id="" rows="4" class="form-control">{{ $facture->commentaire }}</textarea>
        </div>
      </div>
    </div>

    <h6 class="title">
    </h6>
  </div>
</div>


<h6 class="title mb-2">
  les produits
</h6>
<div class="card">
  <div class="card-body p-2">

    <div @if(count($facture->produits) > 10) style="height: 30rem;overflow-y:auto" @endif>
      <div class="table-resposnive">
        <table class="table table-bordered table-sm m-0">
          <thead class="table-success">
            <tr>
              <th>Référence</th>
              <th>Désignation</th>
              <th>Quantite</th>
              <th>Prix vente</th>
              <th>Remise</th>
              <th>Montant</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($facture->produits as $facture_produit)
              <tr>
                <td class="align-middle">{{ $facture_produit->produit->reference  }}</td>
                <td class="align-middle">{{ $facture_produit->produit->designation }}</td>
                <td class="align-middle">{{ $facture_produit->quantite }}</td>
                <td class="align-middle">{{ $facture_produit->produit->prix_vente }} DH</td>
                <td class="align-middle">{{ $facture_produit->remise }} %</td>
                <td class="align-middle">{{ $facture_produit->montant }} DH</td>
                <td class="align-middle">

                  <a href="{{ route('factureProduit.edit',$facture_produit) }}" class="btn btn-primary waves-effect waves-light p-icon"">
                      <span class="mdi mdi-pencil"></span>
                  </a>

                  <button type="button" class="btn btn-danger waves-effect waves-light p-icon" data-bs-toggle="modal" data-bs-target="#delete{{ $facture_produit->id }}">
                      <span class="mdi mdi-trash-can"></span>
                  </button>
                  <div class="modal fade" id="delete{{ $facture_produit->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-body">
                          <form action="{{ route('factureProduit.destroy',$facture_produit) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>
                            <h6 class="mb-2 fw-bolder text-center text-muted">Voulez-vous supprimer défenitivement du produit</h6>
                            <h6 class="text-danger mb-2 text-center">{{ $facture_produit->produit->reference }}</h6>

                            @foreach ($facture_produit->produit->stock->history as $i)
                              @if ( $i->fonction == "qte_sortie" && $i->created_at == $facture_produit->created_at)
                                {{ $i->quantite ?? ''}}
                              @endif
                            @endforeach
                            <div class="d-flex justify-content-center">
                              <button type="submit" class="btn btn-action px-5 fw-bolder py-2 me-2">
                                  Je confirme
                              </button>
                              <button type="button" class="btn btn-bleu px-5 py-2 fw-bolder" data-bs-dismiss="modal" aria-label="btn-close">
                                  Annuler
                              </button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            @empty

            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>








@endsection
@section('script')
    <script>
        $(document).ready(function(){

          $(document).on("change","#client",function(){
      let id = $(this).val();
      let out = "";
            $.ajax({
                type:"GET",
                url:"{{ route('clientGroup') }}",
                data:{"id":id},
                success:function(data){
                    $("#NGroup").val(data.nom);
                    $("#RGroup").val(data.remise);

                    let tva = $("#tva").val();

                    let count_pro = $(".pro:checked").length;
                    let sum = 0;

                    $(".montant").each(function(){
                        sum += +$(this).val();
                    });
                    let remise_facture = data.remise;
                    let ttc = parseFloat((sum  + (sum * (tva/100))) * (1 - (remise_facture/100))).toFixed(2);

                    $("li:nth-child(1) h6:nth-child(2)").html(parseFloat(sum).toFixed(2) + " dh");
                    $("li:nth-child(2) h6:nth-child(2)").html(ttc + " dh");
                    $("li:nth-child(3) h6:nth-child(2)").html(ttc + " dh");
                    $("li:nth-child(4) h6:nth-child(2)").html(count_pro);
                    $("#total").val(sum);
                    $("#ttc").val(ttc);
                    $("#reste").val(ttc);

                }
            })
    })
        })

    </script>
@endsection