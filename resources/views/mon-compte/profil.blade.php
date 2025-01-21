@extends('layouts.master')
@section('title')
    Profil : {{ $user->name }}
@endsection
@section('content')
    <div class="card">
        <div class="card-body p-2">

                    <table class="table table-striped table-sm m-0">
                        <tbody>
                            <tr>
                                <th class="align-middle">Name</th>
                                <td class="align-middle">
                                    {{ $user->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="align-middle">Username</th>
                                <td class="align-middle">
                                    {{ $user->username ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="align-middle">E-mail</th>
                                <td class="align-middle">
                                    {{ $user->email ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="align-middle">Fonction</th>
                                <td class="align-middle">
                                    {{ $user->role ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="align-middle">Statut</th>
                                <td class="align-middle">
                                    {{ $user->statut }}
                                </td>
                            </tr>
                            @foreach ($user->roles as $roles)
                                <tr>
                                    <th colspan="2" class="bg-primary text-center text-white">{{ $roles->name ?? '' }}</th>
                                </tr>
                                <tr>
                                    <td class="align-middle" colspan="2">
                                        <div class="row row-cols-4">
                                    @foreach ($roles->permissions as $permission)
                                                <div class="col mb-2">
                                                    <input type="text" name="" id="" class="form-control-plaintext" value="{{ $permission->name }}" disabled>
                                                </div>

                                                @endforeach
                                            </div>
                                        </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


        </div>
    </div>
@endsection