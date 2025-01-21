@extends('layouts.master')
@section('content')
@php
$check = "achats";
@endphp
@include('ligneRapports.headeLinks',["id"=>$ligneRapport->id , "check" => $check])
  <div class="card">
    <div class="card-body p-2">
      <div class="row">
        <div class="col-lg-3">
          <h6>liste des achats</h6>
        </div>
        <div class="col">
          <div class="d-flex justify-content-end">
            <a href="{{ route('rapportAchat.docAchat',$ligneRapport->mois) }}" class="btn btn-doc waves-effect waves-light mb-1 me-2">
              document
            </a>
            <a href="{{ route('rapportAchat.documentDay',$ligneRapport->mois) }}" class="btn btn-doc waves-effect waves-light mb-1 me-2">
              journaliste
            </a>
            <a href="{{ route('rapportAchat.exportAchat',$ligneRapport->mois) }}" class="btn btn-doc waves-effect waves-light mb-1">
              excel
            </a>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th scope="col">Date</th>
              <th scope="col">raison sociale</th>
              <th scope="col">identifiant</th>
              <th scope="col">References</th>
              <th scope="col">Montant</th>
              <th scope="col">Payer</th>
              <th scope="col">Reste</th>
              <th scope="col">statut</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($details as $detail)
              <tr>
                  <th>{{ $detail->jour }}</th>
                  <td> {{ $detail->raison_sociale }} </td>
                  <td> {{ $detail->identifiant }} </td>
                  <th>{{ $detail->reference }}</th>
                  <td>{{ $detail->montant }}</td>
                  <td>{{ $detail->payer }}</td>
                  <td>{{ $detail->reste }}</td>
                  <td>{{ $detail->status }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection