@extends('layouts.master')
@section('title')
le produit : {{ $produit->reference ?? "" }}
@endsection
@section('content')
@include('sweetalert::alert')
<div class="d-md-flex justify-content-between align-items-center">
  <h4 class="title">
    <a href="{{ route('produit.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light me-2">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    Produit : {{ $produit->reference }}
  </h4>

  @can('produit-modification')
    <a href="{{ route('produit.edit',$produit) }}" class="btn btn-header waves-effect waves-light mb-md-0 mb-2">
      <span>modification</span>
    </a>
  @endcan

</div>



<div class="card">
  <div class="card-body p-2">

    <form action="{{ route('produitFiche.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="produit" value="{{ $produit->id }}">
      <div class="row justify-content-center mb-3">
        <div class="col-lg-6">
          <div class="form-group">
            <label for="" class="form-label">
              fiche
            </label>
          <div class="row">
            <div class="col-lg-8">
                <input type="file" name="file" id="" class="form-control mb-2" required>
              </div>
              <div class="col-lg-4">
                <button type="submit" class="btn btn-action waves-effect waves-light">
                  enregistrer
                </button>

              </div>
            </div>

          </div>
        </div>
      </div>
    </form>



    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#info" role="tab">
          <span class="d-md-none d-block mdi-18px mdi mdi-information-outline"></span>
          <span class="d-md-block d-none">informations</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#stock" role="tab">
          <span class="d-md-none d-block mdi-18px mdi mdi-cube-outline"></span>
          <span class="d-md-block d-none">stock</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#files" role="tab">
          <span class="d-md-none d-block mdi-18px mdi mdi-file-outline"></span>
          <span class="d-md-block d-none">pièce jointure</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#statistiques" role="tab">
          <span class="d-md-none d-block mdi-18px mdi mdi-chart-bell-curve"></span>
          <span class="d-md-block d-none">statistiques</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#history" role="tab">
          <span class="d-md-none d-block mdi-18px mdi mdi-history"></span>
          <span class="d-md-block d-none">historiques</span>
        </a>
      </li>
    </ul>

    <div class="tab-content">
      {{-- information produit --}}
      <div class="tab-pane p-3 active" id="info" role="tabpanel">
        <div class="row">
          <div class="col-lg-3">
            @if($produit->image != null)
            <img src="{{ asset('storage/images/produits/'.$produit->image ?? '') }}" alt="" class="img-fluid mb-2">
            @else
              <img src="{{ asset('images/produit_default.png') }}" alt="" class="w-100 mb-2">
            @endif
          </div>
          <div class="col">
            <div class="table-responsive">
              <table class="table table-bordered m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">référence</td>
                    <td class="align-middle"> {{ $produit->reference }} </td>
                  </tr>
                  <tr>
                    <td class="align-middle">désignation</td>
                    <td class="align-middle"> {{ $produit->designation }} </td>
                  </tr>
                  <tr>
                    <td class="align-middle">prix vente</td>
                    <td class="align-middle"> {{ number_format($produit->prix_vente , 2 , ","," ") . ' dhs' }} </td>
                  </tr>
                  <tr>
                    <td class="align-middle">prix achat</td>
                    <td class="align-middle"> {{ number_format($produit->prix_achat , 2 , ","," ") . ' dhs' }} </td>
                  </tr>

                  <tr>
                    <td class="align-middle">statut</td>
                    <td class="align-middle">
                      <span class="mdi mdi-check-bold text-success"></span>
                    </td>
                  </tr>

                  <tr>
                    <td class="align-middle">date création</td>
                    <td class="align-middle"> {{ date("d/m/Y",strtotime($produit->created_at)) }} </td>
                  </tr>
                </tbody>
                @if ($produit->description != '')
                  <tfoot>
                    <tr>
                      <td class="align-middle" colspan="2">
                        {{ $produit->description ?? ''}}
                      </td>
                    </tr>
                  </tfoot>
                @endif
              </table>
            </div>
            @if (isset($categories) && count($categories) > 0)
              <h5 class="title text-center mt-3">
                les catégories
              </h5>
              <ul class="list-group">
                <div class="row row-cols-4">
                  @foreach ($categories as $categorie)
                    <div class="col">
                      <li class="list-group-item rounded py-2">
                        {{ $categorie->nom }}
                      </li>
                    </div>
                  @endforeach
                </div>
              </ul>
            @endif
            @if (isset($sous_categories) && count($sous_categories) > 0)
              <h5 class="title text-center mt-3">
                les sous catégories
              </h5>
              <ul class="list-group">
                <div class="row row-cols-4">
                  @foreach ($sous_categories as $sous_categorie)
                    <div class="col">
                      <li class="list-group-item rounded py-2">
                        {{ $sous_categorie->nom }} => {{$sous_categorie->categorie->nom }}
                      </li>
                    </div>
                  @endforeach
                </div>
              </ul>
            @endif
          </div>
        </div>



      </div>

      {{-- information stock --}}
      <div class="tab-pane  p-3" id="stock" role="tabpanel">
        <div class="row row-cols-md-2 row-cols-1">
          <div class="col mb-md-0 mb-2">
            <div class="table-responsive">
              <table class="table table-bordered m-0 info">
                <tbody>
                  {{-- num stock --}}
                  <tr>
                    <td class="align-middle">
                      stock
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->num != '' ? $produit->stock->num : '' }}
                    </td>
                  </tr>
                  {{-- date stock --}}
                  <tr>
                    <td class="align-middle">
                      date
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->date_stock != '' ? $produit->stock->date_stock : '' }}
                    </td>
                  </tr>
                  {{-- quantité disponible --}}
                  <tr>
                    <td class="align-middle">
                      disponible
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->disponible != '' ? $produit->stock->disponible : '' }}
                    </td>
                  </tr>
                  {{-- min --}}
                  <tr>
                    <td class="align-middle">
                      min
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->min != '' ? $produit->stock->min : '' }}
                    </td>
                  </tr>
                  {{-- max --}}
                  <tr>
                    <td class="align-middle">
                      max
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->max != '' ? $produit->stock->max : '' }}
                    </td>
                  </tr>
                  {{-- initial --}}
                  <tr>
                    <td class="align-middle">
                      initial
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->initial != '' ? $produit->stock->initial : '' }}
                    </td>
                  </tr>
                  {{-- quantite --}}
                  <tr>
                    <td class="align-middle">
                      quantité
                    </td>
                    <td class="align-middle">
                      {{ $produit->quantite }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col">
            <div class="table-responsive">
              <table class="table table-bordered m-0 info">
                <tbody>
                  {{-- augmenter --}}
                  <tr>
                    <td class="align-middle">
                      quantité augmenter
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->qte_augmenter != '' ? $produit->stock->qte_augmenter : 0 }}
                    </td>
                  </tr>
                  {{-- alert --}}
                  <tr>
                    <td class="align-middle">
                      quantité alert
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->qte_alert != '' ? $produit->stock->qte_alert : 0 }}
                    </td>
                  </tr>
                  {{-- retour --}}
                  <tr>
                    <td class="align-middle">
                      quantité retour
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->qte_retour != '' ? $produit->stock->qte_retour : 0 }}
                    </td>
                  </tr>
                  {{-- achat --}}
                  <tr>
                    <td class="align-middle">
                      quantité achats
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->qte_retour != '' ? $produit->stock->qte_retour : 0 }}
                    </td>
                  </tr>
                  {{-- achat réserver --}}
                  <tr>
                    <td class="align-middle">
                      quantité achats réserver
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->qte_achatRes != '' ? $produit->stock->qte_achatRes : 0 }}
                    </td>
                  </tr>
                  {{-- vente --}}
                  <tr>
                    <td class="align-middle">
                      quantité vente
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->qte_vente ? $produit->stock->qte_vente : 0 }}
                    </td>
                  </tr>
                  {{-- vente réserver --}}
                  <tr>
                    <td class="align-middle">
                      quantité vente réserver
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->qte_venteRes != '' ? $produit->stock->qte_venteRes : 0 }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>


      {{-- information file --}}
      <div class="tab-pane p-3" id="files" role="tabpanel">
        <div class="table-responsive">
          <table class="table table-bordered m-0">
            <thead>
              <tr>
                <th>title</th>
                <th>actions</th>
              </tr>
            </thead>
            @foreach ($produit->fiches as $item)

            <tr>
              <td class="algn-middle">
                <a href="{{ asset('storage/files/produits/'.$item->title) }}">{{ $item->title }}</a>
              </td>
            </tr>

            @endforeach
          </table>
        </div>
      </div>

      {{-- information statistiques --}}
      <div class="tab-pane p-3" id="statistiques" role="tabpanel">
        <div class="row row-cols-lg-2 row-cols-1">
          <div class="col mb-3">
            <h6 class="title mb-2">
              statistique des ventes du produit cette mois - nombres
            </h6>
            <canvas id="lineDayCommande"></canvas>
          </div>
          <div class="col mb-3">
            <h6 class="title mb-2">
              statistique des ventes du produit cette mois - montants
            </h6>
            <canvas id="montantDayCommande"></canvas>
          </div>
          <div class="col mb-3">
            <h6 class="title mb-2">
              statistique des achats du produit cette mois - nombres
            </h6>
            <canvas id="lineDayAchat"></canvas>
          </div>
          <div class="col mb-3">
            <h6 class="title mb-2">
              statistique des achats du produit cette mois - montants
            </h6>
            <canvas id="montantDayAchat"></canvas>
          </div>
        </div>

      </div>

      {{-- information history --}}
      <div class="tab-pane p-3" id="history" role="tabpanel">
        <div class="table-repsonsive">
          <table class="table table-customize m-0">
            <thead>
              <tr>
                <th>opération</th>
                <th>utilisateur</th>
                <th>date</th>
                <th>temps</th>
                <th>valeurs</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($produit_suivi as $suivi)
                    <tr>
                      <td class="align-middle">
                        @if ($suivi->event == "created")
                          <span class="bg-success px-2 py-1 rounded text-white fw-bold">
                              Nouveau
                          </span>
                        @elseif ($suivi->event == "deleted")
                          <span class="bg-danger px-2 py-1 rounded text-white fw-bold">
                              Suppression
                          </span>
                        @elseif ($suivi->event == "updated")
                          <span class="bg-primary px-2 py-1 rounded text-white fw-bold">
                              Modification
                          </span>
                        @endif
                      </td>

                      <td class="align-middle">
                      {{ $suivi->user }}
                      </td>
                      <td class="align-middle">
                      {{ date("d/m/Y",strtotime($suivi->created_at)) }}
                      </td>
                      <td class="align-middle">
                      {{ date("H:i:s",strtotime($suivi->created_at)) }}
                      </td>
                      <td class="align-middle">
                        <button type="button" class="btn btn-primary waves-effect waves-light p-0 px-1" data-bs-toggle="modal" data-bs-target="#display{{ $suivi->id }}">
                          <span class="mdi mdi-eye-outline"></span>
                        </button>
                        <div class="modal fade modal-lg" tabindex="-1" id="display{{ $suivi->id }}" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                  </button>
                                </div>
                                  <div class="modal-body p-2">
                                      @php
                                            $array_insert = [];
                                            $array_sup = [];
                                            if($suivi->event == "created" ){
                                                foreach($suivi->properties['attributes'] ?? [] as $attribute => $value){
                                                  if(!is_null($value)){
                                                    $array_insert[] = [
                                                      "champ"=>$attribute,
                                                      "value"=>$value,
                                                    ];
                                                  }
                                              }
                                            }
                                            elseif ($suivi->event == "deleted") {
                                              foreach($suivi->properties['old'] ?? [] as $attribute => $value){
                                                if(!is_null($value)){
                                                  $array_sup[] = [
                                                    "champ"=>$attribute,
                                                    "value"=>$value,
                                                  ];
                                                }
                                            }

                                            }
                                      @endphp
                                      @php
                                        $properties = json_decode($suivi->properties, true);
                                        $changedAttributes = [];


                                        if (isset($properties['old']) && isset($properties['attributes'])) {
                                            foreach ($properties['attributes'] as $key => $newValue) {
                                                if (isset($properties['old'][$key]) && $properties['old'][$key] != $newValue) {
                                                    $changedAttributes[$key] = [
                                                        'old' => $properties['old'][$key],
                                                        'new' => $newValue
                                                    ];
                                                }
                                            }
                                        }

                                        // dd($properties);
                                      @endphp
                                      @if (count($changedAttributes) > 0)
                                        @foreach($changedAttributes as $key => $values)
                                          @if(count($changedAttributes) > 0)
                                            <ul class="list-group">
                                              <li class="list-group-item active text-center py-2">
                                                <b>{{ ucfirst($key) }}</b>
                                              </li>
                                              <li class="list-group-item text-center py-2">
                                                <div class="row row-cols-2">
                                                  <div class="col">
                                                    <h6>
                                                      avant
                                                    </h6>
                                                  </div>
                                                  <div class="col">
                                                    <h6>
                                                      nouveau
                                                    </h6>
                                                  </div>
                                                </div>
                                              </li>
                                              <li class="list-group-item d-flex justify-content-evenly align-items-center py-2">
                                                @if(is_array($values['old']))
                                                    @foreach($values['old'] as $oldValue)
                                                        {{ $oldValue }}
                                                      @endforeach
                                                @else
                                                  {{ $values['old'] }}
                                                @endif
                                                <span class="mdi mdi-arrow-right-thick"></span>
                                                @if(is_array($values['new']))
                                                @foreach($values['new'] as $newValue)
                                                    {{ $newValue }}
                                                @endforeach
                                                  @else
                                                    {{ $values['new'] }}
                                                  @endif
                                              </li>
                                            </ul>

                                          @else
                                            <small>No changes recorded</small>
                                          @endif

                                        @endforeach
                                      @elseif($suivi->event == "created")
                                      <h6 class="text-center title">
                                        {{ $suivi->event }}
                                      </h6>
                                        <ul class="list-group">
                                          @foreach ($array_insert as $attribute)

                                            <li class="list-group-item">
                                              <strong>{{ $attribute['champ'] }} : </strong>
                                              {{ $attribute['value'] }}

                                            </li>



                                          @endforeach

                                        </ul>
                                      @elseif($suivi->event == "deleted")
                                        <h6 class="text-center title">
                                          {{ $suivi->event }}
                                        </h6>
                                        <ul class="list-group">
                                          @foreach ($array_sup as $attribute)
                                            <li class="list-group-item">
                                              <strong>{{ $attribute['champ'] }} : </strong>
                                              {{ $attribute['value'] }}
                                            </li>
                                          @endforeach
                                        </ul>

                                      @endif
                                  </div>
                              </div>
                              <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                      </div>
                      </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>




  </div>
</div>

@endsection

@section('script')
  <script>
    $(function(){
      // variables
      var   day_cmd          = {!! json_encode($day_cmd) !!};        // les jours du commande
      var   day_achat        = {!! json_encode($day_achat) !!};
      var   day_cmdMontant   = {!! json_encode($montant_cmd) !!};
      var   day_achatMontant = {!! json_encode($montant_achat) !!};
      var   day_qte_cmd      = {!! json_encode($qte_cmd) !!};
      var   day_qte_achat    = {!! json_encode($qte_achat) !!};
      const nbrsCmd          = Object.values(day_cmd);
      const keysCmd          = Object.keys(day_cmd);
      const valuesCmdMontant = Object.values(day_cmdMontant);
      const valuesCmdQte     = Object.values(day_qte_cmd);

      const keysAchats         = Object.keys(day_achat);
      const nbrsAchats         = Object.values(day_achat);
      const valuesAchatMontant = Object.values(day_achatMontant);
      const valuesAchatQte     = Object.values(day_qte_cmd);

      // statistique produit commande => quantite
      var   dayCommande        = $("#lineDayCommande");
      var barChart = new Chart(dayCommande,{
        type:'line',
        data:{
          labels:keysCmd,
          datasets:[{
            label:'Nombre de vente',
            data:nbrsCmd,
            // backgroundColor:['#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093'],
            borderColor:'#000',
            fill:false,
            borderWidth:2,
            pointStyle:'rectRot'
          },
          {
            label:'quantité de vente',
            data:valuesCmdQte,
            // backgroundColor:['#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093'],
            borderColor:'red',
            fill:false,
            borderWidth:2,
          }
        ]
        },
        options:{
          scales:{

            yAxes:[{
              ticks:{
                beginAtZero:true
              }
            }]
          }
        }
      });
      // statistiques produit commande => montant
      var dayCmdMontant = $("#montantDayCommande");
      var barChart = new Chart(dayCmdMontant,{
        type:'line',
        data:{
          labels:keysCmd,
          datasets:[{
            label:'Montant des commandes',
            data:valuesCmdMontant,
            // backgroundColor:['#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093'],
            borderColor:'#000',
            fill:false,
            borderWidth:2,
          }
        ]
        },
        options:{
          scales:{

            yAxes:[{
              ticks:{
                beginAtZero:true
              }
            }]
          }
        }
      });

      // statistiques produit achat => quantite
      var dayAchat = $("#lineDayAchat");
      var barChart = new Chart(dayAchat,{
        type:'line',
        data:{
          labels:keysAchats,
          datasets:[{
            label:'Nombre des achats',
            data:nbrsAchats,
            // backgroundColor:['#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093'],
            borderColor:'#000',
            fill:false,
            borderWidth:2,
          },
          {
            label:'quantité des achats',
            data:valuesAchatQte,
            // backgroundColor:['#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093'],
            borderColor:'red',
            fill:false,
            borderWidth:2,
          }
        ]
        },
        options:{
          scales:{

            yAxes:[{
              ticks:{
                beginAtZero:true
              }
            }]
          }
        }
      });

      // statistiques produit commande => montant
      var dayAchatMontant = $("#montantDayAchat");
      var barChart = new Chart(dayAchatMontant,{
        type:'line',
        data:{
          labels:keysAchats,
          datasets:[{
            label:'Montant des achats',
            data:valuesAchatMontant,
            // backgroundColor:['#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093','#e9b093'],
            borderColor:'#000',
            fill:false,
            borderWidth:2,
          }
        ]
        },
        options:{
          scales:{

            yAxes:[{
              ticks:{
                beginAtZero:true
              }
            }]
          }
        }
      });
    });
  </script>
@endsection
