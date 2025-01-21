@extends('layouts.master')
@section('content')
@if ($count == 0)
  <form action="{{ route('achatReferences.default') }}" method="post">
    @csrf
    <button type="submit" class="btn btn-action waves-effect waves-light">
      générer
    </button>
  </form>
@else

<h6 class="title mb-2">
  références
</h6>
<div class="row justify-content-center">
  <div class="col-lg-9">
    <div class="card">
      <div class="card-body p-2 pb-0">
        <form action="{{ route('customizeAchat.updateReferences') }}" method="post">
          @csrf
          @method("PUT")
          <div class="table-respnsive">
            <table class="table table-borderless table-customize m-0">
              <thead>
                <tr>
                  <th>option</th>
                  <th>valeur</th>
                  <th>statut</th>
                </tr>
              </thead>
              <tbody>
                <tr>

                </tr>
                @foreach ($reference_achats as $reference_achat)
                  <input type="hidden" name="ids[]" value="{{ $reference_achat->id }}">
                  <tr>
                    <td class="align-middle">
                      {{ $reference_achat->champ }}
                    </td>

                    <td class="align-middle">
                      <input type="text" name="valeur[]" id="" class="form-control" value="{{ $reference_achat->valeur }}">
                    </td>
                    {{-- <td class="align-middle">
                      <select name="check[]" id="" class="form-select">
                        <option value="">-- choisir état --</option>
                        <option value="1" {{ $reference_achat->check_exists == 1 ? 'selected' : '' }}>Activié</option>
                        <option value="0" {{ $reference_achat->check_exists == 0 ? 'selected' : '' }}>Inactive</option>
                      </select>
                    </td> --}}
                  </tr>
                @endforeach
                <tr>
                  <td class="align-middle table-danger text-center" colspan="3">
                    <span class="mt"> demande ( statut = en cours ) </span>
                  </td>
                </tr>
                @foreach ($demande_achats as $demande_achat)
                  <input type="hidden" name="ids[]" value="{{ $demande_achat->id }}">
                  <tr>
                    <td class="align-middle">
                      {{ $demande_achat->champ }}
                    </td>

                    <td class="align-middle">
                      <input type="text" name="valeur[]" id="" class="form-control" value="{{ $demande_achat->valeur }}">
                    </td>
                    {{-- <td class="align-middle">
                      <select name="check[]" id="" class="form-select">
                        <option value="">-- choisir état --</option>
                        <option value="1" {{ $demande_achat->check_exists == 1 ? 'selected' : '' }}>Activié</option>
                        <option value="0" {{ $demande_achat->check_exists == 0 ? 'selected' : '' }}>Inactive</option>
                      </select>
                    </td> --}}
                  </tr>
                @endforeach
                <tr>
                  <td class="align-middle table-danger text-center" colspan="3">
                    <span class="mt">bon de commande ( statut = validé ) </span>
                  </td>
                </tr>
                @foreach ($bon_commandes as $bon_commande)
                  <input type="hidden" name="ids[]" value="{{ $bon_commande->id }}">
                  <tr>
                    <td class="align-middle">
                      {{ $bon_commande->champ }}
                    </td>

                    <td class="align-middle">
                      <input type="text" name="valeur[]" id="" class="form-control" value="{{ $bon_commande->valeur }}">
                    </td>
                    {{-- <td class="align-middle">
                      <select name="check[]" id="" class="form-select">
                        <option value="">-- choisir état --</option>
                        <option value="1" {{ $bon_commande->check_exists == 1 ? 'selected' : '' }}>Activié</option>
                        <option value="0" {{ $bon_commande->check_exists == 0 ? 'selected' : '' }}>Inactive</option>
                      </select>
                    </td> --}}
                  </tr>
                @endforeach

              </tbody>
            </table>
          </div>

              <button type="submit" class="btn btn-primary w-100 waves-effect waves-light">
                <span class="mdi mdi-pencil-outline"> </span>
              </button>
          </form>

      </div>
    </div>
  </div>
</div>


@endif

@endsection