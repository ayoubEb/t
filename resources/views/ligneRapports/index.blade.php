@extends('layouts.master')
@section('content')


<div class="row row-cols-3">
  @foreach ($ligneRapports as $ligneRapport)
  <div class="col">
    <div class="card @if($ligneRapport->mois == date('m-Y')) bg-vert-light @endif">
      <div class="card-body py-3">
        <h6 class="text-center m-0 text-uppercase mb-3">
          numéro de rapport :  {{ $ligneRapport->num }}
        </h6>
        <h6 class="text-center m-0 text-uppercase mb-3  @if($ligneRapport->mois == date('m-Y')) text-dark @else text-primary @endif">
          mois :  {{ $ligneRapport->mois }}
        </h6>
        <div class="d-flex justify-content-center">
          <a href="{{ route('ligneRapport.show',$ligneRapport) }}" class="btn btn-lien waves-effect waves-light px-5">
            détails
          </a>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

{{-- <div class="row row-cols-2">
  <div class="col">
    <div class="card">
      <div class="card-body p-2">
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <span class="mdi mdi-check-bold align-middle"></span>
            liste des achats
          </li>
          <li class="list-group-item">
            <span class="mdi mdi-check-bold align-middle"></span>
            liste des ventes
          </li>
        </ul>
        <div class="row row-cols-4">

          <div class="col">
            <a href="{{ route('ligneRapport.listeBuySell') }}" class="btn btn-lien waves-effect waves-light w-100">
              <span class="mdi mdi-eye-outline align-middle"></span>
              <span>tout</span>
            </a>
          </div>

          <div class="col">
            <a href="{{route('ligneRapport.buySell', $ligne_today->mois)}}" class="btn btn-lien waves-effect waves-light w-100">
              <span class="mdi mdi-information-outline align-middle"></span>
              <span>détails</span>
            </a>
          </div>

          <div class="col">
            <a href="{{route('ligneRapport.docBuySell', $ligne_today->mois)}}" class="btn btn-doc waves-effect waves-light w-100">
              <span class="mdi mdi-file-outline align-middle"></span>
              <span>pdf</span>
            </a>
          </div>

          <div class="col">
            <a href="{{route('ligneRapport.exportBuySell', $ligne_today->mois)}}" class="btn btn-doc waves-effect waves-light w-100">
              <span class="mdi mdi-microsoft-excel align-middle"></span>
              <span>excel</span>
            </a>
          </div>

        </div>
    </div>
  </div>
</div>


    {{-- Achats --}}
    {{-- <div class="col">
      <div class="card">
        <div class="card-header text-white fw-bold">
          Achats : {{ date("m-Y") }}
        </div>
        <div class="card-body p-2">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <h6 class="text-uppercase">
                total :
                {{ isset($ligne_today) && $ligne_today->montant_achat != '' ? number_format($ligne_today->montant_achat , 2 ,","," ")." dhs" : "0.00" }}
              </h6>
            </li>
            <li class="list-group-item">
              <h6 class="text-uppercase m-0 text-success">
                payé :
                {{ isset($ligne_today) && $ligne_today->payer_achat != '' ? number_format($ligne_today->payer_achat , 2 ,","," ")." dhs" : "0.00" }}
              </h6>
            </li>
            <li class="list-group-item">
              <h6 class="text-uppercase m-0 text-danger">
                reste :
                {{ isset($ligne_today) && $ligne_today->reste_achat != '' ? number_format($ligne_today->reste_achat , 2 ,","," ")." dhs" : "0.00" }}
              </h6>
            </li>
          </ul>
          <div class="row row-cols-4">
            <div class="col">
              <a href="{{ route('ligneRapport.achats') }}" class="btn btn-lien waves-effect waves-light w-100">
                <span class="mdi mdi-eye-outline align-middle"></span>
                <span>tout</span>
              </a>
            </div>
            <div class="col">
              <a href="{{ route('ligneRapport.showAchat',isset($ligne_today) && $ligne_today->mois != '' ? $ligne_today->mois : '') }}" class="btn btn-lien waves-effect waves-light w-100">
                <span class="mdi mdi-eye-outline align-middle"></span>
                <span>détails</span>
              </a>
            </div>
            <div class="col">
              <a href="{{ route('ligneRapport.docAchat',isset($ligne_today) && $ligne_today->mois != '' ? $ligne_today->mois : '') }}" class="btn btn-doc waves-effect waves-light w-100">
                <span class="mdi mdi-file-outline align-middle"></span>
                <span>pdf</span>
              </a>
            </div>
            <div class="col">
              <a href="{{ route('ligneRapport.exportAchat',isset($ligne_today) && $ligne_today->mois != '' ? $ligne_today->mois : '') }}" class="btn btn-doc waves-effect waves-light w-100">
                <span class="mdi mdi-microsoft-excel align-middle"></span>
                <span>excel</span>
              </a>

            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card">
        <div class="card-header text-white fw-bold">
          Ventes : {{ date("m-Y") }}
        </div>
        <div class="card-body p-2">

          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <h6 class="text-uppercase">
                total :
                {{ isset($ligne_today) && $ligne_today->montant_vente != '' ? number_format($ligne_today->montant_vente , 2 ,","," ")." dhs" : "0.00" }}
              </h6>
            </li>
            <li class="list-group-item">
              <h6 class="text-uppercase m-0 text-success">
                payé :
                {{ isset($ligne_today) && $ligne_today->payer_vente != '' ? number_format($ligne_today->payer_vente , 2 ,","," ")." dhs" : "0.00" }}
              </h6>
            </li>
            <li class="list-group-item">
              <h6 class="text-uppercase m-0 text-danger">
                reste :
                {{ isset($ligne_today) && $ligne_today->reste_vente != '' ? number_format($ligne_today->reste_vente , 2 ,","," ")." dhs" : "0.00" }}
              </h6>
            </li>
          </ul>
          <div class="row row-cols-4">
            <div class="col">
              <a href="{{ route('ligneRapport.ventes' ) }}" class="btn btn-lien waves-effect waves-light w-100">
                <span class="mdi mdi-eye-outline align-middle"></span>
                <span>tout</span>
              </a>
            </div>
            <div class="col">
              <a href="{{ route('ligneRapport.showVente',isset($ligne_today) && $ligne_today->mois != '' ? $ligne_today->mois : '') }}" class="btn btn-lien waves-effect waves-light w-100">
                <span class="mdi mdi-eye-outline align-middle"></span>
                <span>détails</span>
              </a>
            </div>
            <div class="col">
              <a href="{{ route('ligneRapport.docVente',isset($ligne_today) && $ligne_today->mois != '' ? $ligne_today->mois : '') }}" class="btn btn-doc waves-effect waves-light w-100">
                <span class="mdi mdi-file-outline align-middle"></span>
                <span>pdf</span>
              </a>
            </div>
            <div class="col">
              <a href="{{ route('ligneRapport.exportVente',isset($ligne_today) && $ligne_today->mois != '' ? $ligne_today->mois : '') }}" class="btn btn-doc waves-effect waves-light w-100">
                <span class="mdi mdi-microsoft-excel align-middle"></span>
                <span>excel</span>
              </a>

            </div>
          </div>
        </div>
      </div>
    </div> --}}







  </div>

@endsection
