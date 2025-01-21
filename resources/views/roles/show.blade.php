@extends('layouts.master')
@section('title')
Authorisation : {{ $role->name }}
@endsection
@section('content')
<div class="card">
    <div class="card-body">
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
                    {!! in_array($categorie->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
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
                  {!! in_array($client->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
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
                  {!! in_array($fournisseur->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
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
                  {!! in_array($produit->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
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
                  {!! in_array($facture->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
                </td>
              @endforeach
            </tr>
            {{-- ============ --}}
            {{-- end factures --}}


            {{-- ============ --}}
            {{-- start users --}}
            <tr>
              <td class="align-middle">
                utilisateurs
              </td>
              @foreach ($users as $user)
                <td class="align-middle">
                  {!! in_array($user->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
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
                  {!! in_array($role->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
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
                  {!! in_array($facturePaiement->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
                </td>
              @endforeach
            </tr>
            {{-- ============ --}}
            {{-- end facturePaiements --}}






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
                {!! in_array($tauxTva->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
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
                {!! in_array($sousCategorie->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
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
              {!! in_array($stockHistorique->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
            </td>
            @endforeach
          </tr>
          {{-- ============ --}}
          {{-- end stockHistoriques --}}

        </tbody>
      </table>
    </div>
    <a href="{{ route('role.index') }}" class="btn btn-sm btn-info">Retour</a>
    </div>
</div>



@endsection