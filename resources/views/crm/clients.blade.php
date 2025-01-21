@extends('layouts.master')
@section('content')



<div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
    <div>
      <h4 class="m-0">Liste du clients</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">

        @can("client-create")
        <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0 py-1 px-3" data-bs-toggle="modal" data-bs-target="#add">
            Ajouter
        </button>
        @endcan
    </div>
</div>


<div class="card">
    <div class="card-body p-2">
        <div class="table-responsive">
            <table id="dataTableExample" class="table table-bordered mb-0 table-sm">
                <thead>
                    <tr class="table-success">
                        <th>ICE</th>
                        <th>Raison Sociale</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        <th>Ville</th>
                        <th>Code postal</th>
                        <th>Staut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)
                        <tr>
                            <td class="align-middle">{{ $client->ice ?? "" }}</td>
                            <td class="align-middle">{{ $client->rs ?? "" }}</td>
                            <td class="align-middle">{{ $client->telephone ?? "" }}</td>
                            <td class="align-middle">{{ $client->adresse ?? "" }}</td>
                            <td class="align-middle">{{ $client->ville ?? "" }}</td>
                            <td class="align-middle">{{ $client->code_postal ?? "" }}</td>
                            <td class="align-middle">
                                <span @class([
                                    "mdi","align-middle",
                                    "mdi-checkbox-marked-circle-outline"=>$client->statut == "activer",
                                    "mdi-close-thick"=>$client->statut == "desactiver",
                                    "text-success"=>$client->statut == "activer",
                                    "text-danger"=>$client->statut == "desactiver",
                                    ])>
                                </span>
                                <span @class([
                                    "text-success"=>$client->statut == "activer",
                                    "text-danger"=>$client->statut == "desactiver",
                                ])>{{ $client->statut }}</span>
                            </td>
                            <td class="align-middle">
                                @can('client-modification')
                                    <button type="button" class="btn p-0 bg-trasparent border-0 text-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $client->id }}">
                                        <i class="mdi mdi-pencil" style="font-size: 0.90rem;"></i>
                                    </button>
                                @endcan
                                @can('client-delete')
                                    <button type="button" class="btn p-0 bg-trasparent border-0 text-primary" data-bs-toggle="modal" data-bs-target="#delete{{ $client->id }}">
                                        <i class="mdi mdi-trash-can"></i>
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

@foreach ($clients as $client)
    <div class="modal fade" id="edit{{ $client->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h5 class="modal-title m-0" id="varyingModalLabel">Modifier le client : {{ $client->rs }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('client.update',$client) }}" method="POST">
                        @csrf
                        @method("PUT")
                        <div class="row row-cols-lg-2 row-cols-1 mb-lg-3 mb-0">
                            <div class="col mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label ">Raison social</label>
                                    <input type="text" name="raison_social_u" id="" class="form-control form-control-sm @error('raison_social_u') is-invalid @enderror" value="{{ $client->rs }}">
                                    @error('raison_social_u')
                                        <span class="badge bg-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label ">ICE</label>
                                    <input type="text" name="ice_u" id="" class="form-control form-control-sm @error('ice_u') is-invalid @enderror"  value="{{ $client->ice }}">
                                    @error('ice_u')
                                        <span class="badge bg-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label">Adresse</label>
                                    <input type="text" name="adresse_u" id="" class="form-control form-control-sm @error('adresse_u') is-invalid @enderror" value="{{ $client->adresse }}">
                                    @error('adresse_u')
                                        <span class="badge bg-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label ">Ville</label>
                                    <input type="text" name="ville_u" id="" class="form-control form-control-sm @error('ville_u') is-invalid @enderror" value="{{ $client->ville }}">
                                    @error('ville_u')
                                        <span class="badge bg-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label ">Téléphone</label>
                                    <input type="text" name="telephone_u" id="" class="form-control form-control-sm @error('telephone_u') is-invalid @enderror" value="{{ $client->telephone }}">
                                    @error('telephone_u')
                                        <span class="badge bg-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label ">Code postal</label>
                                    <input type="text" name="code_postal_u" id="" class="form-control form-control-sm @error('code_postal_u') is-invalid @enderror" value="{{ $client->code_postal }}">
                                    @error('code_postal_u')
                                        <span class="badge bg-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label ">E-mail</label>
                                    <input type="email" name="email_u" id="" class="form-control form-control-sm @error('email_u') is-invalid @enderror" value="{{ $client->email }}">
                                    @error('email_u')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label ">Statut</label>
                                    <div class="form-check form-switch" dir="ltr">
                                        <input class="form-check-input py-2 px-3" type="checkbox" name="statut_u" id="SwitchCheckSizelg" value="activer" {{ $client->statut == "activer" ? "checked":"" }}>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="" class="form-label">Nom du group</label>
                                    <select name="group_id_u" id="" class="form-select form-select-sm">
                                        @foreach ($groupes as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $client->group_id ? "selected":"" }}>{{ $item->nom }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="" class="form-label">Remise</label>
                                    <input type="text" name="" id="" class="form-control form-control-sm" disabled value="{{ $client->group->remise ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-success py-1 px-3">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete{{ $client->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <form action="{{ route('client.destroy',$client) }}" method="POST">
                        @csrf
                        @method("DELETE")
                        <div class="p-3 mb-3">
                            <h5 class="mb-2 fw-bolder text-center">Voulez-vous supprimer défenitivement du client</h5>
                            <h6 class="text-danger text-center fw-bolder w-100">{{ $client->ice }}</h6>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-success p-3 w-100" style="border-radius:0;border-bottom-left-radius: 0.375rem;" data-bs-dismiss="modal" aria-label="btn-close">
                                Fermer
                            </button>
                            <button type="submit" class="btn btn-danger p-3 w-100 fw-bolder fs-6" style="border-radius:0;border-bottom-right-radius: 0.375rem;" >
                                Supprimer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endforeach
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h5 class="modal-title m-0" id="varyingModalLabel">Ajouter un client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('client.store') }}" method="POST">
                    @csrf
                    <div class="row row-cols-lg-2 row-cols-1 mb-lg-3 mb-0">
                        <div class="col mb-2">
                            <div class="form-group">
                                <label for="" class="form-label ">Raison social</label>
                                <input type="text" name="raison_social" id="" class="form-control form-control-sm @error('raison_social') is-invalid @enderror">
                                @error('raison_social')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-group">
                                <label for="" class="form-label ">ICE</label>
                                <input type="text" name="ice" id="" class="form-control form-control-sm @error('ice') is-invalid @enderror">
                                @error('ice')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-group">
                                <label for="" class="form-label">Adresse</label>
                                <input type="text" name="adresse" id="" class="form-control form-control-sm @error('adresse')is-invalid @enderror">
                                @error('adresse')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-group">
                                <label for="" class="form-label ">Ville</label>
                                <input type="text" name="ville" id="" class="form-control form-control-sm @error('ville') is-invalid @enderror">
                                @error('ville')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-group">
                                <label for="" class="form-label ">Téléphone</label>
                                <input type="text" name="telephone" id="" class="form-control form-control-sm @error('telephone') is-invalid @enderror">
                                @error('telephone')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-group">
                                <label for="" class="form-label ">Code postal</label>
                                <input type="text" name="code_postal" id="" class="form-control form-control-sm @error('code_postal') is-invalid @enderror">
                                @error('code_postal')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-group">
                                <label for="" class="form-label ">E-mail</label>
                                <input type="email" name="email" id="" class="form-control form-control-sm @error('email') is-invalid @enderror">
                                @error('email')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-group">
                                {{-- <label for="" class="form-label ">Statut</label> --}}
                                <select name="statut" id="" class="form-select form-select-sm">
                                    <option value="">Choisir le statut</option>
                                    <option value="activer">Activer</option>
                                    <option value="desactiver" selected>Desactiver</option>
                                </select>
                                {{-- <div class="form-check form-switch" dir="ltr">
                                    <input class="form-check-input py-2 px-3" type="checkbox" name="statut" id="SwitchCheckSizelg" value="activer">
                                </div> --}}
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-group">
                                {{-- <label for="" class="form-label">Nom du group</label> --}}
                                <select name="group_id" id="" class="form-select form-select-sm nom-group">
                                    <option value="">Séléctionner le nom du group</option>
                                    @foreach ($groupes as $group)
                                        <option value="{{ $group->id }}">{{ $group->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-group">
                                {{-- <label for="" class="form-label">Remise du group</label> --}}
                                <input type="text" name="" id="" class="form-control form-control-sm remise" disabled value="Remise du group">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success py-1 px-3">
                            <i class="mdi mdi-checkbox-marked-circle-outline align-middle"></i>
                            <span>Enregistrer</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $(".nom-group").on("change",function(){
            let id = $(this).val();
            $.ajax({
                type:"GET",
                url:"{{ route('getGroup') }}",
                data:{"id":id},
                success:function(data){
                    $(".remise").val(data.remise);
                }
            })
        })
    })

</script>
@endsection
