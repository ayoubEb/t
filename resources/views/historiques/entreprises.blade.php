@extends('layouts.master')
@section('content')
    <div class="card">
      <div class="card-body p-2">
        <div class="table-repsonsive">
            <table class="table table-customize m-0">
              <thead>
                <tr>
                  <th>action</th>
                  <th>entreprise</th>
                  <th>utilisateur</th>
                  <th>date</th>
                  <th>temps</th>
                  <th>valeurs</th>
                </tr>
              </thead>
              <tbody>
              @foreach ($entreprises as $entreprise)
                  <tr>
                    <td class="align-middle">
                      @if ($entreprise->event == "created")
                        <span class="bg-success px-2 py-1 rounded text-white fw-bold">
                            Nouveau
                        </span>
                      @elseif ($entreprise->event == "deleted")
                        <span class="bg-danger px-2 py-1 rounded text-white fw-bold">
                            Suppression
                        </span>
                      @elseif ($entreprise->event == "updated")
                        <span class="bg-primary px-2 py-1 rounded text-white fw-bold">
                            Modification
                        </span>
                      @endif
                    </td>
                    <td class="align-middle">
                     {{ $entreprise->nom }}
                    </td>
                    <td class="align-middle">
                     {{ $entreprise->user }}
                    </td>
                    <td class="align-middle">
                     {{ date("d/m/Y",strtotime($entreprise->created_at)) }}
                    </td>
                    <td class="align-middle">
                     {{ date("H:i:s",strtotime($entreprise->created_at)) }}
                    </td>
                    <td class="align-middle">
                      <button type="button" class="btn btn-primary waves-effect waves-light p-0 px-1" data-bs-toggle="modal" data-bs-target="#display{{ $entreprise->id }}">
                        <span class="mdi mdi-eye-outline"></span>
                      </button>
                      <div class="modal fade" tabindex="-1" id="display{{ $entreprise->id }}" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body p-2">
                                    @php
                                          $array_insert = [];
                                          $array_sup = [];
                                          if($entreprise->event == "created" ){
                                              foreach($entreprise->properties['attributes'] ?? [] as $attribute => $value){
                                                if(!is_null($value)){
                                                  $array_insert[] = [
                                                    "champ"=>$attribute,
                                                    "value"=>$value,
                                                  ];
                                                }
                                            }
                                          }
                                          elseif ($entreprise->event == "deleted") {
                                            foreach($entreprise->properties['old'] ?? [] as $attribute => $value){
                                              if(!is_null($value)){
                                                $array_sup[] = [
                                                  "champ"=>$attribute,
                                                  "value"=>$value,
                                                ];
                                              }
                                          }

                                          }
                                    @endphp
                                    @php
                                      $properties = json_decode($entreprise->properties, true);
                                      $changedAttributes = [];


                                      if (isset($properties['old']) && isset($properties['attributes'])) {
                                          foreach ($properties['attributes'] as $key => $newValue) {
                                              if (isset($properties['old'][$key]) && $properties['old'][$key] != $newValue) {
                                                  $changedAttributes[$key] = [
                                                      'old' => $properties['old'][$key],
                                                      'new' => $newValue
                                                  ];
                                              }
                                          }
                                      }

                                      // dd($properties);
                                    @endphp
                                    @if (count($changedAttributes) > 0)
                                      @foreach($changedAttributes as $key => $values)
                                        @if(count($changedAttributes) > 0)
                                          <ul class="list-group">
                                            <li class="list-group-item active text-center py-2">
                                              <b>{{ ucfirst($key) }}</b>
                                            </li>
                                            <li class="list-group-item text-center py-2">
                                              <div class="row row-cols-2">
                                                <div class="col">
                                                  <h6>
                                                    avant
                                                  </h6>
                                                </div>
                                                <div class="col">
                                                  <h6>
                                                    nouveau
                                                  </h6>
                                                </div>
                                              </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-evenly align-items-center py-2">
                                              @if(is_array($values['old']))
                                                  @foreach($values['old'] as $oldValue)
                                                      {{ $oldValue }}
                                                    @endforeach
                                              @else
                                                {{ $values['old'] }}
                                              @endif
                                              <span class="mdi mdi-arrow-right-thick"></span>
                                              @if(is_array($values['new']))
                                              @foreach($values['new'] as $newValue)
                                                  {{ $newValue }}
                                              @endforeach
                                                @else
                                                  {{ $values['new'] }}
                                                @endif
                                            </li>
                                          </ul>

                                        @else
                                          <small>No changes recorded</small>
                                        @endif

                                      @endforeach
                                    @elseif($entreprise->event == "created")
                                    <h6 class="text-center title">
                                      {{ $entreprise->event }}
                                    </h6>
                                      <ul class="list-group">
                                        @foreach ($array_insert as $attribute)

                                          <li class="list-group-item">
                                            <strong>{{ $attribute['champ'] }} : </strong>
                                            {{ $attribute['value'] }}

                                          </li>



                                        @endforeach

                                      </ul>
                                    @elseif($entreprise->event == "deleted")
                                      <h6 class="text-center title">
                                        {{ $entreprise->event }}
                                      </h6>
                                      <ul class="list-group">
                                        @foreach ($array_sup as $attribute)
                                          <li class="list-group-item">
                                            <strong>{{ $attribute['champ'] }} : </strong>
                                            {{ $attribute['value'] }}
                                          </li>
                                        @endforeach
                                      </ul>

                                    @endif
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    </td>
                  </tr>
              @endforeach
              </tbody>
            </table>
        </div>
      </div>
    </div>
@endsection