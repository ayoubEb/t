@extends('layouts.master')
@section('content')
@if ($count == 0)
  <form action="{{ route('venteReferences.default') }}" method="post">
    @csrf
    <button type="submit" class="btn btn-action waves-effect waves-light">
      générer
    </button>
  </form>
@else

<h6 class="title mb-2">
  références
</h6>
<form action="{{ route('customizeVente.updateReferences') }}" method="post">
  @csrf
  @method("PUT")
  <div class="card">
    <div class="card-body p-2 pb-0">
      <div class="row row-cols-2">
        <div class="col">
                <div class="table-respnsive">
                  <table class="table table-borderless table-customize m-0">
                    <thead>
                      <tr>
                        <th>option</th>
                        <th>valeur</th>
                        {{-- <th>statut</th> --}}
                      </tr>
                    </thead>
                    <tbody>
                      <tr>

                      </tr>
                      @foreach ($liste_devis as $devis)
                        <input type="hidden" name="ids[]" value="{{ $devis->id }}">
                        <tr>
                          <td class="align-middle">
                            {{ $devis->champ }}
                          </td>

                          <td class="align-middle">
                            <input type="text" name="valeur[]" id="" class="form-control" value="{{ $devis->valeur }}">
                          </td>
                          {{-- <td class="align-middle">
                            <select name="check[]" id="" class="form-select">
                              <option value="">-- choisir état --</option>
                              <option value="1" {{ $devis->check_exists == 1 ? 'selected' : '' }}>Activié</option>
                              <option value="0" {{ $devis->check_exists == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                          </td> --}}
                        </tr>
                      @endforeach
                      <tr>
                        <td class="align-middle table-danger text-center" colspan="3">
                          <span class="mt"> préforma ( statut = en cours ) </span>
                        </td>
                      </tr>
                      @foreach ($preformas as $preforma)
                        <input type="hidden" name="ids[]" value="{{ $preforma->id }}">
                        <tr>
                          <td class="align-middle">
                            {{ $preforma->champ }}
                          </td>

                          <td class="align-middle">
                            <input type="text" name="valeur[]" id="" class="form-control" value="{{ $preforma->valeur }}">
                          </td>
                          {{-- <td class="align-middle">
                            <select name="check[]" id="" class="form-select">
                              <option value="">-- choisir état --</option>
                              <option value="1" {{ $preforma->check_exists == 1 ? 'selected' : '' }}>Activié</option>
                              <option value="0" {{ $preforma->check_exists == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                          </td> --}}
                        </tr>
                      @endforeach

                      <tr>
                        <td class="align-middle table-danger text-center" colspan="3">
                          <span class="mt">facture ( statut = validé ) </span>
                        </td>
                      </tr>
                      @foreach ($commandes as $commande)
                        <input type="hidden" name="ids[]" value="{{ $commande->id }}">
                        <tr>
                          <td class="align-middle">
                            {{ $commande->champ }}
                          </td>

                          <td class="align-middle">
                            <input type="text" name="valeur[]" id="" class="form-control" value="{{ $commande->valeur }}">
                          </td>
                          {{-- <td class="align-middle">
                            <select name="check[]" id="" class="form-select">
                              <option value="">-- choisir état --</option>
                              <option value="1" {{ $commande->check_exists == 1 ? 'selected' : '' }}>Activié</option>
                              <option value="0" {{ $commande->check_exists == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                          </td> --}}
                        </tr>
                      @endforeach


                    </tbody>
                  </table>
                </div>



        </div>
        <div class="col">

                <div class="table-respnsive">
                  <table class="table table-borderless table-customize m-0">
                    <thead>
                      <tr>
                        <th>option</th>
                        <th>valeur</th>
                        {{-- <th>statut</th>J --}}
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="align-middle table-danger text-center" colspan="3">
                          <span class="mt">livraison ( statut = validé ) </span>
                        </td>
                      </tr>
                      @foreach ($avoires as $avoire)
                        <input type="hidden" name="ids[]" value="{{ $avoire->id }}">
                        <tr>
                          <td class="align-middle">
                            {{ $avoire->champ }}
                          </td>

                          <td class="align-middle">
                            <input type="text" name="valeur[]" id="" class="form-control" value="{{ $avoire->valeur }}">
                          </td>
                          {{-- <td class="align-middle">
                            <select name="check[]" id="" class="form-select">
                              <option value="">-- choisir état --</option>
                              <option value="1" {{ $avoire->check_exists == 1 ? 'selected' : '' }}>Activié</option>
                              <option value="0" {{ $avoire->check_exists == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                          </td> --}}
                        </tr>
                      @endforeach

                      <tr>
                        <td class="align-middle table-danger text-center" colspan="3">
                          <span class="mt">livraison ( statut = validé et état livraison == activé ) </span>
                        </td>
                      </tr>
                      @foreach ($livraisons as $livraison)
                        <input type="hidden" name="ids[]" value="{{ $livraison->id }}">
                        <tr>
                          <td class="align-middle">
                            {{ $livraison->champ }}
                          </td>

                          <td class="align-middle">
                            <input type="text" name="valeur[]" id="" class="form-control" value="{{ $livraison->valeur }}">
                          </td>
                          {{-- <td class="align-middle">
                            <select name="check[]" id="" class="form-select">
                              <option value="">-- choisir état --</option>
                              <option value="1" {{ $livraison->check_exists == 1 ? 'selected' : '' }}>Activié</option>
                              <option value="0" {{ $livraison->check_exists == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                          </td> --}}
                        </tr>
                      @endforeach

                    </tbody>
                  </table>
                </div>



        </div>

      </div>

      <button type="submit" class="btn btn-primary w-100 waves-effect waves-light">
        <span class="mdi mdi-pencil-outline"> </span>
      </button>
    </div>
  </div>
</form>


@endif

@endsection