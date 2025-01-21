@extends('layouts.master')
@section('content')
<div class="row row-cols-lg-4 row-cols-md-2 row-cols-1 mb-2" id="widget">
    <div class="col">
        <div class="card m-0">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between">
                    <h6 class="text-uppercase fs-12 m-0">clients</h6>
                    <a href="{{ route('client.index') }}" class="text-decoration-none text-uppercase fs-12 fw-bolder">voir plus</a>
                </div>
                <h1 class="text-center my-2 text-primary">
                    {{ $count_client ?? 0 }}
                </h1>
                <div class="d-flex justify-content-between">
                    <h6 class="m-0 fs-12 text-capitalize text-muted">total : {{ $count_client ?? 0 }}</h6>
                    <h6 class="m-0 fs-12 text-capitalize">aujourd'hui : {{ $count_client_today ?? 0 }}</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card m-0">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between">
                    <h6 class="text-uppercase fs-12 m-0">factures</h6>
                    <a href="{{ route('facture.index') }}" class="text-decoration-none text-uppercase fs-12 fw-bolder">voir plus</a>
                </div>
                <h1 class="text-center my-2 text-primary">
                    {{ $count_facture ?? 0 }}
                </h1>
                <div class="d-flex justify-content-between">
                    <h6 class="m-0 fs-12 text-capitalize text-muted">total : {{ $count_facture ?? 0 }}</h6>
                    <h6 class="m-0 fs-12 text-capitalize">aujourd'hui : {{ $count_facture_today ?? 0 }}</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card m-0">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between">
                    <h6 class="text-uppercase fs-12 m-0">produits</h6>
                    <a href="{{ route('produit.index') }}" class="text-decoration-none text-uppercase fs-12 fw-bolder">voir plus</a>
                </div>
                <h1 class="text-center my-2 text-primary">
                    {{ $count_produit ?? 0 }}
                </h1>
                <div class="d-flex justify-content-between">
                    <h6 class="m-0 fs-12 text-capitalize text-muted">total : {{ $count_produit ?? 0 }}</h6>
                    <h6 class="m-0 fs-12 text-capitalize">aujourd'hui : {{ $count_produit_today ?? 0 }}</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card m-0">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between">
                    <h6 class="text-uppercase fs-12 m-0">stocks</h6>
                    <a href="{{ route('stock.index') }}" class="text-decoration-none text-uppercase fs-12 fw-bolder">voir plus</a>
                </div>
                <h1 class="text-center my-2 text-primary">
                    {{ $count_stock ?? 0 }}
                </h1>
                <div class="d-flex justify-content-between">
                    <h6 class="m-0 fs-12 text-capitalize text-muted">total : {{ $count_stock ?? 0 }}</h6>
                    <h6 class="m-0 fs-12 text-capitalize">aujourd'hui : {{ $count_stock_today ?? 0 }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="row row-cols-2">
  <div class="col">
    <h5 class="title">
      liste des stocks alert
    </h5>
    <div class="card">
      <div class="card-body p-2">
        <div class="table-responsive">
          <table class="table table-bordered table-customize m-0">
            <thead>
              <tr>
                <th>num</th>
                <th>produit</th>
                <th>quantite disponible</th>
                <th>quantite alert</th>
                <th>q.v réserver</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($stocks as $stock)
                <tr>
                  <td class="align-middle"> {{ $stock->num }} </td>
                  <td class="align-middle"> {{ $stock->produit->designation }} - {{ $stock->produit->reference }} </td>
                  <td class="align-middle"> {{ $stock->disponible }}</td>
                  <td class="align-middle"> {{ $stock->qte_alert }}</td>
                  <td class="align-middle"> {{ $stock->qte_venteRes }}</td>
                </tr>
              @empty
                <tr>
                  <td class="align-middle" colspan="5">
                    Aucun donnéee
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        @if ($stock_count > 5)
          <a href="#" class="btn btn-bleu waves-effect waves-light">
            voir plus
          </a>
        @endif
      </div>
    </div>
  </div>
</div>


@endsection
