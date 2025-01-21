@extends('layouts.app')


@section('content')
<div class="container-fuild" id="password">
    <div class="row justify-content-center w-100">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-white bg-primary">{{ __('Mot de passe oublié') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">


                        <div class="form-group mb-3">
                          <label for="" class="form-label fw-normal">Email</label>
                            <input id="email" type="email" class="form-control shadow-none @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label fw-normal">{{ __('Password') }}</label>
                                <input  type="password" class="form-control shadow-none @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>

                        <div class="form-group mb-3">
                            <label for="password-confirm" class="form-label fw-normal">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control shadow-none" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="row mb-0 justify-content-center">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    {{ __('Continuer') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
