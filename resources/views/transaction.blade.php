
@extends('layouts.master')
@section('title')
    Liste des transactions
@endsection
@section('content')
@include('sweetalert::alert')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-1">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Acceuil</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Liste des transactions
        </li>
    </ol>
</nav>
<div class="card">
    <div class="card-body p-2">
            @can('transaction-nouveau')
                <button  class="btn btn-primary  mb-2 px-3 text-uppercase fw-bolder" data-bs-toggle="modal" data-bs-target="#nouveau">
                    Nouveau
                </button>
            @endcan
        <div class="table-responsive">
            <table class="table table-bordered m-0 table-sm datatable">
                <thead class="table-success">
                    <tr>
                        <th>date</th>
                        <th>montant</th>
                        <th>client</th>
                        <th>remarque</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td class="align-middle">{{ $transaction->date_transaction ?? "" }}</td>
                            <td class="align-middle">{{ $transaction->montant ?? "0" }} DH</td>
                            <td class="align-middle">
                                {{ $transaction->client->raison_sociale ?? "" }}
                            </td>
                            <td class="align-middle">
                                {{ $transaction->remarque ?? "" }}
                            </td>
                            <td class="align-middle">
                                @can('transaction-modification')
                                    <button type="button" class="btn p-0 bg-transparent border-0 text-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $transaction->id }}">
                                        <i class="ti-pencil" style="font-size: 0.90rem;"></i>
                                    </button>
                                @endcan
                                @can('transaction-suppression')
                                    <button type="button" class="btn p-0 bg-transparent border-0 text-danger" data-bs-toggle="modal" data-bs-target="#destroy{{ $transaction->id }}">
                                        <i class="ti-trash" style="font-size: 0.90rem;"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade"  id="nouveau" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary py-2">
                <h6 class="modal-title m-0 text-white fw-bolder" >Ajouter une transaction</h6>
                <button  class="btn btn-transparent p-0 text-white border-0" data-bs-dismiss="modal" aria-label="Close">
                    <span class="mdi mdi-close-thick"></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('transaction.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col mb-2">
                            <div class="form-group m-0">
                                <label for="" class="form-label">Client</label>
                                <select name="client" id="" class="form-select form-select-sm">
                                    <option value="">Choisir le client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->raison_sociale ?? "" }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-group m-0">
                                <label for="" class="form-label">Date</label>
                                <input type="date" name="date" id="" class="form-control form-control-sm" value="<?php echo date('Y-m-d');?>">
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-group m-0">
                                <label for="" class="form-label">Montant</label>
                                <input type="number" name="montant" id="" class="form-control form-control-sm" min="0" step="any">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="form-label">Remarque</label>
                        <textarea name="remarque" id="" cols="30" rows="2" class="form-control"></textarea>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-sm btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


@foreach ($transactions as $transaction)

    <div class="modal fade"  id="edit{{ $transaction->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary py-2">
                    <h6 class="modal-title m-0 text-white fw-bolder" >Modifier le transaction : {{ $transaction->id }}</h6>
                    <button  class="btn btn-transparent p-0 text-white" data-bs-dismiss="modal" aria-label="Close">
                        <span class="mdi mdi-close"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('transaction.update',$transaction) }}" method="post">
                        @csrf
                        @method("PUT")
                        <div class="row">
                            <div class="col mb-2">
                                <div class="form-group m-0">
                                    <label for="" class="form-label">Client</label>
                                    <select name="client_u" id="" class="form-control form-control-sm">
                                        <option value="">Choisir le client</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}" {{ $transaction->client_id == $client->id ? "selected":"" }} >{{ $client->raison_sociale ?? "" }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="form-group m-0">
                                    <label for="" class="form-label">Date</label>
                                    <input type="date" name="date_u" id="" class="form-control form-control-sm" value="{{ $transaction->date_transaction }}">
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="form-group m-0">
                                    <label for="" class="form-label">Montant</label>
                                    <input type="number" name="montant_u" id="" class="form-control form-control-sm" min="0" step="any" value="{{ $transaction->montant ?? '0' }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="form-label">Remarque</label>
                            <textarea name="remarque_u" id="" cols="30" rows="2" class="form-control">{{ $transaction->remarque ?? "" }}</textarea>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-sm btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="destroy{{ $transaction->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h6 class="modal-title m-0" id="exampleModalCenterTitle">Confirmer la suppression</h6>
                    <button type="button" class="btn bg-transparent p-0 border-0 border-0" data-bs-dismiss="modal" aria-label="Close">
                        <span class="mdi mdi-close-thick"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('transaction.destroy',$transaction) }}" method="post">
                        @csrf
                        @method("DELETE")
                        <h6 class="mb-2 text-center text-muted">
                            Voulez-vous vraiment déplacer du transaction vers la corbeille
                        </h6>
                        <h6 class="mb-2 text-center text-uppercase fw-bolder fs-12 text-danger">
                            date du transaction : {{ $transaction->date_transaction }}
                        </h6>
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <button type="submit" class="btn btn-success btn-sm w-100">OUI</button>
                            </div>
                            <div class="col-lg-5">
                                <button type="button" class="btn btn-danger btn-sm w-100" data-bs-dismiss="modal" aria-label="Close">
                                    NON
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade"  id="destroy{{ $transaction->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md modal-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{ route('transaction.destroy',$transaction) }}" method="post">
                        @csrf
                        @method("DELETE")
                        <h5 class="mb-2">Voulez-vous supprimer définitivement la transaction</h5>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-dark btn-sm w-100" data-bs-dismiss="modal" aria-label="Close">NON</button>
                            <button type="submit" class="btn btn-sm btn-primary w-100">OUI</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endforeach
@endsection
