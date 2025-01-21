@extends('layouts.master')
@section('title')
    Modifier la ligne d'achat : {{ $ligneAchat->num_achat ?? '' }}
@endsection
@section('content')
@include('sweetalert::alert')
  <div class="d-md-flex justify-content-between align-items-center">
    <h4 class="title">
      <a href="{{ route('ligneAchat.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light me-2">
        <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
      </a>
      Modifier la ligne d'achat : {{ $ligneAchat->num_achat ?? '' }}
    </h4>
    <div class="">
      <a href="{{ route('achat.add',$ligneAchat->id) }}" class="btn btn-header waves-effect waves-light mb-md-0 mb-2">
        <span class="mdi mdi-plus-thick"></span>
        produits
      </a>

      <button type="button" class="btn btn-header shadow-none" data-bs-toggle="modal" data-bs-target="#valider{{ $ligneAchat->id }}">
        <span class="mdi mdi-check-bold "></span>
        validé
      </button>
      <div class="modal fade" id="valider{{ $ligneAchat->id }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
          <div class="modal-content">

            <div class="modal-body">
              <div class="d-flex justify-content-center">
                <span class="mdi mdi-check-circle-outline mdi-48px text-success"></span>
              </div>
              <form action="{{ route('ligneAchat.valider',$ligneAchat) }}" method="post">
                @csrf
                @method("PUT")
                <h5 class="text-primary mb-2 text-center">Valider la demande paiement séléctionner ?</h5>
                <h6 class="text-danger mb-2 text-center">{{ $ligneAchat->num_achat ?? '' }}</h6>
                <h6 class="mb-3">Attention une fois validée , l'achat ne peux pas plus modifiables !</h6>
                <div class="row justify-content-center">
                  <div class="col-6">
                    <button type="submit" class="btn btn-action waves-effect waves-light w-100">
                      Validé
                    </button>
                  </div>
                  <div class="col-6">
                    <button type="button" class="btn btn-bleu waves-effect waves-light w-100" data-bs-dismiss="modal" aria-label="btn-close">
                      Annuler
                    </button>
                  </div>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-body p-2">
      <div class="row">
        <div class="col-lg-7">
          <h5 class="title mt-2">
            <span>
              basic information
            </span>
          </h5>
          <form action="{{ route('ligneAchat.update',$ligneAchat) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="ht" value="{{ $ligneAchat->ht }}">
            <div class="row row-cols-2">

              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Fournisseur</label>
                  <select name="fournisseur_id" class="form-select @error('fournisseur_id') is-invalid @enderror" required>
                    <option value="">Séléctionner le fournisseur</option>
                    @foreach ($fournisseurs as $fournisseur)
                        <option value="{{ $fournisseur->id }}" {{ $fournisseur->id == $ligneAchat->fournisseur_id ? "selected":"" }} @if($fournisseur->deleted_at != null ) class="text-danger" @endif>{{ $fournisseur->raison_sociale }}</option>
                    @endforeach
                  </select>
                  @error('fournisseur_id')
                    <strong class="invalid-feedback">
                      {{ $message }}
                    </strong>
                  @enderror
                </div>
              </div>

              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Date</label>
                  <input type="date" name="date_achat" id="" class="form-control @error('date_achat') is-invalid @enderror" value="{{ $ligneAchat->date_achat }}" required>
                  @error('date_achat')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                  @enderror
                </div>
              </div>

              <div class="col mb-2">
                <div class="form-group mb-2">
                  <label for="" class="form-label">statut</label>
                  <select name="statut" id="" class="form-select form-select @error('statut') is-invalid @enderror">
                    <option value="">Choisir le statut</option>
                    <option value="en cours" {{ $ligneAchat->statut == "en cours" ? "selected":"" }}>En cours</option>
                    <option value="validé" {{ $ligneAchat->statut == "validé" ? "selected":"" }}>Validé</option>
                    <option value="annulé" {{ $ligneAchat->statut == "annulé" ? "selected":"" }}>Annulé</option>
                  </select>
                  @error('statut')
                    <strong class="invalid-feedback">{{ $message }}</strong>
                  @enderror
                </div>
              </div>


              <div class="col mb-2">
                <div class="form-group mb-2">
                  <label for="" class="form-label">Taux tva</label>
                  <select name="tva" id="tva" class="form-select @error('tva') is-invalid @enderror" required>
                    <option value="">Choisir le tva</option>
                    @foreach ($tvas as $tva)
                      <option value="{{ $tva }}" {{ $tva == $ligneAchat->taux_tva ? 'selected':'' }}> {{ $tva }}% </option>
                    @endforeach
                  </select>
                  @error('tva')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                  @enderror
                </div>
              </div>



              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Date Paiement</label>
                  <input type="date" name="date_paiement" class="form-control @error('date_paiement') is-invalid @enderror" value="{{ $ligneAchat->date_paiement }}">
                  @error('date_paiement')
                    <strong class="invalid-feedback">{{ $message }}</strong>
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
                        <option value="{{ $entreprise->id }}" {{ $ligneAchat->entreprise_id == $entreprise->id ? "selected" : "" }}> {{ $entreprise->raison_sociale }}</option>
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

            <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-action waves-effect waves-light">
                mettre à jour
              </button>
            </div>
          </form>
        </div>

        <div class="col">
          <h5 class="title">
            <span>
              paiements
            </span>
          </h5>
          <div class="table-responsive">
            <table class="table table-bordered m-0 info">
              <tbody id="info">
                <tr>
                  <td class="align-middle">ht</td>
                  <td class="align-middle fw-bolder">
                    <span id="ht">
                      {{ number_format($ligneAchat->ht , 2 , "," , " ") }} DHS
                    </span>
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">ttc</td>
                  <td class="align-middle fw-bolder">
                    <span id="ttc">
                      {{ number_format($ligneAchat->ttc , 2 , "," , " ") }} DHS
                    </span>
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">payer</td>
                  <td class="align-middle fw-bold">
                    <span class="text-success" id="payer">
                      {{ number_format($ligneAchat->payer , 2 , "," , " ") }} dhs
                    </span>
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">reste</td>
                  <td class="align-middle fw-bold">
                    <span class="text-danger" id="reste">
                      {{ number_format($ligneAchat->reste , 2 , "," , " ") }} dhs
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-2">
      <h5 class="title">
        les produits
      </h5>
      <div class="table-resposnive">
        <table class="table table-bordered table-sm m-0">
          <thead class="table-success">
            <tr>
              <th>Référence</th>
              <th>Désignation</th>
              <th>Quantite</th>
              <th>Prix achat</th>
              <th>Remise</th>
              <th>Montant</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($ligneAchat->achats as $achat)
              <tr>
                <td class="align-middle">{{ $achat->produit->reference ?? '' }}</td>
                <td class="align-middle">{{ $achat->produit->designation ?? '' }}</td>
                <td class="align-middle">{{ $achat->quantite ?? '' }}</td>
                <td class="align-middle">{{ $achat->produit->prix_achat ?? 0 }} DH</td>
                <td class="align-middle">{{ $achat->remise ?? 0 }} %</td>
                <td class="align-middle">{{ $achat->montant ?? 0 }} DH</td>
                <td class="align-middle">
                  <a href="{{ route('achat.edit',$achat) }}" class="btn btn-primary waves-effect waves-light p-icon">
                    <span class="mdi mdi-pencil-outline"></span>
                  </a>
                  <button type="button" class="btn btn-danger waves-effect waves-light p-icon" data-bs-toggle="modal" data-bs-target="#delete{{ $achat->id}}">
                    <span class="mdi mdi-trash-can"></span>
                  </button>
                  <div class="modal fade" id="delete{{ $achat->id}}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-body">
                          <form action="{{ route('achat.destroy',$achat) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>
                            <h6 class="mb-2 fw-bolder text-center text-muted">Voulez-vous supprimer défenitivement du produit</h6>
                            <h6 class="text-danger mb-2 text-center">{{ $achat->produit->reference }}</h6>
                            <div class="d-flex justify-content-center">
                              <button type="submit" class="btn btn-action waves-effect waves-light py-2 me-2">
                                Je confirme
                              </button>
                              <button type="button" class="btn btn-bleu waves-effect waves-light px-5 py-2 fw-bolder" data-bs-dismiss="modal" aria-label="btn-close">
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
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
