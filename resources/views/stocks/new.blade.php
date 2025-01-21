@extends('layouts.master')
@section('title')
  new stock
@endsection
@section('content')
@include('sweetalert::alert')
<h4 class="title mb-3">
  <a href="{{ route('stock.index') }}" class="btn btn-retour px-4 py-1 waves-effect waves-light">
    <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
  </a>
  nouveau stock
</h4>
<div class="row justify-content-center">
  <div class="col-xxl-9">
    <div class="card">
      <div class="card-body p-2">
        <form action="{{ route('stock.store') }}" method="post">
          @csrf
          <div class="row row-cols-2">
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">référence <span class="text-danger">*</span></label>
                <input type="text" name="reference" id="" class="form-control @error('reference') is-invalid @enderror" readonly value="{{ $produit->reference }}">
                @error('reference')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>


            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Initial</label>
                <input type="number" name="initial" id="" class="form-control @error('initial') is-invalid @enderror" min="1" value="{{ old('initial') }}">
                @error('initial')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Min <span class="text-danger">*</span></label>
                <input type="number" name="qte_min" id="" class="form-control @error('qte_min') is-invalid @enderror" min="1" value="{{ old('qte_min') }}">
                @error('qte_min')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>


            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Max</label>
                <input type="number" name="qte_max" id="" class="form-control" min="0" value="{{ old('qte_max') }}">
              </div>
            </div>



          </div>

          <div class="d-flex justify-content-center mt-2">
            <button type="submit" class="btn btn-action waves-effect waves-light">
              enregistrer
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
  <script>
    $(document).ready(function () {
      setTimeout(function() {
          $('#list-depots').fadeIn();
          $(".loading").remove();
      }, 50);

;


      $(".dep").on("change",function(e){
        var dep = $(e.target).parent().parent().parent();
        var dep_event = $(e.target);
        var num_dep =  dep_event.parent().parent().children(".dep-num").val();
        var dep_default = $("#depDefault");
        if(dep_event.is(":checked")){
          dep.addClass("table-success");
          dep.children("td").children("input").prop("disabled",false);
          dep.children("td").children("input").prop("required",true);
          dep.children("td:nth-child(3)").children("input").val(0);
          $("#depDefault").append('<option value="' + num_dep + '">' + num_dep + ' </option>')
        }
        else
        {
          dep.removeClass("table-success");
          dep.children("td").children("input").prop("disabled",true);
          dep.children("td").children("input").prop("required",false);
          dep.children("td:nth-child(3)").children("input").val('');
          dep.children("td").children("input").prop("disabled",true);
          $('#depDefault option[value="' + num_dep + '"]').remove();
        }




      })
    });
  </script>
@endsection