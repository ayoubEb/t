
<header>
  <div class="logo">
    <img src="{{ public_path('storage/images/entreprises/' . $entreprise->logo) }}" alt="">
    <p> {{ $entreprise->adresse }} </p>
    <p>
      <span style="font-weight: bold;">Tél : </span>
      {{ $entreprise->telephone }}
    </p>
    <p>
      <span style="font-weight: bold;">Email : </span>
      {{ $entreprise->email }}
    </p>
    <p>
      <span style="font-weight: bold;">ICE : </span>
      {{ $entreprise->ice }}
    </p>
  </div>
</header>