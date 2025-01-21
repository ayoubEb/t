@extends('layouts.master')
@section('title')
    Ajouter une autorisation
@endsection
@section('content')
<div class="card">
  <div class="card-body">
      @if (count($errors) > 0)
      <div class="alert alert-danger">
      <strong>Whoops!</strong> There were some problems with your input.<br><br>
      <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
      </ul>
      </div>
      @endif
      <form action="{{ route('role.store') }}" method="post">
        @csrf
        <div class="form-group mb-2">
          <label for="" class="form-label">Nom</label>
          <input type="text" name="name" id="" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
          @error('name')
            <strong class="invalid-feedback">
              {{ $message }}
            </strong>
          @enderror
        </div>


        <div class="table-responsive">
          <table class="table table-bordered table-sm m-0">
            <thead>
              <tr>
                <th></th>
                <th>liste</th>
                <th>nouveau</th>
                <th>modification</th>
                <th>display</th>
                <th>suppression</th>
              </tr>
            </thead>
            <tbody>
              {{-- ============ --}}
              {{-- start categories --}}
              <tr>
                <td class="align-middle">
                  catégories
                </td>
                @foreach ($categories as $categorie)
                  <td class="align-middle">
                    <div class="form-check form-switch">
                      <input type="checkbox" name="permissions[]" id="swithe{{ $categorie->id }}" class="form-check-input" style="cursor: pointer" value="{{ $categorie->id }}">
                    </div>
                  </td>
                @endforeach
              </tr>
              {{-- ============ --}}
              {{-- end categories --}}

              {{-- ============ --}}
              {{-- start clients --}}
              <tr>
                <td class="align-middle">
                  clients
                </td>
                @foreach ($clients as $client)
                  <td class="align-middle">
                    <div class="form-check form-switch">
                      <input type="checkbox" name="permissions[]" id="swithe{{ $client->id }}" class="form-check-input" style="cursor: pointer" value="{{ $client->id }}">
                    </div>
                  </td>
                @endforeach
              </tr>
              {{-- ============ --}}
              {{-- end clients --}}

              {{-- ============ --}}
              {{-- start fournisseurs --}}
              <tr>
                <td class="align-middle">
                  fournisseurs
                </td>
                @foreach ($fournisseurs as $fournisseur)
                  <td class="align-middle">
                    <div class="form-check form-switch">
                      <input type="checkbox" name="permissions[]" id="swithe{{ $fournisseur->id }}" class="form-check-input" style="cursor: pointer" value="{{ $fournisseur->id }}">
                    </div>
                  </td>
                @endforeach
              </tr>
              {{-- ============ --}}
              {{-- end fournisseurs --}}

              {{-- ============ --}}
              {{-- start produits --}}
              <tr>
                <td class="align-middle">
                  produits
                </td>
                @foreach ($produits as $produit)
                  <td class="align-middle">
                    <div class="form-check form-switch">
                      <input type="checkbox" name="permissions[]" id="swithe{{ $produit->id }}" class="form-check-input" style="cursor: pointer" value="{{ $produit->id }}">
                    </div>
                  </td>
                @endforeach
              </tr>
              {{-- ============ --}}
              {{-- end produits --}}

              {{-- ============ --}}
              {{-- start factures --}}
              <tr>
                <td class="align-middle">
                  factures
                </td>
                @foreach ($factures as $facture)
                  <td class="align-middle">
                    <div class="form-check form-switch">
                      <input type="checkbox" name="permissions[]" id="swithe{{ $facture->id }}" class="form-check-input" style="cursor: pointer" value="{{ $facture->id }}">
                    </div>
                  </td>
                @endforeach
              </tr>
              {{-- ============ --}}
              {{-- end factures --}}

              {{-- ============ --}}
              {{-- start ligne d'achats --}}
              <tr>
                <td class="align-middle">
                  ligneAchats
                </td>
                @foreach ($ligneAchats as $ligneAchat)
                  <td class="align-middle">
                    <div class="form-check form-switch">
                      <input type="checkbox" name="permissions[]" id="swithe{{ $ligneAchat->id }}" class="form-check-input" style="cursor: pointer" value="{{ $ligneAchat->id }}">
                    </div>
                  </td>
                @endforeach
              </tr>
              {{-- ============ --}}
              {{-- end ligne d'achats --}}


              {{-- ============ --}}
              {{-- start users --}}
              <tr>
                <td class="align-middle">
                  utilisateurs
                </td>
                @foreach ($users as $user)
                  <td class="align-middle">
                    <div class="form-check form-switch">
                      <input type="checkbox" name="permissions[]" id="swithe{{ $user->id }}" class="form-check-input" style="cursor: pointer" value="{{ $user->id }}">
                    </div>
                  </td>
                @endforeach
              </tr>
              {{-- ============ --}}
              {{-- end users --}}

              {{-- ============ --}}
              {{-- start rôles --}}
              <tr>
                <td class="align-middle">
                  rôles
                </td>
                @foreach ($roles as $role)
                  <td class="align-middle">
                    <div class="form-check form-switch">
                      <input type="checkbox" name="permissions[]" id="swithe{{ $role->id }}" class="form-check-input" style="cursor: pointer" value="{{ $role->id }}">
                    </div>
                  </td>
                @endforeach
              </tr>
              {{-- ============ --}}
              {{-- end rôles --}}


              {{-- ============ --}}
              {{-- start facturePaiements --}}
              <tr>
                <td class="align-middle">
                  facturePaiements
                </td>
                @foreach ($facturePaiements as $facturePaiement)
                  <td class="align-middle">
                    <div class="form-check form-switch">
                      <input type="checkbox" name="permissions[]" id="swithe{{ $facturePaiement->id }}" class="form-check-input" style="cursor: pointer" value="{{ $facturePaiement->id }}">
                    </div>
                  </td>
                @endforeach
              </tr>
              {{-- ============ --}}
              {{-- end facturePaiements --}}

              {{-- ============ --}}
              {{-- start achatPaiements --}}
              <tr>
                <td class="align-middle">
                  achatPaiements
                </td>
                @foreach ($achatPaiements as $achatPaiement)
                  <td class="align-middle">
                    <div class="form-check form-switch">
                      <input type="checkbox" name="permissions[]" id="swithe{{ $achatPaiement->id }}" class="form-check-input" style="cursor: pointer" value="{{ $achatPaiement->id }}">
                    </div>
                  </td>
                @endforeach
              </tr>
              {{-- ============ --}}
              {{-- end achatPaiements --}}

            </tbody>
          </table>
        </div>


        <div class="table-responsive">
          <table class="table table-bordered table-sm m-0">
            <thead>
              <tr>
                <th></th>
                <th>liste</th>
                <th>nouveau</th>
                <th>modification</th>
                <th>suppression</th>
              </tr>
            </thead>
            <tbody>

              {{-- ============ --}}
              {{-- start tauxTvas --}}
              <tr>
                <td class="align-middle">
                  taux tvas
                </td>
                @foreach ($tauxTvas as $tauxTva)
                  <td class="align-middle">
                    <div class="form-check form-switch">
                      <input type="checkbox" name="permissions[]" id="swithe{{ $tauxTva->id }}" class="form-check-input" style="cursor: pointer" value="{{ $tauxTva->id }}">
                    </div>
                  </td>
                @endforeach
              </tr>
              {{-- ============ --}}
              {{-- end tauxTvas --}}
            </tbody>
          </table>
        </div>


        <div class="table-responsive">
          <table class="table table-bordered table-sm m-0">
            <thead>
              <tr>
                <th></th>
                <th>nouveau</th>
                <th>modification</th>
                <th>suppression</th>
              </tr>
            </thead>
            <tbody>

              {{-- ============ --}}
              {{-- start sousCategories --}}
              <tr>
                <td class="align-middle">
                  sous catégories
                </td>
                @foreach ($sousCategories as $sousCategorie)
                  <td class="align-middle">
                    <div class="form-check form-switch">
                      <input type="checkbox" name="permissions[]" id="swithe{{ $sousCategorie->id }}" class="form-check-input" style="cursor: pointer" value="{{ $sousCategorie->id }}">
                    </div>
                  </td>
                @endforeach
              </tr>
              {{-- ============ --}}
              {{-- end sousCategories --}}

              {{-- ============ --}}
              {{-- start stockHistoriques --}}
              <tr>
                <td class="align-middle">
                  stock historiques
                </td>
                @foreach ($stockHistoriques as $stockHistorique)
                  <td class="align-middle">
                    <div class="form-check form-switch">
                      <input type="checkbox" name="permissions[]" id="swithe{{ $stockHistorique->id }}" class="form-check-input" style="cursor: pointer" value="{{ $stockHistorique->id }}">
                    </div>
                  </td>
                @endforeach
              </tr>
              {{-- ============ --}}
              {{-- end stockHistoriques --}}

            </tbody>
          </table>
        </div>

        <div class="row row-cols-2">
            <div class="col">
                <a href="{{ route('role.index') }}" class="btn btn-sm btn-info">Retour</a>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-sm btn-primary float-end">Enregistrer</button>
            </div>
        </div>


      </form>
    </div>
</div>






@endsection
