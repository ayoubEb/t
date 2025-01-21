@extends('layouts.master')
@section('title')
    Modifier le client : {{ $client->raison_sociale ?? '' }}
    @endsection
    @section('content')
    @include('sweetalert::alert')
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h4 class="title">
        <a href="{{ route('client.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light">
          <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
        </a>
        Modifier le client : {{ $client->raison_sociale ?? '' }}
      </h4>
      @can('client-display')
      <a href="{{ route('client.show',$client->id) }}" class="btn btn-header px-4 waves-effect waves-light">
        <span class="mdi mdi-eye-outline"></span>
      </a>
      @endcan
    </div>
    <form action="{{ route('client.update',$client) }}" method="post">
      @csrf
      @method("PUT")
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-lg-7 col-md-8">
              <h6 class="text-uppercase mb-3 text-primary">
                <span class="border border-end-0 border-start-0 border-top-0 border-solid border-primary border-2 pb-1">information général</span>
              </h6>
              <div class="row row-cols-md-2 row-cols-1">
                <div class="col mb-2">
                  <div class="form-group">
                    <label for="" class="form-label">Raison sociale <span class="text-danger"> * </span></label>
                    <input type="text" name="raison_sociale" class="form-control @error('raison_sociale') is-invalid @enderror" value="{{ $client->raison_sociale }}">
                    @error('raison_sociale')
                      <strong class="invalid-feedback">{{ $message }}</strong>
                    @enderror
                  </div>
                </div>


                <div class="col mb-2">
                  <div class="form-group">
                    <label for="" class="form-label">Téléphone  <span class="text-danger"> * </span></label>
                    <input type="text" name="telephone" id="" class="form-control @error('telephone') is-invalid @enderror" value="{{ $client->telephone }}">
                    @error('telephone')
                        <strong class="invalid-feedback">{{ $message }}</strong>
                    @enderror
                  </div>
                </div>


                <div class="col mb-2">
                  <div class="form-group">
                    <label for="" class="form-label">ICE</label>
                    <input type="text"  name="ice" class="form-control @error('ice') is-invalid @enderror" value="{{ $client->ice }}">
                    @error('ice')
                        <strong class="invalid-feedback">{{ $message }}</strong>
                    @enderror
                  </div>
                </div>

                <div class="col mb-2">
                  <div class="form-group">
                    <label for="" class="form-label">IF</label>
                    <input type="text" name="if_client" class="form-control @error('if_client') is-invalid @enderror"  value="{{ $client->if_client }}">
                    @error('if_client')
                        <strong class="invalid-feedback">{{ $message }}</strong>
                    @enderror
                  </div>
                </div>

                <div class="col mb-2">
                  <div class="form-group">
                    <label for="" class="form-label">RC</label>
                    <input type="text" name="rc" class="form-control @error('rc') is-invalid @enderror" value="{{ $client->rc }}">
                    @error('rc')
                        <strong class="invalid-feedback">{{ $message }}</strong>
                    @enderror
                  </div>
                </div>

                <div class="col mb-2">
                  <div class="form-group">
                    <label for="" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $client->email }}">
                    @error('email')
                        <strong class="invalid-feedback">{{ $message }}</strong>
                    @enderror
                  </div>
                </div>


                <div class="col mb-2">
                  <div class="form-group">
                    <label for="" class="form-label">Adresse <span class="text-danger"> * </span></label>
                    <input type="text" name="adresse" class="form-control @error('adresse') is-invalid @enderror" value="{{ $client->adresse }}">
                    @error('adresse')
                        <strong class="invalid-feedback">{{ $message }}</strong>
                    @enderror
                  </div>
                </div>

                <div class="col mb-2">
                  <div class="form-group">
                    <label for="" class="form-label">Ville <span class="text-danger"> * </span></label>
                    <input type="text" name="ville" class="form-control @error('ville') is-invalid @enderror" value="{{ $client->ville }}">
                    @error('ville')
                        <strong class="invalid-feedback">{{ $message }}</strong>
                    @enderror
                  </div>
                </div>

                <div class="col mb-2">
                  <div class="form-group">
                    <label for="" class="form-label">Code postal</label>
                    <input type="text" name="code_postal" class="form-control @error('code_postal') is-invalid @enderror" value="{{ $client->code_postal }}">
                    @error('text')
                    <strong class="invalid-feedback">{{ $message }}</strong>
                    @enderror
                  </div>
                </div>

              </div>
            </div>
           
            </div>

            <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-action waves-effect waves-light">
                Mettre à jour
              </button>
            </div>
          </div>
        </div>
    </form>
@endsection