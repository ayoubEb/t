@extends('layouts.master')
@section('content')
@include('sweetalert::alert')
@include('ligneFactures.minInfo',['id'=>$facture->id])
@php
  $sum_payer = \App\Models\FacturePaiement::where("facture_id",$facture->id)->where("type_paiement","chèque")->where("statut","payé")->sum("payer");
  $sum_impaye = \App\Models\FacturePaiement::where("facture_id",$facture->id)->where("type_paiement","chèque")->where("statut","impayé")->sum("payer");
  $sum_cours = \App\Models\FacturePaiement::where("facture_id",$facture->id)->where("type_paiement","chèque")->where("statut","en cours")->sum("payer");
  $sum_annuler = \App\Models\FacturePaiement::where("facture_id",$facture->id)->where("type_paiement","chèque")->where("statut","annuler")->sum("payer");
@endphp

<h6 class="title mb-1">
  modification paiement
</h6>
<div class="card">
  <div class="card-body p-2">
    <form action="{{route('facturePaiement.update',$facturePaiement)}}" method="post">
      @csrf
      @method("PUT")
      <div class="row row-cols-2">
        @if ($facturePaiement->type_paiement == "chèque")
          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-group">Numéro</label>
              <input type="text" name="numero" id="" class="form-control @error('numero') is-invalid @enderror" value="{{ $facturePaiement->cheque && $facturePaiement->cheque->numero != '' ? $facturePaiement->cheque->numero : '' }}">
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
                  <option value="{{ $banque->id }}" {{ $facturePaiement->cheque->bank_id == $banque->id ? "selected":"" }}> {{ $banque->nom_bank }} </option>
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
              <input type="date" name="date_cheque" id="" class="form-control @error('date_cheque') is-invalid @enderror" value="{{ $facturePaiement->cheque && $facturePaiement->cheque->date_cheque != '' ? $facturePaiement->cheque->date_cheque : '' }}">
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
              <input type="date" name="date_enquisement" id="" class="form-control @error('date_enquisement') is-invalid @enderror" value="{{ $facturePaiement->cheque && $facturePaiement->cheque->date_enquisement != '' ? $facturePaiement->cheque->date_enquisement : '' }}">
              @error('date_cheque')
                <strong class="invalid-feedback">
                  {{ $message }}
                </strong>
              @enderror
            </div>
          </div>

          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-group">statut</label>
              <select name="statut" id="" class="form-select @error('date_enquisement') is-invalid @enderror">
                <option value="payé" {{ $facturePaiement->statut == "payé" ? "selected" : ""  }}>payé</option>
                <option value="impayé" {{ $facturePaiement->statut == "impayé" ? "selected" : ""  }}>impayé</option>
              </select>
              @error('statut')
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
            <input type="number" name="payer" id="" class="form-control payer  @error('payer') is-invalid @enderror" step="any" min="0" value="{{ $facturePaiement->payer }}" max="{{ $facture->reste +  $facturePaiement->payer }}">
            @error('payer')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Montant reste nouveau</label>
            <input type="number" id="" step="any" class="form-control reste" value="" disabled>
          </div>
        </div>

      </div>
      <div class="d-flex justify-content-between">
        <a href="{{ route('facturePaiement.index') }}" class="btn btn-retour waves-effect waves-light">
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
                $(".reste").val(reste_av - payer);

            })
        })
    </script>
@endsection

