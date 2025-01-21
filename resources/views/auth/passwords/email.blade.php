@extends('layouts.app')

@section('content')
<div class="container-fuild" id="password">
  <div class="row justify-content-center w-100">

    <div class="col-lg-4">

      <div class="card">

       <div class="card-body">
          @if (session('status'))
              <div class="alert alert-success" role="alert">
                  {{ session('status') }}
              </div>
          @endif
          <form method="POST" action="{{ route('password.email') }}">
              @csrf
                <h3 class="mb-2 text-center fw-bolder ">
                    Trouver votre compte
                </h3>
                <p class="mb-3 text-center">
                    Veuillez entrer votre adresse e-mail pour rechercher votre compte.
                </p>

                <input type="email" class="form-control form-control-sm shadow-none @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Entrer l'email">
                @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
                <div class="d-flex justify-content-between mt-2">
                    <a href="" class="btn btn-primary py-1 px-3">
                        Retour
                    </a>
                    <button type="submit" class="btn btn-success py-1 px-3">
                        Suivant
                    </button>
                </div>

          </form>
        </div>

      </div>
    </div>
  </div>
</div>



@endsection
