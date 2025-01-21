@extends('layouts.master')
@section('content')
    <div class="card">
      <div class="card-body p-2">
        <div class="table-repsonsive">
            <table class="table table-customize m-0">
              <thead>
                <tr>
                  <th>action</th>
                  <th>utilisateur</th>
                  <th>date</th>
                  <th>temps</th>
                  <th>valeurs</th>
                </tr>
              </thead>
              <tbody>
              @foreach ($categories as $categorie)
                  <tr>
                    <td class="align-middle">
                      @if ($categorie->description == "created")
                        <span class="bg-success px-2 py-1 rounded text-white fw-bold">
                            Nouveau
                        </span>
                      @elseif ($categorie->description == "deleted")
                        <span class="bg-danger px-2 py-1 rounded text-white fw-bold">
                            Suppression
                        </span>
                      @elseif ($categorie->description == "updated")
                        <span class="bg-primary px-2 py-1 rounded text-white fw-bold">
                            Modification
                        </span>
                      @endif
                    </td>
                    <td class="align-middle">
                     {{ $categorie->user }}
                    </td>
                    <td class="align-middle">
                     {{ date("d/m/Y",strtotime($categorie->created_at)) }}
                    </td>
                    <td class="align-middle">
                     {{ date("H:i:s",strtotime($categorie->created_at)) }}
                    </td>
                    <td class="align-middle">
                      @if (isset($categorie->properties))
                        {{-- <strong>{{ $categorie->properties->get('attributes')['nom'] ?? '' }}</strong> : nom <br> --}}
                      @else
                          No changes
                      @endif
                    </td>
                  </tr>
              @endforeach
              </tbody>
            </table>
        </div>
      </div>
    </div>
@endsection