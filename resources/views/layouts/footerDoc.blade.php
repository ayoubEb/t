@php
    $entreprise = \App\Models\Entreprise::find($id);
@endphp
@if (isset($entreprise))
<footer>
    <hr>
    <p>
      <span class="fw-bold text-uppercase">
        {{ $entreprise->raison_sociale }}
      </span>
      <br>
      <span class="fw-bold">Siège&nbsp;:&nbsp;</span>{{ $entreprise->adresse }}, {{ $entreprise->ville }}
      <br>
      <span class="fw-bold">IF&nbsp;:&nbsp;</span>{{ $entreprise->if }}
      <span class="fw-bold">ICE&nbsp;:&nbsp;</span>{{ $entreprise->ice }}
      <span class="fw-bold">RC&nbsp;:&nbsp;</span>{{ $entreprise->rc }}
      <span class="fw-bold">PATENTE&nbsp;:&nbsp;</span>{{$entreprise->patente }}
      <span class="fw-bold">CNSS&nbsp;:&nbsp;</span>{{ $entreprise->cnss }}
    </p>
  </footer>

@endif