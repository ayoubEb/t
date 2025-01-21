@extends('layouts.app')

@section('content')
<div class="container-fuild" id="authen">
  <div class="row justify-content-center w-100">
    <div class="col-lg-4">
      <div class="card">

        <div class="card-body">
          <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="input-group mb-3">
              <span class="input-group-text" id="inputGroup-sizing">
                <i class="mdi mdi-account mdi-18px"></i>
              </span>
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" aria-label="Sizing example input" aria-describedby="inputGroup-sizing" placeholder="Nom">
              @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing">
              <i class="mdi mdi-email mdi-18px"></i>
            </span>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" aria-label="Sizing example input" aria-describedby="inputGroup-sizing" placeholder="Email">
            @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="input-group input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing">
              <i class="mdi mdi-lock mdi-18px"></i>
            </span>
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" aria-label="Sizing example input" aria-describedby="inputGroup-sizing" placeholder="Mot de passe">
            @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="input-group input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing">
              <i class="mdi mdi-lock mdi-18px"></i>
            </span>
            <input type="password" class="form-control" name="password_confirmation" value="{{ old('password') }}" aria-label="Sizing example input" aria-describedby="inputGroup-sizing" placeholder="Confirmer le mot de passe">
          </div>
          <input type="hidden" name="statut" value="activer">
          <div class="form-group text-center mb-2">
            <button type="submit" class="btn btn-info shadow-none btn-sm w-100">Inscription</button>
          </div>
          <div class="form-group d-flex align-items-center mb-2">
              <hr class="w-100">
              <span class="px-2">OU</span>
              <hr class="w-100">
          </div>
          <div class="form-group d-flex justify-content-center">
            <p class="m-0">Vous avez déja un compte&nbsp;:&nbsp;</p>
            <a href="{{ route('login') }}" class="text-decoration-none">Se connecter</a>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}