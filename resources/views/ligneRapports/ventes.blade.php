@extends('layouts.master')
@section('content')
@php
    $check = "ventes";
@endphp
  @include('ligneRapports.headeLinks',["id"=>$ligneRapport->id , "check" => $check])
  <div class="card">
    <div class="card-body p-2">
      <div class="row">
        <div class="col-lg-3">
          <h6 class="sub-title">liste des ventes</h6>
        </div>
        <div class="col">
          <div class="d-flex justify-content-end">
            <a href="{{ route('rapportVente.docVente',$ligneRapport->mois) }}" class="btn btn-doc waves-effect waves-light mb-1 me-2">
              document
            </a>
            <a href="{{ route('rapportVente.documentDay',$ligneRapport->mois) }}" class="btn btn-doc waves-effect waves-light mb-1 me-2">
              journaliste
            </a>
            <a href="{{ route('rapportVente.exportVente',$ligneRapport->mois) }}" class="btn btn-doc waves-effect waves-light mb-1">
              excel
            </a>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th scope="col">name</th>
              <th scope="col">identifiant</th>
              <th scope="col">Date</th>
              <th scope="col">References</th>
              <th scope="col">Montant</th>
              <th scope="col">Payer</th>
              <th scope="col">Reste</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($details as $detail)
              <tr>
                  <th>{{ $detail->raison_sociale }}</th>
                  <th>{{ $detail->identifiant }}</th>
                  <th>{{ $detail->jour }}</th>
                  <th>{{ $detail->reference }}</th>
                  <td>{{ $detail->montant }}</td>
                  <td>{{ $detail->payer }}</td>
                  <td>{{ $detail->reste }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection