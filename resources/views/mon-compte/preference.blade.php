
@extends('layouts.master')
@section('title')
    Mes préférences
@endsection
@section('content')
@include('sweetalert::alert')
    <div class="card">
        <div class="card-body p-2">
            <form action="{{ route('profil.update',$user) }}" method="post">
                @csrf
                @method("PUT")
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <table class="table table-striped table-sm m-0">
                            <tbody>
                                <tr>
                                    <th class="align-middle">Prénom & Nom <span class="text-danger">*</span></th>
                                    <td class="align-middle">
                                        <input type="text" name="name" id="" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name ?? '' }}">
                                        @error('name')
                                            <strong class="invalid-feedback">{{ $message }} </strong>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th class="align-middle">Username <span class="text-danger">*</span></th>
                                    <td class="align-middle">
                                        <input type="text" name="username" id="" class="form-control  @error('email') is-invalid @enderror" value="{{ $user->username ?? '' }}">
                                        @error('username')
                                            <strong class="invalid-feedback">{{ $message }} </strong>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th class="align-middle">E-mail</th>
                                    <td class="align-middle">
                                        <input type="email" name="email" id="" class="form-control" value="{{ $user->email ?? '' }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="align-middle">Fonction</th>
                                    <td class="align-middle">
                                        <input type="text" name="fonction" id="" class="form-control" value="{{ $user->role ?? '' }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="align-middle">Statut</th>
                                    <td class="align-middle">
                                        <span class="badge bg-success">{{ $user->statut }}</span>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updatePwd">
                        <span class="mdi mdi-lock-outline align-middle"></span>
                        <span>Changer le mot de passe</span>
                    </button>


                    <button type="submit" class="btn btn-sm btn-success">
                        <span class="mdi mdi-check-bold align-middle"></span>
                        <span>Modifier</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="updatePwd" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header py-2 bg-primary">
                    <h6 class="modal-title m-0 text-white" id="varyingModalLabel">Changer le mot de passe</h6>
                    <button type="button" class="btn btn-transparent p-0 text-white border-0" data-bs-dismiss="modal" aria-label="btn-close">
                        <i class="mdi mdi-close-thick"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pwd.update',$user) }}" method="POST">
                        @csrf
                        @method("PUT")
                        <div class="form-group mb-2">
                            <label for="" class="form-label">Mot de passe</label>
                            <input type="password" name="password" id="" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <strong class="invalid-feedback">{{ $message }} </strong>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" id="" class="form-control">
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary w-100 shadow-none">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection