@extends('layouts.master')
@section('title')
    information du produit : {{ $produit->reference ?? '' }}
@endsection
@section('content')
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-1">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Acceuil</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">
            <a href="{{ route('produit.index') }}">
                Liste des produits
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            information du produit : {{ $produit->reference ?? '' }}
        </li>
    </ol>
</nav>

<div class="card">
    <div class="card-body p-2">
        <h6 class="my-3 text-center text-uppercase text-primary">
            <span class="border border-2 border-top-0 border-start-0 border-end-0 border-primary border-solid pb-1">information général</span>
        </h6>

        <div class="row row-cols-2">
            <div class="col">
                <ul class="list-group">
                    <li class="list-group-item py-2px">
                        <h6 class="m-0 text-uppercase fs-12">
                            <span class="float-start">référence : </span>
                            <span class="float-end fw-normal"> {{ $produit->reference ?? '' }} </span>
                        </h6>
                    </li>
                    <li class="list-group-item py-2px">
                        <h6 class="m-0 text-uppercase fs-12">
                            <span class="float-start">code : </span>
                            <span class="float-end fw-normal"> {{ $produit->code ?? '' }} </span>
                        </h6>
                    </li>
                    <li class="list-group-item py-2px">
                        <h6 class="m-0 text-uppercase fs-12">
                            <span class="float-start">désignation : </span>
                            <span class="float-end fw-normal"> {{ $produit->designation ?? '' }} </span>
                        </h6>
                    </li>
                    <li class="list-group-item py-2px">
                        <h6 class="m-0 text-uppercase fs-12">
                            <span class="float-start">entré : </span>
                            <span class="float-end fw-normal">{{ $produit->stock->entre ?? 0 }} </span>
                        </h6>
                    </li>
                    <li class="list-group-item py-2px">
                        <h6 class="m-0 text-uppercase fs-12">
                            <span class="float-start">sortie</span>
                            <span class="float-end fw-normal">{{ $produit->stock->sortie ?? 0 }}</span>
                        </h6>
                    </li>
                    <li class="list-group-item py-2px">
                        <h6 class="m-0 text-uppercase fs-12">
                            <span class="float-start">Reste</span>
                            <span class="float-end fw-normal">{{ $produit->stock->reste ?? 0 }}</span>
                        </h6>
                    </li>
                </ul>
            </div>
            <div class="col">
                <ul class="list-group">
                    <li class="list-group-item py-2px">
                        <h6 class="m-0 text-uppercase fs-12">
                            <span class="float-start">numéro</span>
                            <span class="float-end fw-normal">{{ $produit->stock->num ?? '' }}</span>
                        </h6>
                    </li>
                    <li class="list-group-item py-2px">
                        <h6 class="m-0 text-uppercase fs-12">
                            <span class="float-start">initial</span>
                            <span class="float-end fw-normal">{{ $produit->stock->inital ?? 0 }}</span>
                        </h6>
                    </li>
                    <li class="list-group-item py-2px">
                        <h6 class="m-0 text-uppercase fs-12">
                            <span class="float-start">n.r</span>
                            <span class="float-end fw-normal">{{ $produit->stock->reserverRetour ?? 0 }}</span>
                        </h6>
                    </li>
                    <li class="list-group-item py-2px">
                        <h6 class="m-0 text-uppercase fs-12">
                            <span class="float-start">r.v</span>
                            <span class="float-end fw-normal">{{ $produit->stock->reserverValider ?? 0 }}</span>
                        </h6>
                    </li>
                    <li class="list-group-item py-2px">
                        <h6 class="m-0 text-uppercase fs-12">
                            <span class="float-start">r.a</span>
                            <span class="float-end fw-normal">{{ $produit->stock->reserverAttente ?? 0 }}</span>
                        </h6>
                    </li>
                    <li class="list-group-item py-2px">
                        <h6 class="m-0 text-uppercase fs-12">
                            <span class="float-start">min</span>
                            <span class="float-end fw-normal">{{ $produit->stock->min ?? 0 }}</span>
                        </h6>
                    </li>
                </ul>
            </div>
        </div>
        <h6 class="my-3 text-center text-uppercase text-primary">
            <span class="border border-2 border-top-0 border-start-0 border-end-0 border-primary border-solid pb-1">historiques</span>
        </h6>
        <div class="table-reponsive">
            <table class="table table-bordered table-sm m-0">
                <thead class="table-warning">
                    <tr>
                        <th>fonction</th>
                        <th>quantité</th>
                        <th>date</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($produit->stock->history))
                        @foreach ($produit->stock->history as $history)
                            <tr>
                                <td class="align-middle"> {{ $history->fonction ?? '' }} </td>
                                <td class="align-middle"> {{ $history->quantite ?? 0 }} </td>
                                <td class="align-middle"> {{ date("d / m / Y",strtotime($history->date_mouvement)) }} </td>
                            </tr>

                        @endforeach

                    @else
                        <tr>
                            <td colspan="3">
                                <h6 class="m-0 fs-10 text-center text-uppercase py-2 text-danger">
                                    aucun historique du stock
                                </h6>
                            </td>
                        </tr>

                    @endif

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection