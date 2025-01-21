@extends('layouts.master')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Acceuil</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ route('ligneRapport.ventes') }}">Rapport</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ $mois }}
            </li>
        </ol>
    </nav>

    <div class="card">
        <table class="table table-bordered">
            <thead>
                <tr>
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
                        <th>{{ $detail->jour }}</th>
                        <th>{{ $detail->reference }}</th>
                        <td>{{ $detail->montant }}</td>
                        <td>{{ $detail->payer }}</td>
                        <td>{{ $detail->reste }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        <a href="{{ url()->previous() }}" class="btn btn-primary">
            <i class="dripicons-arrow-thin-left"></i>
        </a>

    </div>
@endsection