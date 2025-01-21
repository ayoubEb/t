@php
    $ligneRapport = \App\Models\LigneRapport::where("id",$id)->first();
@endphp

  <div class="headerLinks mb-3">
    <div class="row justify-content-center">
      <div class="col-lg-4">
        <h6 class="text-center">
          mois : {{ $ligneRapport->mois }}
        </h6>
      </div>
    </div>
    <ul>
      <li class="pe-3">
        <a href="{{ route('ligneRapport.show',$ligneRapport->id) }}" @if($check == "resume") class="active" @endif>résume</a>
      </li>
      <li class="pe-3">
        <a href="{{ route('ligneRapport.ventes',$ligneRapport->id) }}" @if($check == "ventes") class="active" @endif>ventes</a>
      </li>
      <li class="pe-3">
        <a href="{{ route('ligneRapport.clients',$ligneRapport) }}" @if($check == "clients") class="active" @endif>clients</a>
      </li>
      {{-- <li>
        <a href="{{ route('ligneRapport.fournisseurs',$ligneRapport->id) }}" @if($check == "fournisseurs") class="active" @endif>fournisseurs</a>
      </li> --}}
    </ul>
  </div>
