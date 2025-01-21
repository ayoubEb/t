@extends('layouts.master')
@section('content')
<div class="d-flex justify-content-between align-items-center">
  <h4 class="title">
    <a href="{{ route('fournisseur.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light me-2">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    fournisseur : {{ $fournisseur->identifiant }}
  </h4>
  @can('fournisseur-modification')
    <a href="{{ route('fournisseur.edit',$fournisseur) }}" class="btn btn-header px-4 waves-effect waves-light">
      <span class="mdi mdi-pencil-outline"></span>
    </a>
  @endcan
</div>
<div class="card">
  <div class="card-body p-2">
    <div class="table-repsonsive">
      <table class="table table-bordered table-customize">
        <thead>
          <tr>
            <th>raison sociale</th>
            <th>net à payer</th>
            <th>payer</th>
            <th>reste</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="align-middle">
              {{ $fournisseur->raison_sociale }}
            </td>
            <td class="align-middle">
              <span class="mt">
                {{ number_format($fournisseur->montant,2,"," , " ") }} dh
              </span>
            </td>
            <td class="align-middle">
              <span class="mt text-success">
                {{ number_format($fournisseur->payer,2,"," , " ") }} dh
              </span>
            </td>
            <td class="align-middle">
              <span class="mt text-danger">
                {{ number_format($fournisseur->reste,2,"," , " ") }} dh
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs mt-4" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link text-uppercase fw-bold active "data-bs-toggle="tab" href="#info" role="tab" aria-selected="true">
          <span class="d-md-block d-none"> Information </span>
          <span class="d-md-none d-block mdi mdi-information-outline mdi-18px"></span>
        </a>
      </li>
      @can('ligneAchat-list')
        <li class="nav-item" role="presentation">
          <a class="nav-link text-uppercase fw-bold" data-bs-toggle="tab" href="#achats" role="tab" aria-selected="false" tabindex="-1">
            <span class="d-md-block d-none">les achats</span>
            <span class="d-md-none d-block mdi mdi-file-document-multiple-outline mdi-18px"></span>
          </a>
        </li>
      @endcan
      @can('achatPaiement-list')
        <li class="nav-item" role="presentation">
          <a class="nav-link text-uppercase fw-bold" data-bs-toggle="tab" href="#paiements" role="tab" aria-selected="false" tabindex="-1">
            <span class="d-md-block d-none">les paiements</span>
            <span class="d-md-none d-block mdi mdi-currency-usd mdi-18px"></span>
          </a>
        </li>
      @endcan
      <li class="nav-item" role="presentation">
        <a class="nav-link text-uppercase fw-bold" data-bs-toggle="tab" href="#files" role="tab" aria-selected="false" tabindex="-1">
          <span class="d-md-block d-none">documents</span>
          <span class="d-md-none d-block mdi mdi-file-pdf-outline mdi-18px"></span>
        </a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link text-uppercase fw-bold" data-bs-toggle="tab" href="#suivi" role="tab" aria-selected="false" tabindex="-1">
          <span class="d-md-block d-none">historiques</span>
          <span class="d-md-none d-block mdi mdi-history mdi-18px"></span>
        </a>
      </li>
    </ul>
      <div class="tab-content">
        {{-- basic information --}}
        <div class="tab-pane p-0 pt-3 @if(!Session::has('valider')) active @endif" id="info" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-bordered m-0 info">
              <tbody>
                <tr>
                  <td class="align-middle">
                    identifiant
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->identifiant != '' ?
                      $fournisseur->identifiant : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    raison sociale
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->raison_sociale != '' ?
                      $fournisseur->raison_sociale : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    adresse
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->adresse != '' ?
                      $fournisseur->adresse : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    ville
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->ville != '' ?
                      $fournisseur->ville : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    code postal
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->code_postal != '' ?
                      $fournisseur->code_postal : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    rc
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->rc != '' ?
                      $fournisseur->rc : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    ice
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->ice != '' ?
                      $fournisseur->ice : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    téléphone
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->phone != '' ?
                      $fournisseur->phone : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    fix
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->fix != '' ?
                      $fournisseur->fix : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    email
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->email != '' ?
                      $fournisseur->email : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    pays
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->pays != '' ?
                      $fournisseur->pays : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        {{-- les achats --}}
        <div class="tab-pane p-0 pt-3" id="achats" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-bordered m-0 table-sm">
              <thead>
                <tr>
                  <th>référence</th>
                  <th>date</th>
                  <th>montant</th>
                  <th>payer</th>
                  <th>reste</th>
                  <th>actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($ligneAchats as $ligneAchat)
                  <tr>
                    <td class="align-middle">
                      {{ $ligneAchat->num_achat }}
                    </td>
                    <td class="align-middle">
                      {{ $ligneAchat->date_achat }}
                    </td>
                    <td class="align-middle fw-bolder">
                      {{ number_format($ligneAchat->prix_ttc , 2 , "," ," ") }} dh
                    </td>
                    <td class="align-middle fw-bolder">
                      <span class="text-success">
                        {{ number_format($ligneAchat->payer , 2 , "," ," ") }} dh
                      </span>
                    </td>
                    <td class="align-middle fw-bolder">
                      <span class="text-danger">
                        {{ number_format($ligneAchat->reste , 2 , "," ," ") }} dh
                      </span>
                    </td>
                    <td class="align-middle fw-bolder">
                      <a href="{{ route('ligneAchat.show',$ligneAchat) }}" class="btn btn-primary waves-effect waves-light p-0 px-1" target="_blank">
                        <span class="mdi mdi-eye-outline"></span>
                      </a>
                      @if ($ligneAchat->status == "validé")
                        <a href="{{ route('ligneAchat.show',$ligneAchat) }}" class="btn btn-dark waves-effect waves-light p-0 px-1">
                          <span class="mdi mdi-file-outline"></span>
                        </a>
                      @endif
                    </td>

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          {{ $ligneAchats->links() }}
        </div>

        {{-- les paiements --}}
        @can('achatPaiement-list')
          <div class="tab-pane p-0 pt-3" id="paiements" role="tabpanel">
            <div class="table-responsive">
              <table class="table table-bordered m-0 table-sm">
                <thead>
                  <tr>
                    <th>numéro opération</th>
                    <th>facture</th>
                    <th>date</th>
                    <th>payer</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($paiements as $paiement)
                    <tr>
                      <td class="align-middle">
                        {{ $paiement->numero_operation }}
                      </td>
                      <td class="align-middle">
                        {{ $paiement->ligne->num_achat }}
                      </td>
                      <td class="align-middle">
                        {{ $paiement->date_paiement }}
                      </td>
                      <td class="align-middle">
                        <span class="mt fw-bold">
                          {{ number_format($paiement->payer , 2 , "," ," ") }} dh
                        </span>
                      </td>

                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        @endcan
        {{-- les files --}}
        <div class="tab-pane p-0 pt-3" id="files" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-bordered table-customize">
              <thead>
                <tr>
                  <th>nom</th>
                  <th>file</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="align-middle">
                    rapport de fournisseur
                  </td>
                  <td class="align-middle">
                    <a href="{{ route('fournisseur.rapportDocument',$fournisseur) }}" class="btn btn-primary waves-effect waves-light p-0 px-1">
                      <span class="mdi mdi-file-outline"></span>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        {{-- suivi --}}
        <div class="tab-pane p-0 pt-3" id="suivi" role="tabpanel">
          <h5 class="title d-md-none d-block">historiques des actions</h5>
          <div class="table-repsonsive">
            <table class="table table-customize m-0">
              <thead>
                <tr>
                  <th>action</th>
                  <th>utilisateur</th>
                  <th>date</th>
                  <th>temps</th>
                  <th>détails</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($fournisseur_suivis as $suivi)
                  <tr>
                    <td class="align-middle">
                      @if ($suivi->event == "created")
                      <span class="d-md-none d-block mdi mdi-plus-thick btn btn-success px-3 py-0">  </span>
                      <span class="d-md-block d-none bg-success px-2 py-1 rounded text-white fw-bold">
                        Nouveau
                      </span>
                      @elseif ($suivi->event == "deleted")
                      <span class="d-md-none d-block mdi mdi-trash-can-outline btn btn-danger px-3 py-0">  </span>
                      <span class="d-md-block d-none bg-danger px-2 py-1 rounded text-white fw-bold">
                        suppression
                      </span>
                      @elseif ($suivi->event == "updated")
                      <span class="d-md-none d-block mdi mdi-pencil-outline btn btn-primary px-3 py-0">  </span>
                      <span class="d-md-block d-none bg-primary px-2 py-1 rounded text-white fw-bold">
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
                      <div class="modal fade" tabindex="-1" id="display{{ $suivi->id }}" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                              </button>
                            </div>
                            <div class="modal-body p-2">
                              @php
                                $array_insert      = [];
                                $array_sup         = [];
                                $properties        = json_decode($suivi->properties, true);
                                $changedAttributes = [];
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
                              @endphp
                              @if (count($changedAttributes) > 0)
                                <ul class="list-group">
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
                                  @foreach($changedAttributes as $key => $values)
                                    @if(count($changedAttributes) > 0)
                                      <li class="list-group-item active text-center py-2">
                                        <b>{{ ucfirst($key) }}</b>
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
                                    @else
                                      <small>No changes recorded</small>
                                    @endif
                                  @endforeach
                                </ul>
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