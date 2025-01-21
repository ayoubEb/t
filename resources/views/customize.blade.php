@extends('layouts.master')
@section('content')

@include('sweetalert::alert')

<div class="card">
    <div class="card-body p-2">
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item waves-effect waves-light" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home-1" role="tab" aria-selected="false" tabindex="-1">Home</a>
                    </li>
                    <li class="nav-item waves-effect waves-light" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#facture" role="tab" aria-selected="false" tabindex="-1">Facture</a>
                    </li>
                    <li class="nav-item waves-effect waves-light" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#messages-1" role="tab" aria-selected="true">stock</a>
                    </li>
                    <li class="nav-item waves-effect waves-light" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#settings-1" role="tab" aria-selected="false" tabindex="-1">ligne d'achat</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane p-3 active show" id="home-1" role="tabpanel">
                        <p class="font-14 mb-0">
                            Raw denim you probably haven't heard of them jean shorts Austin.
                            Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache
                            cliche tempor, williamsburg carles vegan helvetica. Reprehenderit
                            butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui
                            irure terry richardson ex squid. Aliquip placeat salvia cillum iphone.
                            Seitan aliquip quis cardigan american apparel, butcher voluptate nisi
                            qui.
                        </p>
                    </div>
                    <div class="tab-pane p-3" id="facture" role="tabpanel">
                        <form action="{{ route('customize-facture.update',$facture) }}" method="post">
                            @csrf
                            @method("PUT")
                            <div class="row row-cols-3">
                                <div class="col mb-2">
                                    <div class="form-group">
                                        <label for="" class="form-label">Référence</label>
                                        <input type="text" name="reference_facture" id="" class="form-control" value="{{ $facture->reference ?? '' }}">
                                    </div>
                                </div>
                                <div class="col mb-2">
                                    <div class="form-group">
                                        <label for="" class="form-label">Numéro</label>
                                        <input type="number" name="numero_facture" id="" class="form-control" value="{{ $facture->numero ?? '' }}">
                                    </div>
                                </div>
                                <div class="col mb-2">
                                    <div class="form-group">
                                        <label for="" class="form-label">tva</label>
                                        <input type="number" name="tva" id="" class="form-control" min=0 max="100" step="any" value="{{ $facture->tva ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-success btn-sm px-3">
                                    <span class="mdi mdi-checkbox-marked-circle-outline align-middle"></span>
                                    <span>Modifier</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane p-3" id="messages-1" role="tabpanel">
                        <form action="{{ route('customize-stock.update',$stock) }}" method="post">
                            @csrf
                            @method("PUT")
                            <div class="row row-cols-2">
                                <div class="col mb-2">
                                    <div class="form-group">
                                        <label for="" class="form-label">Référence</label>
                                        <input type="text" name="reference_stock" id="" class="form-control" value="{{ $stock->reference ?? '' }}">
                                    </div>
                                </div>
                                <div class="col mb-2">
                                    <div class="form-group">
                                        <label for="" class="form-label">Numéro</label>
                                        <input type="number" name="numero_stock" id="" class="form-control" value="{{ $stock->numero ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-success btn-sm px-3">
                                    <span class="mdi mdi-checkbox-marked-circle-outline align-middle"></span>
                                    <span>Modifier</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane p-3" id="settings-1" role="tabpanel">
                        <p class="font-14 mb-0">
                            Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party
                            before they sold out master cleanse gluten-free squid scenester freegan
                            cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf
                            cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR,
                            banh mi before they sold out farm-to-table VHS viral locavore cosby
                            sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft
                            beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park
                            vegan.
                        </p>
                    </div>
                </div>
    </div>
</div>
    <div class="row row-cols-3">
        <div class="col">
            <div class="card">
                <div class="card-header bg-success py-2px">
                    <h6 class="m-0 title text-uppercase">
                        facture
                    </h6>
                </div>
                <div class="card-body p-2">

                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-header bg-success py-2px">
                    <h6 class="m-0 title text-uppercase">
                        stock
                    </h6>
                </div>
                <div class="card-body p-2">

                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header bg-success py-2px">
                    <h6 class="m-0 title text-uppercase">
                        ligne d'achat
                    </h6>
                </div>
                <div class="card-body p-2">
                    <form action="{{ route('customizeAchat.update',$achat) }}" method="post">
                        @csrf
                        @method("PUT")
                        <div class="form-group mb-2">
                            <label for="" class="form-label">Référence</label>
                            <input type="text" name="reference_achat" id="" class="form-control" value="{{ $achat->reference ?? '' }}">
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="form-label">Numéro</label>
                            <input type="number" name="numero_achat" id="" class="form-control" value="{{ $achat->numero ?? '' }}">
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="form-label">TVA</label>
                            <input type="number" name="tva_achat" id="" min="1" class="form-control" value="{{ $achat->tva ?? '' }}">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-success btn-sm px-3">
                                <span class="mdi mdi-checkbox-marked-circle-outline align-middle"></span>
                                <span>Modifier</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection