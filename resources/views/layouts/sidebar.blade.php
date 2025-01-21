


    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">
      <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
          <!-- Left Menu Start -->
          <ul class="metismenu list-unstyled" id="side-menu">
            <li>
              <a href="{{ route('home') }}" class="waves-effect">
                <i class="dripicons-device-desktop"></i>
                <span>Tableau de bord</span>
              </a>
            </li>
            @canany(['categorie-list', 'produit-list', 'caracteristique-list','stock-list'])
              <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                  <i class="dripicons-suitcase"></i>
                  <span>Catalogues</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                  @can('categorie-list')
                    <li class="{{ Route::currentRouteName() === 'categorie.edit' ||
                      Route::currentRouteName() === 'categorie.show' ||
                      Route::currentRouteName() === 'categorie.create' ||
                      Route::currentRouteName() === 'categorie.index'
                      ? 'mm-active':'' }}">
                      <a href="{{ route('categorie.index') }}">Catégories</a>
                    </li>
                  @endcan
                  @can('produit-list')
                    <li class="{{ Route::currentRouteName() === 'produit.edit' ||
                      Route::currentRouteName() === 'produit.show' ||
                      Route::currentRouteName() === 'produit.create' ||
                      Route::currentRouteName() === 'produit.index'
                      ? 'mm-active':'' }}">
                      <a href="{{ route('produit.index') }}">Produits</a>
                    </li>
                  @endcan
                  {{-- @can('caracteristique-list')
                    <li class="{{ Route::currentRouteName() === 'caracteristique.edit' ||
                      Route::currentRouteName() === 'caracteristique.show' ||
                      Route::currentRouteName() === 'caracteristique.create' ||
                      Route::currentRouteName() === 'caracteristique.index'
                      ? 'mm-active':'' }}">
                      <a href="{{ route('caracteristique.index') }}">Caractéristiques</a>
                    </li>
                  @endcan --}}
                  @can('stock-list')
                    <li class="{{ Route::currentRouteName() === 'stock.edit' ||
                      Route::currentRouteName() === 'stock.show' ||
                      Route::currentRouteName() === 'stock.create' ||
                      Route::currentRouteName() === 'stock.index'
                      ? 'mm-active':'' }}">
                      <a href="{{ route('stock.index') }}">Stock</a>
                    </li>
                  @endcan
                  {{-- @can('stockDepot-list')
                    <li class="{{ Route::currentRouteName() === 'stockDepot.edit' ||
                      Route::currentRouteName() === 'stockDepot.show' ||
                      Route::currentRouteName() === 'stockDepot.create' ||
                      Route::currentRouteName() === 'stockDepot.index'
                      ? 'mm-active':'' }}">
                      <a href="{{ route('stockDepot.index') }}">depôts</a>
                    </li>
                  @endcan --}}
                </ul>
              </li>
            @endcanany
            {{-- @canany(['client-list', 'fournisseur-list'])
              <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                  <i class="dripicons-suitcase"></i>
                  <span>CRM</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                  @can('client-list')
                    <li class="{{ Route::currentRouteName() === 'client.edit' ||
                      Route::currentRouteName() === 'client.show' ||
                      Route::currentRouteName() === 'client.create' ||
                      Route::currentRouteName() === 'client.index'
                      ? 'mm-active':'' }}">
                      <a href="{{ route('client.index') }}" class="waves-effect">
                        <span>Clients</span>
                      </a>
                    </li>
                  @endcan

                  @can('fournisseur-list')
                    <li class="{{ Route::currentRouteName() === 'fournisseur.edit' ||
                    Route::currentRouteName() === 'fournisseur.show' ||
                    Route::currentRouteName() === 'fournisseur.create' ||
                    Route::currentRouteName() === 'fournisseur.index'
                    ? 'mm-active':'' }}">
                      <a href="{{ route('fournisseur.index') }}" class="waves-effect">
                        <span>Fournisseur</span>
                      </a>
                    </li>
                  @endcan
                </ul>
              </li>
            @endcanany --}}

            @can('client-list')
              <li>
                <a href="{{ route('client.index') }}" class="waves-effect">
                  <i class="mdi mdi-file-outline mdi-18px"></i>
                  <span>clients</span>
                </a>
              </li>
            @endcan

            {{-- @can('ligneAchat-list')
              <li class="{{ Route::currentRouteName() === 'ligneAchat.edit' ||
              Route::currentRouteName() === 'ligneAchat.show' ||
              Route::currentRouteName() === 'ligneAchat.create' ||
              Route::currentRouteName() === 'ligneAchat.index'
              ? 'mm-active':'' }}">
                <a href="{{ route('ligneAchat.index') }}" class="waves-effect">
                  <i class="mdi mdi-file-outline mdi-18px"></i>
                  <span>achats</span>
                </a>
              </li>
            @endcan --}}

            @can('ligneAchat-list')
              <li>
                <a href="{{ route('tresorerie.plan') }}" class="waves-effect">
                  <i class="mdi mdi-file-outline mdi-18px"></i>
                  <span>plan trésorerie</span>
                </a>
              </li>
            @endcan

            @can('facture-list')
              <li>
                <a href="{{ route('facture.index') }}" class="waves-effect">
                  <i class="mdi mdi-file-outline mdi-18px"></i>
                  <span>factures</span>
                </a>
              </li>
            @endcan

            {{-- <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="dripicons-suitcase"></i>
                <span>Trésorerie</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                @can('achatPaiement-list')
                  <li class="{{ Route::currentRouteName() === 'achatPaiement.edit' ||
                  Route::currentRouteName() === 'achatPaiement.show' ||
                  Route::currentRouteName() === 'achatPaiement.create' ||
                  Route::currentRouteName() === 'achatPaiement.index'
                  ? 'mm-active':'' }}">
                    <a href="{{ route('achatPaiement.index') }}">Achats</a>
                  </li>
                @endcan
                @can('facturePaiement-list')
                  <li class="{{ Route::currentRouteName() === 'facturePaiement.edit' ||
                  Route::currentRouteName() === 'facturePaiement.show' ||
                  Route::currentRouteName() === 'facturePaiement.create' ||
                  Route::currentRouteName() === 'facturePaiement.index'
                  ? 'mm-active':'' }}">
                    <a href="{{ route('facturePaiement.index') }}">ventes</a>
                  </li>
                @endcan
              </ul>
            </li> --}}

            @can('facturePaiement-list')
              <li>
                <a href="{{ route('facturePaiement.index') }}" class="waves-effect">
                  <i class="mdi mdi-file-outline mdi-18px"></i>
                  <span>paiements</span>
                </a>
              </li>
            @endcan

            @canany(['user-list', 'role-list'])
              <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                  <i class="dripicons-suitcase"></i>
                  <span>GRH</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                  @can('user-list')
                    <li class="{{ Route::currentRouteName() === 'user.edit' ||
                    Route::currentRouteName() === 'user.show' ||
                    Route::currentRouteName() === 'user.create' ||
                    Route::currentRouteName() === 'user.index'
                    ? 'mm-active':'' }}">
                        <a href="{{ route('user.index') }}">Utilisateurs</a>
                    </li>
                  @endcan
                  @can('role-list')
                    <li class="{{ Route::currentRouteName() === 'role.edit' ||
                    Route::currentRouteName() === 'role.show' ||
                    Route::currentRouteName() === 'role.create' ||
                    Route::currentRouteName() === 'role.index'
                    ? 'mm-active':'' }}">
                        <a href="{{route('role.index')}}">Roles</a>
                    </li>
                  @endcan
                </ul>
              </li>
            @endcanany
            <li>
              <a href="{{ route('ligneRapport.index') }}" class="waves-effect">
                <i class="mdi mdi-file-outline mdi-18px"></i>
                <span>rapports</span>
              </a>
            </li>
            <li>
              <a href="{{ route('historique.index') }}" class="waves-effect">
                <i class="mdi mdi-file-outline mdi-18px"></i>
                <span>historique</span>
              </a>
            </li>

            <li>
              <a href="javascript: void(0);" class="has-arrow">
              <i class="dripicons-suitcase"></i>
              <span>personalisation</span>
              </a>
              <ul class="sub-menu" aria-expanded="true">
                {{-- <li>
                  <a href="{{ route('customizeAchat.index') }}">achats</a>
                </li> --}}
                <li>
                  <a href="{{ route('customizeVente.index') }}">ventes</a>
                </li>

              </ul>
            </li>


            @canany(['groupe-list', 'typeClient-list', 'entreprise-list','tauxTva-list','livraison-list','conditionPaiement-list','depot-list'])
              <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                  <i class="dripicons-suitcase"></i>
                  <span>Paramètre</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                  {{-- @can('groupe-list')
                    <li class="{{ Route::currentRouteName() === 'group.edit' ||
                    Route::currentRouteName() === 'group.create' ||
                    Route::currentRouteName() === 'group.show' ||
                    Route::currentRouteName() === 'group.index'
                    ? 'mm-active':'' }}">
                      <a href="{{ route('group.index') }}">Groupes</a>
                    </li>
                  @endcan --}}
                  @can('entreprise-list')
                    <li class="{{ Route::currentRouteName() === 'entreprise.edit' ||
                    Route::currentRouteName() === 'entreprise.show' ||
                    Route::currentRouteName() === 'entreprise.create' ||
                    Route::currentRouteName() === 'entreprise.index'
                    ? 'mm-active':'' }}">
                      <a href="{{ route('entreprise.index') }}">Entreprise</a>
                    </li>
                  @endcan
                  {{-- @can('typeClient-list')
                    <li class="{{ Route::currentRouteName() === 'typeClient.edit' ||
                    Route::currentRouteName() === 'typeClient.create' ||
                    Route::currentRouteName() === 'typeClient.show' ||
                    Route::currentRouteName() === 'typeClient.index'
                    ? 'mm-active':'' }}">
                      <a href="{{route('typeClient.index')}}">Type client</a>
                    </li>
                  @endcan --}}
                  @can('tauxTva-list')
                    <li class="{{ Route::currentRouteName() === 'tauxTva.edit' ||
                    Route::currentRouteName() === 'tauxTva.create' ||
                    Route::currentRouteName() === 'tauxTva.show' ||
                    Route::currentRouteName() === 'tauxTva.index'
                    ? 'mm-active':'' }}">
                      <a href="{{route('tauxTva.index')}}">Taux tva</a>
                    </li>
                  @endcan
                  {{-- @can('depot-list')
                    <li class="{{ Route::currentRouteName() === 'depot.edit' ||
                    Route::currentRouteName() === 'depot.create' ||
                    Route::currentRouteName() === 'depot.show' ||
                    Route::currentRouteName() === 'depot.index'
                    ? 'mm-active':'' }}">
                      <a href="{{route('depot.index')}}">Depots</a>
                    </li>
                  @endcan --}}

                </ul>
              </li>
            @endcanany

          </ul>
        </div>
        <!-- Sidebar -->
      </div>
    </div>
    <!-- Left Sidebar End -->
