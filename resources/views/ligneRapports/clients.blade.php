@extends('layouts.master')
@section('content')
@php
    $check = "clients";
@endphp
  @include('ligneRapports.headeLinks',["id"=>$ligneRapport->id , "check" => $check])
  <div class="card">
    <div class="card-body p-2">
      <div class="row">
        <div class="col-lg-3">
          <h6>liste des clients</h6>
        </div>
        <div class="col">
          <div class="d-flex justify-content-end">
            <a href="{{ route('rapportClient.docClient',$ligneRapport->mois) }}" class="btn btn-doc waves-effect waves-light mb-1 me-2">
              document
            </a>
            <a href="{{ route('rapportClient.documentDay',$ligneRapport->mois) }}" class="btn btn-doc waves-effect waves-light mb-1 me-2">
              journaliste
            </a>
            <a href="{{ route('rapportClient.exportClient',$ligneRapport->mois) }}" class="btn btn-doc waves-effect waves-light mb-1">
              excel
            </a>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered table-sm">
          <thead class="table-primary">
            <tr>
              <th scope="col">Date</th>
              <th scope="col">identifiant</th>
              <th scope="col">name</th>
              <th scope="col">Montant</th>
              <th scope="col">Payer</th>
              <th scope="col">Reste</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($details as $detail)
              <tr>
                  <td>{{ $detail->jour }}</td>
                  <td>{{ $detail->identifiant }}</td>
                  <td>{{ $detail->name }}</td>
                  <td>
                    <span class="mt text-black">
                      {{ number_format($detail->montant , 2 , "," , " ") }} dh
                    </span>
                  </td>
                  <td>
                    <span class="mt text-success">
                      {{ number_format($detail->payer , 2 , "," , " ") }} dh
                    </span>
                  </td>
                  <td>
                    <span class="mt text-danger">
                      {{ number_format($detail->reste , 2 , "," , " ") }} dh
                    </span>
                  </td>

              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection