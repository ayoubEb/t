@extends('layouts.master')
@section('content')
<div class="row row-cols-3">

    <div class="col">
      <div class="card">
        <div class="card-body py-3">
          <h6 class="text-center m-0 text-uppercase mb-3">
            catégories
          </h6>


          <div class="d-flex justify-content-center">
            <a href="{{ route('historique.categories' ) }}" class="btn btn-lien waves-effect waves-light px-5">
              détails
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card">
        <div class="card-body py-3">
          <h6 class="text-center m-0 text-uppercase mb-3">
            groupes
          </h6>

          <div class="d-flex justify-content-center">
            <a href="{{ route('historique.groupes' ) }}" class="btn btn-lien waves-effect waves-light px-5">
              détails
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card">
        <div class="card-body py-3">
          <h6 class="text-center m-0 text-uppercase mb-3">
            entreprises
          </h6>

          <div class="d-flex justify-content-center">
            <a href="{{ route('historique.entreprises' ) }}" class="btn btn-lien waves-effect waves-light px-5">
              détails
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card">
        <div class="card-body py-3">
          <h6 class="text-center m-0 text-uppercase mb-3">
          type clients
          </h6>
          <div class="d-flex justify-content-center">
            <a href="{{ route('historique.typeClients' ) }}" class="btn btn-lien waves-effect waves-light px-5">
              détails
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card">
        <div class="card-body py-3">
          <h6 class="text-center m-0 text-uppercase mb-3">
          taux tvas
          </h6>
          <div class="d-flex justify-content-center">
            <a href="{{ route('historique.taux' ) }}" class="btn btn-lien waves-effect waves-light px-5">
              détails
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card">
        <div class="card-body py-3">
          <h6 class="text-center m-0 text-uppercase mb-3">
            livraisons
          </h6>

          <div class="d-flex justify-content-center">
            <a href="{{ route('historique.livraisons' ) }}" class="btn btn-lien waves-effect waves-light px-5">
              détails
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card">
        <div class="card-body py-3">
          <h6 class="text-center m-0 text-uppercase mb-3">
            condition paiements
          </h6>

          <div class="d-flex justify-content-center">
            <a href="{{ route('historique.conditionPaiements' ) }}" class="btn btn-lien waves-effect waves-light px-5">
              détails
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card">
        <div class="card-body py-3">
          <h6 class="text-center m-0 text-uppercase mb-3">
            clients
          </h6>

          <div class="d-flex justify-content-center">
            <a href="{{ route('historique.clients' ) }}" class="btn btn-lien waves-effect waves-light px-5">
              détails
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card">
        <div class="card-body py-3">
          <h6 class="text-center m-0 text-uppercase mb-3">
            users
          </h6>

          <div class="d-flex justify-content-center">
            <a href="{{ route('historique.users' ) }}" class="btn btn-lien waves-effect waves-light px-5">
              détails
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card">
        <div class="card-body py-3">
          <h6 class="text-center m-0 text-uppercase mb-3">
            achat paiements
          </h6>

          <div class="d-flex justify-content-center">
            <a href="{{ route('historique.achatPaiements' ) }}" class="btn btn-lien waves-effect waves-light px-5">
              détails
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card">
        <div class="card-body py-3">
          <h6 class="text-center m-0 text-uppercase mb-3">
            achat chèques
          </h6>

          <div class="d-flex justify-content-center">
            <a href="{{ route('historique.achatCheques' ) }}" class="btn btn-lien waves-effect waves-light px-5">
              détails
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card">
        <div class="card-body py-3">
          <h6 class="text-center m-0 text-uppercase mb-3">
            facture paiements
          </h6>

          <div class="d-flex justify-content-center">
            <a href="{{ route('historique.facturePaiements' ) }}" class="btn btn-lien waves-effect waves-light px-5">
              détails
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card">
        <div class="card-body py-3">
          <h6 class="text-center m-0 text-uppercase mb-3">
            facture chèques
          </h6>

          <div class="d-flex justify-content-center">
            <a href="{{ route('historique.factureCheques' ) }}" class="btn btn-lien waves-effect waves-light px-5">
              détails
            </a>
          </div>
        </div>
      </div>
    </div>

</div>
@endsection