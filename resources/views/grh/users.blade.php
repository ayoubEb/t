@extends('layouts.master')
@section('title')
    Liste des utilisateurs
@endsection
@section('content')
@include('sweetalert::alert')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-1">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Acceuil</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Liste des utilisateurs
        </li>
    </ol>
</nav>
<div class="card">
    <div class="card-body p-2">

            @can("user-nouveau")
                <button type="button" class="btn btn-primary btn-icon-text mb-2 text-uppercase px-5 text-uppercase" data-bs-toggle="modal" data-bs-target="#add">
                    <span class="mdi mdi-plus-circle-outline align-middle"></span>
                     <span>
                        Ajouter
                     </span>
                </button>
            @endcan

            <div class="table-responsive">
                <table class="table table-striped mb-0 datatable table-sm" >
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Role</th>
                            <th>username</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="align-middle"><img src="{{ asset('images/users/'.$user->image) }}" class="avatar-sm rounded-pill"></td>
                                <td class="align-middle">{{ $user->name ?? '' }}</td>
                                <td class="align-middle">{{ $user->email ?? '' }}</td>
                                <td class="align-middle">{{ $user->statut ?? '' }}</td>
                                <td class="align-middle">
                                    {{ $user->role ?? '' }}
                                </td>
                                <td class="align-middle">
                                    {{ $user->username ?? '' }}
                                </td>
                                <td class="align-middle">
                                    @can('user-modification')
                                        <button type="button" class="btn bg-transparent border-0 text-primary p-0" data-bs-toggle="modal" data-bs-target="#edit{{ $user->id }}">
                                            <i class="ti-pencil" style="font-size: 0.80rem"></i>
                                        </button>
                                    @endcan

                                    @if ($user->role != "manager")
                                        @can('user-suppression')
                                            <button type="button" class="btn bg-transparent border-0 text-primary p-0" data-bs-toggle="modal" data-bs-target="#delete{{ $user->id }}">
                                                <i class="ti-trash" style="font-size: 0.80rem"></i>
                                            </button>
                                        @endcan



                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<div class="modal fade" id="add"  aria-labelledby="varyingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2 bg-primary">
                <h6 class="modal-title m-0 text-white" id="varyingModalLabel">Ajouter d'utilisateur</h6>
                <button type="button" class="btn btn-transparent p-0 border-0 text-white" data-bs-dismiss="modal" aria-label="btn-close">
                    <span class="mdi mdi-close-thick"></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="row row-cols-lg-2 row-cols-1">
                        <div class="col mb-2">
                            <div class="form-group">
                                <label for="" class="form-label">Name <span class="text-danger">*</span> </label>
                                <input type="text" name="name" id="" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                @error("name")
                                    <strong class="invalid-feedback">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-group">
                                <label for="" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="" class="form-control @error("email") is-invalid @enderror" value="{{ old('email') }}" >
                                @error("email")
                                    <strong class="invalid-feedback">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-group">
                                <label for="" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" id="" class="form-control @error("username") is-invalid @enderror" value="{{ old('username') }}" >
                                @error("username")
                                    <strong class="invalid-feedback">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-group">
                                <label for="" class="form-label">Fonction</label>
                                <input type="text" name="fonction" id="" class="form-control " value="{{ old('fonction') }}" >
                                @error("username")
                                    <strong class="invalid-feedback">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-group">
                                <label for="" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="toggle-password mdi mdi-eye-off-outline"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">

                                    @error("password")
                                        <strong class="invalid-feedback">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-group">
                                <label for="" class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon2">
                                        <i class="toggle-password mdi mdi-eye-off-outline"></i>
                                    </span>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="form-label d-block">Roles <span class="text-danger">*</span></label>
                        {!! Form::select('roles[]', $roles,[], array('class' => 'form-select','multiple')) !!}
                    </div>
                    <div class="form-group d-flex justify-content-center">
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

@foreach ($users as $user)
    <div class="modal fade" id="edit{{ $user->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h5 class="modal-title m-0" id="varyingModalLabel">Modifier d'utilisateur : {{ $user->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route("user.update",$user) }}" method="POST" >
                        @csrf
                        @method("PUT")

                        <div class="row row-cols-lg-2 row-cols-1">
                            <div class="col mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label">Name</label>
                                    <input type="text" name="name_u" id="" class="form-control @error("name_u") is-invalid @enderror" value="{{ $user->name ?? "" }}">
                                    @error("name_u")
                                        <strong class="invalid-feedback">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" name="email_u" id="" class="form-control form-control-sm @error("email_u") is-invalid @enderror" value="{{ $user->email ?? "" }}">
                                    @error("email_u")
                                        <strong class="invalid-feedback">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label">Username</label>
                                    <input type="text" name="username_u" id="" class="form-control form-control-sm @error("username_u") is-invalid @enderror" value="{{ $user->username ?? '' }}">
                                    @error("username_u")
                                        <strong class="invalid-feedback">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>


                            <div class="col mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label">Fonction</label>
                                    <input type="text" name="fonction_u" id="" class="form-control " value="{{ $user->role ?? '' }}" >
                                    @error("fonction")
                                        <strong class="invalid-feedback">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>



                            <div class="col mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="toggle-password mdi mdi-eye-off-outline"></i>
                                        </span>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
                                    </div>

                                    @error("password")
                                        <strong class="invalid-feedback">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="toggle-password mdi mdi-eye-off-outline"></i>
                                        </span>
                                        <input type="password" name="password_confirmation" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="form-label d-block">Roles <span class="text-danger">*</span></label>
                            {!! Form::select('roles_u[]', $roles,$user->roles->pluck('name','name')->all(), array('class' => 'form-select','multiple')) !!}

                        </div>



                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-success px-2 py-1">
                                <i class="mdi mdi-checkbox-marked-circle-outline align-middle"></i>
                                <span>Modifier</span>
                            </button>
                        </div>

                      </form>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="delete{{ $user->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h6 class="modal-title m-0" id="exampleModalCenterTitle">Confirmer la suppression</h6>
                    <button type="button" class="btn bg-transparent p-0 border-0" data-bs-dismiss="modal" aria-label="Close">
                        <span class="mdi mdi-close-thick"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.destroy',$user) }}" method="POST">
                        @csrf
                        @method("DELETE")
                        <h6 class="mb-2 text-center text-muted">
                            Voulez-vous vraiment déplacer d'utilisateur vers la corbeille
                        </h6>
                        <h6 class="mb-2 text-center text-danger text-uppercase fw-bolder fs-12">
                            {{ $user->name }}
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


@endforeach
@endsection

@section('script')
    <script>
        $(".toggle-password").click(function() {
    $(this).toggleClass("mdi mdi-eye-outline mdi mdi-eye-off-outline");
    input = $(this).parent().parent().find("input");
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
    });
    </script>
@endsection