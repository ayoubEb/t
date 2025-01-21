@extends('layouts.master')
@section('title')
Liste des caractéristiques
@endsection
@section('content')
@include('sweetalert::alert')

  <h4 class="title">
      <a href="{{ route('caracteristique.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light me-2">
        <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
      </a>
      Modification caractéristique : {{ $caracteristique->nom }}
  </h4>
  <div class="card">
    <div class="card-body p-2">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <form action="{{ route('caracteristique.update',$caracteristique) }}" method="post">
            @csrf
            @method("PUT")
            <div class="form-group mb-2">
              <label for="">Nom</label>
              <input type="text" name="nom" id="" class="form-control @error('nom') is-invalid @enderror" value="{{ $caracteristique->nom }}">
              @error('nom')
                <strong class="invalid-feedback">
                  {{ $message }}
                </strong>
              @enderror
            </div>
            <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-action waves-effect waves-light">
                <span>mettre à jour</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>




{{-- <div class="modal fade" id="add" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary py-2">
                <h6 class="modal-title m-0 text-white" id="varyingModalLabel">Ajouter des caractéristiques</h6>
                <button type="button" class="btn btn-transparent p-0 text-white border-0" data-bs-dismiss="modal" aria-label="btn-close">
                    <span class="mdi mdi-close-thick"></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('caracteristique.store') }}" method="post">
                    @csrf
                    <div class="row row-cols-2" id="autre">
                        <div class="col">
                            <div class="card poisition-relative">
                                <div class="card-body p-2">
                                    <div class="form-group mb-2">
                                        <label for="">Nom</label>
                                        <input type="text" name="nom[]" id="" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-dark" id="nouveau">Ajouter autre caractéristique</button>

                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="mdi mdi-checkbox-marked-circle-outline align-middle"></i>
                            <span>Enregistrer</span>
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}
@endsection

@section('script')
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
@endsection