@extends('layouts.master')
@section('title')
  suivi : {{ $client->raison_sociale }}
@endsection
@section('content')
@include('sweetalert::alert')
  <div class="d-flex justify-content-between align-items-center">
    <h4 class="title">
      <a href="{{ route('client.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light me-2">
        <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
      </a>
      Client : {{ $client->raison_sociale ?? '' }}
    </h4>
    @can('client-modification')
    <a href="{{ route('client.edit',$client->id) }}" class="btn btn-header px-4 waves-effect waves-light">
      <span class="mdi mdi-pencil-outline"></span>
    </a>
    @endcan
  </div>
<div class="card">
  <div class="card-body p-2">

    <div class="table-responsive">
      <table class="table table-bordered m-0">
        <thead class="table-primary">
          <tr>
            <th>identifiant</th>
            <th>montant</th>
            <th>payer</th>
            <th>reste</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="align-middle">
              <span class="mt fw-bold text-primary">
              {{ number_format($client->montant_devis , 2 , "," ," ") . ' dh' }}
            </span>
            </td>
            <td class="align-middle">
              <span class="mt fw-bold">
                {{ number_format($client->montant , 2 , "," ," ") . ' dh' }}
              </span>
            </td>
            <td class="align-middle">
              <span class="mt fw-bold text-success">
                {{ number_format($client->payer , 2 , "," ," ") . ' dh' }}
              </span>
            </td>
            <td class="align-middle">
              <span class="mt fw-bold text-danger">
              {{ number_format($client->reste , 2 , "," ," ") . ' dh' }}
            </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs mt-4" role="tablist">
      <li class="nav-item">
        <a class="nav-link text-uppercase fw-bold  @if(!Session::has('valider')) active @endif" data-bs-toggle="tab" href="#info" role="tab">
          <span class="d-md-block d-none"> Information </span>
          <span class="d-md-none d-block mdi mdi-information-outline mdi-18px"></span>
        </a>
      </li>
      @can('facture-list')
        <li class="nav-item">
          <a class="nav-link text-uppercase fw-bold" data-bs-toggle="tab" href="#factures" role="tab">
            <span class="d-md-block d-none">les commandes</span>
            <span class="d-md-none d-block mdi mdi-file-document-multiple-outline mdi-18px"></span>
          </a>
        </li>
      @endcan
      @can('facturePaiement-list')
        <li class="nav-item">
          <a class="nav-link text-uppercase fw-bold" data-bs-toggle="tab" href="#paiements" role="tab">
            <span class="d-md-block d-none">les paiements</span>
            <span class="d-md-none d-block mdi mdi-currency-usd mdi-18px"></span>
          </a>
        </li>
      @endcan
      <li class="nav-item">
        <a class="nav-link text-uppercase fw-bold" data-bs-toggle="tab" href="#files" role="tab">
          <span class="d-md-block d-none">documents</span>
          <span class="d-md-none d-block mdi mdi-file-pdf-outline mdi-18px"></span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-uppercase fw-bold" data-bs-toggle="tab" href="#suivi" role="tab">
          <span class="d-md-block d-none">historiques</span>
          <span class="d-md-none d-block mdi mdi-history mdi-18px"></span>

        </a>
      </li>
    </ul>

    <div class="tab-content">
      {{-- basic information --}}
      <div class="tab-pane p-0 pt-3 @if(!Session::has('valider')) active @endif" id="info" role="tabpanel">
        <h5 class="title d-md-none d-block">basic information</h5>
        <div class="row row-cols-lg-2 row-cols-1">
          <div class="col">
            <div class="table-responsive">
              <table class="table table-bordered m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">
                      identifiant
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->identifiant != '' ?
                        $client->identifiant : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      raison sociale
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->raison_sociale != '' ?
                        $client->raison_sociale : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      ice
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->ice != '' ?
                        $client->ice : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      if
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->if != '' ?
                        $client->if : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      rc
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->rc != '' ?
                        $client->rc : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      téléphone
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->telephone != '' ?
                        $client->telephone : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      responsable
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->responsable != '' ?
                        $client->responsable : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      email
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->email != '' ?
                        $client->email : '<i>aucun</i>'
                      !!}
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
                  <tr>
                    <td class="align-middle">
                      activite
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->activite != '' ?
                        $client->activite : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      adresse
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->adresse != '' ?
                        $client->adresse : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      ville
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->ville != '' ?
                        $client->ville : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      code postal
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->code_postal != '' ?
                        $client->code_postal : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      group
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->group &&
                        $client->group->nom  != '' ?
                        $client->group->nom : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      remise
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->group &&
                        $client->group->remise  != '' ?
                        $client->group->remise . "%" : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      type
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->type_client  != '' ?
                        $client->type_client : '<i>n / a</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      max montant payé ( espèce )
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->maxMontantPayer  != '' ?
                        number_format($client->maxMontantPayer , 2 , "," ," ") . " dh" : '<i>n / a</i>'
                      !!}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      {{-- les commandes --}}
      @can('facture-list')
        <div class="tab-pane p-0 pt-3" id="factures" role="tabpanel">
          <h5 class="title d-md-none d-block">les commandes</h5>
          <div class="table-responsive">
            <table class="table table-bordered m-0 table-sm">
              <thead>
                <tr>
                  <th>référence</th>
                  <th>date</th>
                  <th>tva</th>
                  <th>remise</th>
                  <th>montant</th>
                  <th>ttc</th>
                  <th>net à payer</th>
                  <th>payer</th>
                  <th>reste</th>
                  <th>actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($factures as $facture)
                  <tr>
                    <td class="align-middle">
                      {{ $facture->num }}
                    </td>
                    <td class="align-middle">
                      {{ $facture->date_facture }}
                    </td>
                    <td class="align-middle">
                      <span class="mt fw-bold">
                        {{ number_format($facture->taux_tva , 2 , "," ," ") }} %
                      </span>
                    </td>
                    <td class="align-middle">
                      <span class="mt fw-bold">
                        {{ number_format($facture->remise , 2 , "," ," ") }} %
                      </span>
                    </td>
                    <td class="align-middle">
                      <span class="mt fw-bold">
                        {{ number_format($facture->ht , 2 , "," ," ") }} dh
                      </span>
                    </td>
                    <td class="align-middle">
                      <span class="mt fw-bold">
                        {{ number_format($facture->ttc , 2 , "," ," ") }} dh
                      </span>
                    </td>
                    <td class="align-middle">
                      <span class="text-primary mt fw-bold">
                        {{ number_format($facture->net_payer , 2 , "," ," ") }} dh
                      </span>
                    </td>

                    <td class="align-middle">
                      <span class="text-success mt fw-bold">
                        {{ number_format($facture->payer , 2 , "," ," ") }} dh
                      </span>
                    </td>
                    <td class="align-middle">
                      <span class="text-danger mt fw-bold">
                        {{ number_format($facture->reste , 2 , "," ," ") }} dh
                      </span>
                    </td>
                    <td class="align-middle">
                      <a href="{{ route('facture.show',$facture) }}" class="btn btn-primary waves-effect waves-light p-0 px-1" target="_blank">
                        <span class="mdi mdi-eye-outline"></span>
                      </a>
                      @if ($facture->statut == "validé")

                      <a href="{{ route('facture.show',$facture) }}" class="btn btn-dark waves-effect waves-light p-0 px-1">
                          <span class="mdi mdi-file-outline"></span>
                        </a>
                      @endif
                      @if ($facture->statut == "validé" && isset($facture->adresse_livraison))
                        <a href="{{ route('facturePaiement.add',$facture) }}" class="btn btn-success waves-effect wave-light p-0 px-1">
                          <span class="mdi mdi-plus"></span>
                        </a>
                      @endif
                    </td>

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @endcan

      {{-- information paiement --}}
      @can('facturePaiement-list')
      <div class="tab-pane p-0 pt-3" id="paiements" role="tabpanel">
        <h5 class="title d-md-none d-block">les paiements</h5>
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
                    {{ $paiement->facture->num }}
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
        <h5 class="title d-md-none d-block">les documents</h5>
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
                  rapport de client
                </td>
                <td class="align-middle">
                  <a href="{{ route('client.rapportDocument',$client) }}" class="btn btn-primary waves-effect waves-light p-0 px-1">
                    <span class="mdi mdi-file-outline"></span>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      {{-- suivis --}}
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
              @foreach ($clients_suivi as $suivi)
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