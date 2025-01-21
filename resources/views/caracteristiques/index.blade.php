@extends('layouts.master')
@section('title')
Liste des caractéristiques
@endsection
@section('content')
@include('sweetalert::alert')
<div class="d-flex justify-content-between align-items-center mb-2">
  <h4 class="title m-0">
    liste des caractéristiques
  </h4>
  @can('caracteristique-nouveau')
    <a href="{{ route('caracteristique.create') }}" class="btn btn-header px-4 rounded waves-effect waves-light">
      <span class="mdi mdi-plus-thick"></span>
    </a>
  @endcan
</div>
<div class="card">
  <div class="card-body p-2">
    <div class="table-responsive">
      <table class="table table-bordered table-sm m-0 datatable" >
        <thead class="table-primary">
          <tr>
            <th>nom</th>
            @canany(['caracteristique-modification', 'caracteristique-suppression','caracteristique-display'])
              <th>actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @forelse ($caracteristiques as $k =>  $caracteristique)
            <tr>
              <td class="align-middle"> {{ $caracteristique->nom ?? '' }} </td>
              @canany(['caracteristique-modification', 'caracteristique-suppression','caracteristique-display'])
                  <td class="align-middle">
                    @can('caracteristique-display')
                      <a href="{{ route('caracteristique.show',$caracteristique->id) }}" class="btn btn-warning p-icon waves-effect waves-light shadow-none" data-bs-toggle="tooltip" data-bs-placement="bottom" title="display">
                        <span class="mdi mdi-eye-outline"></span>
                      </a>
                    @endcan
                    @can('caracteristique-modification')
                      <a href="{{ route('caracteristique.edit',$caracteristique->id) }}" class="btn btn-primary p-icon waves-effect waves-light shadow-none" data-bs-toggle="tooltip" data-bs-placement="bottom" title="modifier">
                        <span class="mdi mdi-pencil-outline"></span>
                      </a>
                    @endcan
                    @can('caracteristique-suppression')
                      <button type="button" class="btn btn-danger p-icon waves-effect waves-light shadow-none" data-bs-toggle="modal" data-bs-target="#delete{{ $k }}"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="supprimer">
                        <span class="mdi mdi-trash-can-outline"></span>
                      </button>
                      <div class="modal fade" id="delete{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body">
                              <form action="{{ route('caracteristique.destroy',$caracteristique->id) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <div class="d-flex justify-content-center">
                                  <span class="mdi mdi-trash-can-outline mdi-48px text-danger"></span>
                                </div>
                                <h4 class="text-danger mb-3 text-center">Confirmer la suppression</h4>
                                <h6 class="mb-2 fw-bolder text-center">
                                  Êtes-vous sûr de vouloir supprimer la caractéristique ?
                                </h6>
                                <h6 class="text-primary mb-2 text-center">{{ $caracteristique->nom ?? '' }}</h6>
                                <div class="row justify-content-center">
                                  <div class="col-6">
                                    <button type="submit" class="btn btn-action waves-efect waves-light w-100">
                                      <span class="mdi mdi-check-bold align-middle"></span>
                                      <span>
                                        Je confirme
                                      </span>
                                    </button>

                                  </div>
                                  <div class="col-6">
                                    <button type="button" class="btn btn-bleu waves-effect wave-light w-100" data-bs-dismiss="modal" aria-label="btn-close">
                                      <span class="mdi mdi-close align-middle"></span>
                                      Annuler
                                    </button>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endcan
                  </td>
                @endcanany
              </tr>
            @empty
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>





@endsection

{{-- @section('script')
<script>

$(document).ready(function(){
  $('#nouveau').on('click',function(){
    var html="";
    html+='<div class="col">';
        html+='<div class="card poisition-relative">';
            html+='<button type="button" class="position-absolute top-0 btn btn-outline-danger btn-sm" id="remove"style="left:92%"><span class="mdi mdi-close-thick fw-bolder"></span></button>';
            html+='<div class="card-body p-2">';
                html += '<div class="form-group mb-2">';
                    html+='<label for="">Nom</label>';
                    html+='<input type="text" name="nom[]" id="" class="form-control" required>';
                html += '</div>';
            html += '</div>';
        html += '</div>';
    html += '</div>';
    $('#autre').append(html);
  });

});

$(document).on('click','#remove',function() {
    $(this).closest('.col').remove();
})

</script>
@endsection --}}