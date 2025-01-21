@extends('layouts.master')
@section('content')
  <div class="card">
    <div class="card-body p-2">
      <div class="table-repsonsive">
        <table class="table table-customize m-0">
          <thead>
            <tr>
              <th>action</th>
              <th>utilisateur </th>
              <th>utilisateur affecter</th>
              <th>date</th>
              <th>temps</th>
              <th>valeurs</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr>
                <td class="align-middle">
                  @if ($user->event == "created")
                    <span class="bg-success px-2 py-1 rounded text-white fw-bold">
                      Nouveau
                    </span>
                  @elseif ($user->event == "deleted")
                    <span class="bg-danger px-2 py-1 rounded text-white fw-bold">
                      Suppression
                    </span>
                  @elseif ($user->event == "updated")
                    <span class="bg-primary px-2 py-1 rounded text-white fw-bold">
                      Modification
                    </span>
                  @endif
                </td>
                <td class="align-middle">
                  {{ $user->name }}
                </td>
                <td class="align-middle">
                  {{ $user->news }}
                </td>
                <td class="align-middle">
                  {{ date("d/m/Y",strtotime($user->created_at)) }}
                </td>
                <td class="align-middle">
                  {{ date("H:i:s",strtotime($user->created_at)) }}
                </td>
                <td class="align-middle">
                  <button type="button" class="btn btn-primary waves-effect waves-light p-0 px-1" data-bs-toggle="modal" data-bs-target="#display{{ $user->id }}">
                    <span class="mdi mdi-eye-outline"></span>
                  </button>
                  <div class="modal fade" tabindex="-1" id="display{{ $user->id }}" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                          </button>
                        </div>
                        <div class="modal-body p-2">
                          @php
                            $array_insert      = [];
                            $array_sup         = [];
                            $properties        = json_decode($user->properties, true);
                            $changedAttributes = [];
                            if($user->event == "created" ){
                              foreach($user->properties['attributes'] ?? [] as $attribute => $value){
                                if(!is_null($value)){
                                  $array_insert[] = [
                                    "champ"=>$attribute,
                                    "value"=>$value,
                                  ];
                                }
                              }
                            }
                            elseif ($user->event == "deleted") {
                              foreach($user->properties['old'] ?? [] as $attribute => $value){
                                if(!is_null($value)){
                                  $array_sup[] = [
                                    "champ"=>$attribute,
                                    "value"=>$value,
                                  ];
                                }
                              }

                            }
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
                          @endphp
                          @if (count($changedAttributes) > 0)
                            <ul class="list-group">
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
                              @foreach($changedAttributes as $key => $values)
                                @if(count($changedAttributes) > 0)
                                  <li class="list-group-item active text-center py-2">
                                    <b>{{ ucfirst($key) }}</b>
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
                                @else
                                  <small>No changes recorded</small>
                                @endif
                              @endforeach
                            </ul>
                          @elseif($user->event == "created")
                            <h6 class="text-center title">
                              {{ $user->event }}
                            </h6>
                            <ul class="list-group">
                              @foreach ($array_insert as $attribute)
                                <li class="list-group-item">
                                  <strong>{{ $attribute['champ'] }} : </strong>
                                  {{ $attribute['value'] }}
                                </li>
                              @endforeach
                            </ul>
                          @elseif($user->event == "deleted")
                            <h6 class="text-center title">
                              {{ $user->event }}
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