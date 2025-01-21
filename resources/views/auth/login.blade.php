@extends('layouts.app')

@section('content')

  <div class="row justify-content-center w-100">
    <div class="col-xl-4 col-lg-7 col-md-8 col-sm-11">
      <div class="card w-100">
        <div class="card-body p-4">
          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="row justify-content-center mb-3">
              <div class="col-lg-6">
                <h4 class="text-uppercase text-center">stock</h4>
              </div>
            </div>
            <div class="form-group mb-2">
              <label for="" class="form-label">Username ou email</label>
              <div class="input-group">
                <span class="input-group-text">
                    <i class="mdi mdi-account"></i>
                </span>
                <input id="email" type="text" class="form-control shadow-none @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>
            <div class="form-group mb-2">
              <label for="" class="form-label">Mot de passe</label>
              <div class="input-group">
                <span class="input-group-text" id="basic-addon1">
                    <i class="toggle-password mdi mdi-eye-off-outline"></i>
                </span>
                <input type="password" name="password" class="form-control shadow-none  @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" autofocus>

                @error("password")
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="d-flex justify-content-center mt-4">
              <button type="submit" class="btn btn-light btn-sm">
                  {{ __('Se connecter') }}
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
