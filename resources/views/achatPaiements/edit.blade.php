@extends('layouts.master')
@section('content')
@include('sweetalert::alert')
@include('sweetalert::alert')
@include('ligneAchats.minInfo',[ "id"=>$ligneAchat->id ])
<h6 class="title mb-1">
  modification paiement
</h6>
<div class="card">
  <div class="card-body p-2">

    <form action="{{route('achatPaiement.update',$achatPaiement)}}" method="post">
      @csrf
      @method("PUT")
      <div class="row row-cols-2">
        @if ($achatPaiement->type_paiement == "chèque")
          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-group">Numéro</label>
              <input type="text" name="numero" id="" class="form-control @error('numero') is-invalid @enderror" value="{{ $achatPaiement->cheque && $achatPaiement->cheque->numero != '' ? $achatPaiement->cheque->numero : '' }}">
              @error('numero')
                <strong class="invalid-feedback">
                  {{ $message }}
                </strong>
              @enderror
            </div>
          </div>

          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-group">Banque</label>
              <select name="banque" id="" class="form-select @error('banque') is-invalid @enderror">
                <option value=""></option>
                @foreach ($banques as $banque)
                  <option value="{{ $banque }}" {{ $achatPaiement->cheque && $achatPaiement->cheque->banque == $banque ? "selected":"" }}> {{ $banque }} </option>
                @endforeach
              </select>
              @error('banque')
                <strong class="invalid-feedback">
                  {{ $message }}
                </strong>
              @enderror
            </div>
          </div>

          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-group">Date</label>
              <input type="date" name="date_cheque" id="" class="form-control @error('date_cheque') is-invalid @enderror" value="{{ $achatPaiement->cheque && $achatPaiement->cheque->date_cheque != '' ? $achatPaiement->cheque->date_cheque : '' }}">
              @error('date_cheque')
                <strong class="invalid-feedback">
                  {{ $message }}
                </strong>
              @enderror
            </div>
          </div>
          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-group">Date enquisement</label>
              <input type="date" name="date_enquisement" id="" class="form-control @error('date_enquisement') is-invalid @enderror" value="{{ $achatPaiement->cheque && $achatPaiement->cheque->date_enquisement != '' ? $achatPaiement->cheque->date_enquisement : '' }}">
              @error('date_cheque')
                <strong class="invalid-feedback">
                  {{ $message }}
                </strong>
              @enderror
            </div>
          </div>

          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-group">status</label>
              <select name="status" id="" class="form-select @error('date_enquisement') is-invalid @enderror">
                <option value="payé" {{ $achatPaiement->status == "payé" ? "selected" : ""  }}>payé</option>
                <option value="en cours" {{ $achatPaiement->status == "en cours" ? "selected" : ""  }}>en cours</option>
                <option value="impayé" {{ $achatPaiement->status == "impayé" ? "selected" : ""  }}>impayé</option>
              </select>
              @error('status')
                <strong class="invalid-feedback">
                  {{ $message }}
                </strong>
              @enderror
            </div>
          </div>
        @endif

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Montant payer</label>
            <input type="number" name="payer" id="" class="form-control payer  @error('payer') is-invalid @enderror" step="any" min="0" value="{{ $achatPaiement->payer }}" max="{{ $ligneAchat->reste +  $achatPaiement->payer }}">
            @error('payer')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
            <span id="error" class="text-danger"></span>
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Montant reste nouveau</label>
            <input type="number" id="reste" step="any" class="form-control" value="" readonly>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-between">
        <a href="{{ route('achatPaiement.index') }}" class="btn btn-retour waves-effect waves-light">
          <span>Retour</span>
        </a>
        <button type="submit" class="btn btn-action waves-effect waves-light">
          <span>mettre à jour</span>
        </button>
      </div>
    </form>
  </div>
</div>
@endsection


@section('script')
    <script>
         $(document).ready(function(){
            $(".payer").on("keyup",function(){
                var payer = $(this).val();
                var reste_av = $("#reste_av").val();
                var resteNew = parseFloat(reste_av - payer).toFixed(2);
                $("#reste").val(resteNew);
                var resteN = $("#reste").val();
                if(resteN < 0)
                {
                  $("#reste").val(0);
                  $("#error").html("le montant à supérieur de ligne d'achat");
                }
                else
                {
                  $("#error").html("");

                }

            })
        })
    </script>
@endsection

