@extends('layouts.master')
@section('title')
    nouveau paiementd'achat : {{ $ligneAchat->Num_achat }}
@endsection
@section('content')
  @include('sweetalert::alert')
  @include('ligneAchats.minInfo',[ "id"=>$ligneAchat->id ])
  <h5 class="title">
    nouveau paiement
  </h5>
  <div class="card">
    <div class="card-body p-2">
      @if ($ligneAchat->reste == 0)
        d
      @else
      <form action="{{ route('achatPaiement.store') }}" method="post">
        @csrf
        <input type="hidden" name="ligne_achat_id" value="{{ $ligneAchat->id }}">
        <input type="hidden" id="reste" value="{{ $ligneAchat->reste ?? '' }}">

        <div class="row row-cols-2">
          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-label">Type du paiement</label>
              <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                <option value="">Choisir le type du paiement</option>
                <option value="espèce" {{ old('type') == 'espèce' || old('type') == null ? 'selected' : '' }} >Espèce</option>
                <option value="chèque" {{ old('type') == 'chèque' ? 'selected' : '' }}>Chèque</option>
              </select>
              @error('type')
                <strong class="invalid-feedback">
                  {{ $message }}
                </strong>
              @enderror
            </div>
          </div>
          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-label">Montant TTC</label>
              <input type="number" name="" id="ttc" class="form-control" value="{{ $ligneAchat->reste ?? '' }}" disabled>
            </div>
          </div>
          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-label">Montant payer</label>
              <input type="number" name="payer" id="payer" class="form-control" step="any" min="0" value="{{ old('payer') }}"
                max="{{ $ligneAchat->reste }}"
                disabled required
              >
              <span id="error" class="text-danger"></span>
            </div>
          </div>
          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-label">Montant reste nouveau</label>
              <input type="number" id="resteNew" step="any" class="form-control reste" value="" readonly>
            </div>
          </div>
        </div>

        <div id="cheque" class="bg-light p-2 my-2">
          <div class="row row-cols-2">
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Numéro <span class="text-danger"> * </span></label>
                <input type="text" name="numero" id="" class="form-control @error('numero') is-invalid @enderror" value="{{ old('numero') }}">
                @error('numero')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Nom bank <span class="text-danger">*</span></label>
                <select name="nom_bank" id="" class="form-select @error('nom_bank') is-invalid @enderror">
                  <option value="">Choisir le nom du bank</option>
                  @foreach ($banks as $bank)
                  <option value="{{ $bank->id ?? '' }}" {{ $bank->id == old('nom_bank') ? "selected": "" }}>{{ $bank->nom_bank ?? '' }}</option>
                  @endforeach
                </select>
                @error('nom_bank')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>

            <div class="col mb-md-0 mb-2">
              <div class="form-group">
                <label for="" class="form-label">Date chèque <span class="text-danger">*</span></label>
                <input type="date" name="date_cheque" id="" class="form-control @error('date_cheque') is-invalid @enderror" value="{{ old('date_cheque') }}">
                @error('date_cheque')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>

            <div class="col mb-md-0 mb-2">
              <div class="form-group">
                <label for="" class="form-label">Date enquisement <span class="text-danger">*</span></label>
                <input type="date" name="date_enquisement" id="" class="form-control @error('date_enquisement') is-invalid @enderror" value="{{ old('date_enquisement') }}">
                @error('date_enquisement')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>

            <div class="col mb-md-0 mb-2">
              <div class="form-group">
                <label for="" class="form-label">status <span class="text-danger">*</span></label>
                <select name="statusCheque" id="" class="form-select @error('statusCheque') is-invalid @enderror">
                  <option value="">le Status</option>
                  <option value="payé" {{ old('statusCheque') == 'payé' ? 'selected' : '' }}>Payé</option>
                  <option value="en cours" {{ old('statusCheque') == 'en cours' ? 'selected' : '' }}>En cours</option>
                </select>
                @error('statusCheque')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>

          </div>
        </div>


        <div class="d-flex justify-content-center mt-2">
          <a href="{{ route('ligneAchat.show',$ligneAchat) }}" class="btn btn-retour waves-effect waves-light me-5">
            retour
          </a>
          <button type="submit" class="btn btn-action waves-effect waves-light">
            <span>Enregistrer</span>
          </button>
        </div>
      </form>
      @endif
    </div>
  </div>
@endsection


@section('script')
    <script>
        $(document).ready(function() {
          var type = $("#type").val();
          if(type == 'chèque')
          {
            $("#cheque").show(450);
            $("#payer").prop("disabled",false);
          }
          else
          {
            $("#cheque").hide(450);
            $("#payer").prop("disabled",false);
          }

          var payer = $("#payer").val();
              var reste = $("#reste").val();
              var resteNew = parseFloat(reste - payer).toFixed(2);
              $("#resteNew").val(resteNew);


          $("#type").on("change", function() {
              let type = $(this).val();

              if (type == "chèque") {
                  $("#cheque").show(450);

              } else {
                  $("#cheque").hide(450);
              }


              if (type == "") {
                  $("#payer").prop("disabled", true);
              } else {
                  $("#payer").prop("disabled", false);

              }
          })
            $("#payer").on("keyup", function() {

              var payer = $(this).val();
              var reste = $("#reste").val();
              var resteNew = parseFloat(reste - payer).toFixed(2);
              $("#resteNew").val(resteNew);
              var resteN = $("#resteNew").val();
              if(resteN < 0)
              {
                $("#resteNew").val(0);
                $("#error").html("le montant à dépassé de ligne d'achat");
              }
              else
              {
                $("#error").html("");

              }

            })
        })
    </script>
@endsection
