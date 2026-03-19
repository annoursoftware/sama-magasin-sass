@extends('back.master')

@section('title', 'Ventes')

@push('styles')
    
    <style>
        input:not([type="file"]).error, textarea.error, select.error {
            border: 1px solid red !important;
        }

        input:not([type="file"]).no-error, textarea.no-error, select.no-error {
            border: 1px solid green !important;
        }

        div.error-field {
            color: red;
            font-size: small;
        }

        .highlight { 
            background-color: yellow; 
            transition: background-color 1s ease; 
        } 

        .highlight-delete { 
            background-color: #f8d7da; /* rouge clair */ 
            transition: background-color 0.5s ease; 
        }

        .highlight-total { 
            background-color: #d1ecf1; /* bleu clair */ 
            padding: 5px; 
            border-radius: 4px; t
            ransition: background-color 0.8s ease; 
        }

        .pulse-total { 
            animation: pulse 0.6s ease; 
        }

        @keyframes pulse { 
            0% { transform: scale(1); color: #000; } 
            50% { transform: scale(1.3); color: #28a745;  } 
            100% { transform: scale(1); color: #000;  } 
        }
        
        .btn-bounce { animation: bounce 0.8s; }

        @keyframes bounce { 
            0% { transform: scale(1); } 
            30% { transform: scale(1.2); } 
            50% { transform: scale(0.9); } 
            70% { transform: scale(1.1); } 
            100% { transform: scale(1); } 
        }

    </style>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" />
    
    <link rel="stylesheet" href="{{ asset('back/plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Vente</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dev.dashboard') }}">Tableau de bord</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dev.transactions.ventes') }}">Ventes</a></li>
                            <li class="breadcrumb-item active">Vente</li>
                        </ol>
                    </div>
                </div>
                {{-- <div class="row mb-2">
                    <div class="col-md-12 col-sm-12 col-12 d-flex">
                        <button type="button" class="btn btn-flat btn-danger ml-auto" onclick="retour()">
                            <i class="bi bi-house"></i> Retour à la page vente
                        </button>
                    </div>
                </div> --}}
                <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container">
                <form id="vente" class="form-horizontal" method="POST" action="{{ url('api/ventes') }}" validate="true">
                    @csrf
                    @method('POST')

                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <div class="card card-maroon">
                                <div class="card-header">
                                    <h3 class="card-title">Etapes de Vente</h3>
                                </div>
                                
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" id="type_vente" name="type_vente" value="f">
                                    
                                <div class="row">
                                    <div class="col-12">
                                        <blockquote class="quote-danger print-error-msg" style="display:none">
                                            <ul></ul>
                                        </blockquote>
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    <div class="bs-stepper linear">
                                        {{-- Header --}}
                                        <div class="bs-stepper-header" role="tablist">
    
                                            <div class="step active" data-target="#client-part">
                                                <button type="button" class="step-trigger" role="tab" aria-controls="client-part"
                                                    id="client-part-trigger" aria-selected="false" disabled="disabled">
                                                    <span class="bs-stepper-circle">1</span>
                                                    <span class="bs-stepper-label">Client</span>
                                                </button>
                                            </div>
    
                                            <div class="line"></div>
    
                                            <div class="step" data-target="#detail-part">
                                                <button type="button" class="step-trigger" role="tab" aria-controls="detail-part"
                                                    id="detail-part-trigger" aria-selected="false" disabled="disabled">
                                                    <span class="bs-stepper-circle">2</span>
                                                    <span class="bs-stepper-label">Details Vente</span>
                                                </button>
                                            </div>
    
                                            <div class="line"></div>
    
                                            <div class="step" data-target="#encaissement-part">
                                                <button type="button" class="step-trigger" role="tab"
                                                    aria-controls="encaissement-part" id="encaissement-part-trigger"
                                                    aria-selected="false" disabled="disabled">
                                                    <span class="bs-stepper-circle">3</span>
                                                    <span class="bs-stepper-label">Encaissement</span>
                                                </button>
                                            </div>
                                        </div>
                                        {{-- Header --}}
    
                                        {{-- Body --}}
                                        <div class="bs-stepper-content">
    
                                            <div id="client-part" class="content active dstepper-block" role="tabpanel"
                                                aria-labelledby="client-part-trigger">
                                                <div class="row mt-2">
                                                    <div class="col-sm-8 col-12 p-3">
                                                        <div class="card card-maroon">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Client</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <div class="form-group">
                                                                            <label for="client">Client</label>
                                                                            <select id="client" name="client_id" class="custom-select rounded-0 select"
                                                                                required style="width: 100%;">
                                                                                <option value="">****** Choix ******</option>
                                                                                @foreach ($clients as $cli)
                                                                                    <option value="{{ $cli->id }}">{{ $cli->client }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="type">Type</label>
                                                                            <input type="text" class="form-control rounded-0"
                                                                                id="type_client" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="tel">Telephone</label>
                                                                            <input type="text" class="form-control rounded-0"
                                                                                id="telephone" readonly>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-sm-8">
                                                                        <div class="form-group">
                                                                            <label for="email">Email</label>
                                                                            <input type="text" class="form-control rounded-0"
                                                                                id="email" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="adresse">Adresse</label>
                                                                            <input type="text" class="form-control rounded-0"
                                                                                id="adresse" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <div class="col-sm-4 col-12 p-3">
                                                        <div class="card card-maroon">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Nouveau Client</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="row">
                                                                            <div class="col-md-12 col-sm-12 col-12 d-flex">
                                                                                <button type="button" class="btn btn-flat btn-primary ml-auto" onclick="addForm()">
                                                                                    <i class="bi bi-plus-lg"></i> Ajouter un client
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3 d-flex align-items-center">
                                                    <div class="col-sm-12 ">
                                                        <button type="button" class="btn btn-outline-primary"
                                                            onclick="stepper.next()">Suivante <i class="bi bi-chevron-bar-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div id="detail-part" class="content" role="tabpanel"
                                                aria-labelledby="detail-part-trigger">
                                                <div class="row mt-1">
                                                    <div class="col-sm-4">
                                                        <div class="card card-maroon">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Articles</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-10 col-sm-10 col-10">
                                                                        <div class="form-group">
                                                                            <label for="pidproduit">Articles</label>
                                                                            <select name="pidproduit" id="article"
                                                                                class="custom-select rounded-0 select"
                                                                                style="width: 100%;">
                                                                                <option value="">**** Choix ****</option>
                                                                                @foreach ($articles as $p)
                                                                                    <option value="{{ $p->id }}">{{ $p->article }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-1 col-sm-2 col-2">
                                                                        <div class="form-group">
                                                                            <label for="img-article"></label>
                                                                            <img id="img-article" class="img">
                                                                        </div>
                                                                        <!-- /.info-box -->
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6 col-6">
                                                                        <div class="form-group">
                                                                            <label for="pmontant">Montant</label>
                                                                            <input type="text" class="form-control rounded-0" id="pmontant" readonly />
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-sm-6 col-6">
                                                                        <div class="form-group">
                                                                            <label for="pstock">Stock</label>
                                                                            <input type="text" class="form-control rounded-0" id="pstock" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6 col-6">
                                                                        <div class="form-group">
                                                                            <label for="pchmontant">Négociation</label>
                                                                            <input type="text" class="form-control rounded-0" id="pchmontant" />
                                                                        </div>
                                                                    </div>
    
                                                                    <div class="col-sm-6 col-6">
                                                                        <div class="form-group">
                                                                            <label for="pquantite">Quantite</label>
                                                                            <input type="number" class="form-control rounded-0"
                                                                                id="pquantite" />
                                                                        </div>
                                                                    </div>
    
                                                                    <div class="col-sm-1 col-6">
                                                                        <div class="form-group">
                                                                            <button type="button" id="btn_add"
                                                                                class="btn btn-danger btn-md">+</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <div class="col-sm-8">
                                                        <div class="card card-maroon">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Details Ventes</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-striped table-bordered table-condensed table-hover mt-1" id="details">
                                                                                <thead style="background-color:rgb(243, 64, 118)">
                                                                                    <tr class="text-white text-sm">
                                                                                        <th class="text-center" width="3%">Options
                                                                                        </th>
                                                                                        <th width="50%">Articles</th>
                                                                                        <th class="text-center" width="15%">Montant
                                                                                        </th>
                                                                                        <th class="text-center">Quantité</th>
                                                                                        <th class="text-center">Total</th>
                                                                                    </tr>
                                                                                </thead>
    
                                                                                <tbody class="text-xs">
                                                                                </tbody>
                                                                                
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="row mt-3">
                                                    <div class="col-sm-12 m-3">
                                                        <button type="button" class="btn btn-primary" onclick="stepper.previous()">
                                                           <i class="bi bi-chevron-bar-left"></i> Precedente
                                                        </button>
                                                        <button type="button" class="btn btn-outline-primary"
                                                            onclick="stepper.next()">Suivante <i class="bi bi-chevron-bar-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div id="encaissement-part" class="content" role="tabpanel"
                                                aria-labelledby="encaissement-part-trigger">
                                                <div class="row mt-1">
                                                    <div class="col-sm-3 mt-0">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="card card-maroon">
                                                                    <div class="card-header">
                                                                        <h3 class="card-title">Vente</h3>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-12 col-6">
                                                                                <div class="form-group">
                                                                                    <label for="sous_total">Sous total</label>
                                                                                    <h6 id="total">S/. 0.00</h6>
                                                                                    <input type="hidden" class="form-control" name="montants" id="sous_total">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12 col-6">
                                                                                <div class="form-group">
                                                                                    <label for="sous_total">Remise (%)</label>
                                                                                    <input type="number" class="form-control rounded-0" name="remise" id="remise" placeholder="La Remise">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12">
                                                                                <div class="form-group">
                                                                                    <label for="total">Total</label>
                                                                                    <h6 id="total_def">S/. 0.00</h6>
                                                                                    <input type="hidden" class="form-control" name="montants_apres_remise" id="total_def_val">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-9">
                                                        <div class="card card-maroon">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Encaissement</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-4 col-12">
                                                                        <div class="form-group">
                                                                            <label for="systeme_encaissement">Systeme Paie</label>
                                                                            <select name="systeme_encaissement" id="systeme_encaissement" class="custom-select rounded-0">
                                                                                <option value="">*** Choix ***</option>
                                                                                <option value="mobile_money">Mobile money</option>
                                                                                <option value="banque">Banque</option>
                                                                                <option value="espece">Espece</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
    
                                                                    <div class="col-sm-4 col-12">
                                                                        <div class="form-group">
                                                                            <label for="mode_encaissement">Mode</label>
                                                                            <select name="mode_encaissement" id="mode_encaissement"
                                                                                class="custom-select rounded-0">
                                                                                <option value="">**** Choix ****</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
    
                                                                    <div class="col-sm-4" id="section_bank">
                                                                        <div class="form-group">
                                                                            <label for="moyen_bancaire">Moyen Bancaire</label>
                                                                            <select name="moyen_bancaire" id="moyen_bancaire"
                                                                                class="custom-select rounded-0">
                                                                                <option value="">CHOIX</option>
                                                                                <option>Cheque</option>
                                                                                <option>Virement</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
    
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="ref_encaissement">Reference</label>
                                                                            <input type="text" class="form-control rounded-0"
                                                                                name="ref_encaissement" id="ref_encaissement">
                                                                        </div>
                                                                    </div>
    
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="encaissement">Encaissement</label>
                                                                            <input type="text" class="form-control rounded-0"
                                                                                name="encaissement" id="encaissement" />
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="restant">Restant</label>
                                                                            <input type="text" class="form-control rounded-0"
                                                                                id="restant" readonly />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="row mt-3">
                                                    <div class="col-sm-12 m-3">
                                                        <button type="button" class="btn btn-primary" onclick="stepper.previous()">
                                                            <i class="bi bi-chevron-bar-left"></i> Precedente
                                                        </button>
                                                        <button type="button" class="btn btn-danger disabled">Fin <i class="bi bi-ban"></i> </button>
                                                    </div>
                                                </div>
    
                                            </div>
                                        </div>
                                        {{-- Body --}}
                                    </div>
                                </div>
    
                                {{-- <div class="card-footer justify-content-end">
                                    <button type="submit" class="btn btn-primary fas fa-save" id="savebtn"> Enregistrer</button>
                                </div> --}}

                                <div class="card-footer justify-content-end"> 
                                    <button type="submit" id="savebtn" class="btn btn-primary"> 
                                        <span class="default-icon"> 
                                            <i class="fas fa-save"></i> Enregistrer 
                                        </span> 
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> 
                                        <span class="btn-text d-none">En cours...</span> 
                                    </button> 
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </form>

                
                @include('back.clients.form')
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        {{-- <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
            <i class="fas fa-chevron-up"></i>
        </a> --}}
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('back/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
    <script src="{{ asset('back/plugins/select2/js/select2.min.js') }}"></script>

    <script>
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function () {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        $(document).ready(function() {
            $('.select').select2({
                theme: 'bootstrap4',
                allowClear: false
            });
        });
        
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        })

        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });


        $("#section_bank").hide();
        $('#systeme_encaissement').on('change', function(e){
            console.log(e);

            var systeme_encaissement = $('#systeme_encaissement').val();
            $.get('/api/json-moyens-paie?systeme_encaissement=' + systeme_encaissement,function(data) {
                console.log(data);
                if (systeme_encaissement=='espece') {
                    
                    alert('espece activé')
                    $('#mode_encaissement').empty();
                    $('#mode_encaissement').append('<option value="ESPECE">ESPECE</option>');
                    
                    $("#ref_encaissement").attr("readonly", "true");
                    $("#ref_encaissement").val("ESPECE");
                    
                    $("#lieu").attr("readonly", "true");
                    $("#lieu").val("CAISSE");
                    $("#section_bank").hide();
                } else if(systeme_encaissement=='banque') {
                    $('#mode_encaissement').empty();
                    $('#mode_encaissement').append('<option value="0" disable="true" selected="true">* ('+data.length+') Choix Chargées *</option>');

                    $.each(data, function(index, modObj){
                        $('#mode_encaissement').append('<option value="'+modObj.entite+'">'+ modObj.entite +'</option>');
                    })
                    
                    $("#ref_encaissement").removeAttr("readonly", "true");
                    $("#ref_encaissement").val();
                    $("#section_bank").show();
                } else if(systeme_encaissement=='mobile_money') {
                    $('#mode_encaissement').empty();
                    $('#mode_encaissement').append('<option value="0" disable="true" selected="true">* ('+data.length+') Choix Chargées *</option>');

                    $.each(data, function(index, modObj){
                        $('#mode_encaissement').append('<option value="'+modObj.entite+'">'+ modObj.entite +'</option>');
                    })
                    
                    $("#ref_encaissement").removeAttr("readonly", "true");
                    $("#ref_encaissement").val();
                    $("#section_bank").hide();
                } else {
                    /* $('#mode_encaissement').empty();
                    $('#mode_encaissement').append('<option value="0" disable="true" selected="true">* ('+data.length+') Choix Chargées *</option>');

                    $.each(data, function(index, modObj){
                        $('#mode_encaissement').append('<option value="'+modObj.moyen_paiement+'">'+ modObj.moyen_paiement +'</option>');
                    }) */
                }
            });
        });
        
        $('#client').on('change', function(e){
            console.log(e);
            var client = $('#client').val()/* e.target.value */;
            $.get('/api/json-infos-client?id=' + client,function(data) {
                console.log(data);
                $('#telephone').val(data.telephone);
                $('#adresse').val(data.adresse);
                $('#email').val(data.email);
                if (data.type=='p') {
                    $('#type_client').val('Physique');
                } else if(data.type=='e') {
                    $('#type_client').val('Entreprise');
                } else {
                    $('#type_client').val('Inconnu');
                }
            });
        });

        $('#article').on('change', function(e){
            console.log(e);
            var article = $('#article').val()/* e.target.value */;
            $.get('/api/json-infos-article?id=' + article,function(data) {
                console.log(data);
                $('#pmontant').val(data.prix_vente_minimal);
                $('#pstock').val(data.stock);

                if (data.image==null) {
                    $('#img-article').attr('src', '{{ asset('no-img.jpg') }}');
                    $('#img-article').attr('width', '50px');
                } else {
                    $('#img-article').attr('src', '{{ asset("upload/Articles/Images") }}'+'/'+data.image);
                    $('#img-article').attr('width', '50px');
                    $('#img-article').attr('heigth', '50px');
                }
            });
        });
          

        /* $('#encaissement-part').hide();
        function checkFactureDevis()
        {
            var type_vente = $('#type_vente').val()
            if (type_vente=='d') {
                $('#encaissement-part').hide();
                alert('caché')
            } else {
                $('#encaissement-part').show();
                alert('ouvert')
            }
        }
        $("#type_vente").change(checkFactureDevis); */

        function addForm() {
            save_method = 'add';
            $('input[name_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Nouveau client');
            $('#id').val('');
            $('#nv_client').text(' Enregistrer');
        }
        
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-number/2.1.6/jquery.number.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>

    {{-- <script src="{{ asset('back/transactions/ventes/ajout-article-into-details.js') }}"></script>
    <script src="{{ asset('back/transactions/ventes/encaissement.js') }}"></script> --}}
    {{-- <script src="{{ asset('back/transactions/ventes/nouvelle-vente.js') }}"></script> --}}

    <script>
        $(document).ready(function(){
            $("#btn_add").click(function(){
                ajouter_une_ligne();
            });
        });

    var cont = 0; 
    var total = 0;
    $("#savebtn").hide();

    function ajouter_une_ligne_old()
    {
        var idproduit = $("#article").val();
        var produit = $("#article option:selected").text();
        var quantite =  Number($("#pquantite").val());
        var stock =  Number($("#pstock").val());
        var montant_init = Number($("#pmontant").val());
        var montant_negocie = Number($("#pchmontant").val());
        var remise = Number($("#remise").val());

        // Initialize an empty array to store the items
        let articleArray = [];

        /* Nouvelle configuration */
        if(idproduit != "")
        {
            if (montant_negocie=="" || montant_negocie==0) {

                if (quantite=="" || quantite==0 || quantite<0) {
                    Swal.fire(
                        'Erreurs dans la saisie !',
                        'La quantité ne doit pas etre vide ou negative',
                        'error'
                    )
                    
                    /* Toast.fire({
                        icon: 'warning',
                        title: 'La quantité ne doit pas etre vide ou negative'
                    }); */
                }
                else {
                    if(quantite>stock){
                        Swal.fire(
                            'Erreurs dans la saisie !',
                            'La quantité ne doit pas etre superieure au STOCK',
                            'error'
                        )
                        
                        /* Toast.fire({
                            icon: 'warning',
                            title: 'La quantité ne doit pas etre superieure au STOCK'
                        }); */
                    } else {
                        montant = montant_init;

                        subtotal[cont] = (montant*quantite);
                        total=total+subtotal[cont];
                        var nouvelle_ligne = '<tr class="selected" id="nouvelle_ligne'+cont+'"><td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="supprimer_ligne('+cont+');"><span class="fas fa-trash-alt" aria-hidden="true"></span></button></td> <td><input type="hidden" name="id_produit[]" value="'+idproduit+'">'+produit+' </td> <td class="text-center"><input type="hidden" class="form-control" name="montant[]" value="'+montant+'" />'+montant+'</td> <td class="text-center"><input type="hidden" class="form-control" name="quantite[]" value="'+quantite+'" />'+quantite+'</td> <td class="text-center">'+subtotal[cont]+'</td> </tr>';
                        cont++;
                        initialiser();
                        $("#total").html("Total/. "+total);
                        evaluer();
                        $("#details").append(nouvelle_ligne);
                        $("#sous_total").val(total);
                        $("#a_payer").val(total);

                        /* if ($.inArray(nouvelle_ligne, articleArray)===-1) {
                            articleArray.push(nouvelle_ligne);

                            
                        } else {
                            Swal.fire(
                                'Attention !',
                                "L'article déjà ajouté, manipulez le stock",
                                'warning'
                            )
                        } */
                        
                    }
                }
            } else {
                if (montant_negocie < montant_init) {
                    Swal.fire(
                        'Erreurs dans la saisie !',
                        'Le montant SAISI doit être superieur ou egal au montant minimum',
                        'error'
                    )
                    
                    /* Toast.fire({
                        icon: 'warning',
                        title: 'Le montant SAISI doit être superieur ou egal au montant minimum'
                    }); */
                } else {
                    if (quantite=="" || quantite==0 || quantite<0) {
                        Swal.fire(
                            'Erreurs dans la saisie !',
                            'La quantité ne doit pas etre vide ou negative',
                            'error'
                        )
                    
                        /* Toast.fire({
                            icon: 'warning',
                            title: 'La quantité ne doit pas etre vide ou negative'
                        }); */
                    }
                    else {
                        if(quantite>stock){
                            Swal.fire(
                                'Erreurs dans la saisie !',
                                'La quantité ne doit pas etre superieure au STOCK',
                                'error'
                            )
                            /* Toast.fire({
                                icon: 'warning',
                                title: 'La quantité ne doit pas etre superieure au STOCK'
                            }); */
                        } else {
                            
                            montant = montant_negocie;

                            subtotal[cont] = (montant*quantite);
                            total=total+subtotal[cont];

                            var nouvelle_ligne = '<tr class="selected" id="nouvelle_ligne'+cont+'"><td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="supprimer_ligne('+cont+');"><span class="fas fa-trash-alt" aria-hidden="true"></span></button></td> <td><input type="hidden" name="id_produit[]" value="'+idproduit+'">'+produit+' </td> <td class="text-center"><input type="hidden" class="form-control" name="montant[]" value="'+montant+'" />'+montant+'</td> <td class="text-center"><input type="hidden" class="form-control" name="quantite[]" value="'+quantite+'" />'+quantite+'</td> <td class="text-center">'+subtotal[cont]+'</td> </tr>';
                            cont++;
                            initialiser();
                            $("#total").html("Total/. "+total);
                            evaluer();
                            $("#details").append(nouvelle_ligne);
                            $("#sous_total").val(total);
                            $("#a_payer").val(total);
                        }
                    }
                }
            }
        }
        else
        {
            Swal.fire(
                'Attention !',
                'Choisissez un article',
                'warning'
            )
            /* Toast.fire({
                icon: 'warning',
                title: 'Choisissez un article'
            }); */
        }
        /* Nouvelle configuration */

    }

    function ajouter_une_ligne() {
        var idproduit = $("#article").val();
        var produit = $("#article option:selected").text();
        var quantite = parseInt($("#pquantite").val()) || 0;
        var stock = parseInt($("#pstock").val()) || 0;
        var montant_init = parseFloat($("#pmontant").val()) || 0;
        var montant_negocie = parseFloat($("#pchmontant").val()) || 0;

        if (idproduit != "") {
            var ligneExistante = $("#details tbody tr").filter(function() {
                return $(this).find("input[name='id_produit[]']").val() == idproduit;
            });

            var montant = (montant_negocie > 0) ? montant_negocie : montant_init;

            if (ligneExistante.length > 0) {
                // 🔄 Fusionner les quantités
                var ancienneQuantite = parseInt(ligneExistante.find("input[name='quantite[]']").val()) || 0;
                var nouvelleQuantite = ancienneQuantite + quantite;

                if (nouvelleQuantite > stock) {
                    Swal.fire('Erreur !','La quantité totale dépasse le stock','error');
                    return;
                }

                // ✅ Mettre à jour la quantité et le montant
                ligneExistante.find("input[name='quantite[]']").val(nouvelleQuantite);
                ligneExistante.find("td:eq(3)").html('<input type="hidden" class="form-control" name="quantite[]" value="'+nouvelleQuantite+'" />'+nouvelleQuantite);

                ligneExistante.find("input[name='montant[]']").val(montant);
                ligneExistante.find("td:eq(2)").html('<input type="hidden" class="form-control" name="montant[]" value="'+montant+'" />'+montant);

                // ✅ Recalculer le sous-total
                var nouveauSousTotal = montant * nouvelleQuantite;
                ligneExistante.find("td:eq(4)").text(nouveauSousTotal);

                // 🔄 Recalculer le total global
                recalculerTotal();

                // ✨ Highlight visuel
                ligneExistante.addClass("highlight");
                setTimeout(function(){ ligneExistante.removeClass("highlight"); }, 1000);
                // 🔊 Son spécifique pour mise à jour 
                playSound("pop");

                Swal.fire({ 
                    icon: 'info', 
                    title: "Quantité mise à jour pour l'article : " + produit, 
                    toast: true, 
                    position: 'top-end', 
                    timer: 3000 
                });
            } else {
                // ➕ Nouvelle ligne
                var sousTotal = montant * quantite;

                var nouvelle_ligne = $(`
                    <tr class="selected" id="nouvelle_ligne${cont}" style="display:none;">
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm" onclick="supprimer_ligne(${cont});">
                                <span class="fas fa-trash-alt" aria-hidden="true"></span>
                            </button>
                        </td>
                        <td><input type="hidden" name="id_produit[]" value="${idproduit}">${produit}</td>
                        <td class="text-center"><input type="hidden" class="form-control" name="montant[]" value="${montant}" />${montant}</td>
                        <td class="text-center"><input type="hidden" class="form-control" name="quantite[]" value="${quantite}" />${quantite}</td>
                        <td class="text-center">${sousTotal}</td>
                    </tr>
                `);

                cont++;
                initialiser();
                $("#details tbody").append(nouvelle_ligne);

                // 🔄 recalculer le total global
                recalculerTotal();

                // ✨ Highlight visuel
                nouvelle_ligne.fadeIn(500).addClass("highlight");
                setTimeout(function(){ nouvelle_ligne.removeClass("highlight"); }, 1000);
                
                // 🔊 Son spécifique pour ajout
                playSound("ding");
                
                Swal.fire({ 
                    icon: 'success', 
                    title: "Nouvel article ajouté : " + produit, 
                    toast: true, 
                    position: 'top-end', 
                    timer: 3000 
                });
            }
        } else {
            Swal.fire('Attention !','Choisissez un article','warning');
        }
    }

    function recalculerTotal() {
        total = 0;
        $("#details tbody tr").each(function() {
            var montant = parseFloat($(this).find("input[name='montant[]']").val()) || 0;
            var quantite = parseInt($(this).find("input[name='quantite[]']").val()) || 0;
            var sousTotal = montant * quantite;

            // ✅ Mettre à jour la cellule sous-total
            $(this).find("td:eq(4)").text(sousTotal);

            // ✅ Ajouter au total global
            total += sousTotal;
        });

        // ✅ Mise à jour avec animation sur le total global
        $("#total")
            .hide() // on cache 
            .html("Total/. " + total) // on met à jour 
            .fadeIn(400) // effet fade-in
            .addClass("pulse-total");
        setTimeout(function(){ $("#total").removeClass("pulse-total"); }, 600);

        $("#sous_total").val(total);
        $("#a_payer").val(total);
        evaluer();
    }

    function supprimer_ligne(index) {
        var ligne = $("#nouvelle_ligne" + index);
        // ✨ Highlight suppression
        ligne.addClass("highlight-delete").fadeOut(500, function(){
            $(this).remove();
            recalculerTotal();
        }); 
        // setTimeout(function(){ ligne.remove(); recalculerTotal(); }, 500);

        $("#remise").val("");
        $("#encaissement").val(0);
        $("#restant").val(0);

        $("#total_def").html(total);
        $("#total_def_val").val(total);

        // 🔊 Son spécifique pour suppression
        playSound("cash");
                
    }
    
    // 🎶 Fonction pour jouer différents sons 
    function playSound(type) { 
        let url; 
        switch(type) { 
            case "ding": 
                url = "https://actions.google.com/sounds/v1/alarms/beep_short.ogg"; 
                break; 
            case "pop": 
                url = "https://actions.google.com/sounds/v1/cartoon/pop.ogg"; 
                break; 
            case "cash": 
                url = "https://actions.google.com/sounds/v1/cartoon/wood_plank_flicks.ogg"; 
                break; 
            default: 
                url = "https://actions.google.com/sounds/v1/foley/cash_register.ogg"; 
        } 

        var audio = new Audio(url); 
        audio.volume = 0.9; // volume faible 
        audio.play(); 
    }

    function initialiser() {
        $('#pidproduit').val("").trigger('change');
        $("#pmontant").val(0);
        $("#pchmontant").val(0);
        $("#pquantite").val(0);
        $("#pstock").val(0);
        $("#remise").val('');
    }

    function evaluer() {
        if(total > 0) {
            $("#savebtn").show().addClass("btn-bounce");
            setTimeout(function(){ $("#savebtn").removeClass("btn-bounce"); }, 800);
        } else {
            $("#savebtn").hide();
        }
    }


    function supprimer_ligne_old(index) {
        total = total-subtotal[index];
        $("#total").html("S/. "+total);
        $("#nouvelle_ligne" + index).remove();
        evaluer();
        $("#sous_total").val(total);

        remise = 0;
        $("#remise").val("");
        $("#encaissement").val(0);
        $("#restant").val(0);

        $("#total_def").html(total-(total*(remise/100)));
        $("#total_def_val").val(total-(total*(remise/100)));
    }

    </script>
    
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        $(function() {
            function toNumber(val) {
                return parseFloat(val) || 0;
            }

            function recalculerRestant() {
                var total_def_val = toNumber($("#total_def_val").val());
                var encaissement = toNumber($("#encaissement").val());
                var restant = total_def_val - encaissement;
                $("#restant").val(restant.toFixed(2));
                $("#restant").css("color", restant < 0 ? "red" : "black");
            }

            /* Gestion des remises */
            $("#remise").keyup(function() {
                var sous_total = toNumber($("#sous_total").val());
                var remise = toNumber($("#remise").val());

                if (remise < 0) {
                    Swal.fire('Attention !','La remise ne doit pas être négative','error');
                    remise = 0;
                }
                if (remise > 100) {
                    Swal.fire('Attention !','La remise ne peut pas dépasser 100%','warning');
                    remise = 100;
                }

                var total_def = sous_total - (sous_total * remise / 100);
                $("#total_def").html(total_def.toFixed(2));
                $("#total_def_val").val(total_def.toFixed(2));

                recalculerRestant();

            });

            /* Fin gestion des remises */

            /* Gestion des encaissements */
            $("#encaissement").blur(function() {
                var encaissement = toNumber($("#encaissement").val());
                var total_def_val = toNumber($("#total_def_val").val());

                if (encaissement <= 0) {
                    Toast.fire({ icon: 'warning', title: 'Ajoutez un encaissement' });
                    $('#encaissement').focus().attr('required', true);
                    $('#savebtn').attr('disabled', true);
                } else if (encaissement > total_def_val) {
                    Toast.fire({ icon: 'warning', title: "L'encaissement ne peut pas dépasser le montant facturé" });
                    $('#savebtn').attr('disabled', true);
                } else {
                    $('#savebtn').attr('disabled', false);
                }
            });

            $("#encaissement").keyup(function() {
                recalculerRestant();
            });

            /* Fin gestion des encaissements */
        });
    </script>

    <script>

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 8000,
            timerProgressBar: true,
            /* onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            } */
        });

        let isSubmitting = false;

        $('#formulaire2').submit(function (e) {
            e.preventDefault();
            $('#nv_client').html(' En cours...');
            
            if (isSubmitting) {
                return; // Prevent multiple submissions
            }
            isSubmitting = true;

            /* var url = $(this).attr("action"); */
            let formData = new FormData(this);

            url = "{{ url('api/clients') }}";
        
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    $('#nv_client').html('Enregistrement');
                    $('#formulaire').trigger("reset");
                    $('#modal-form').modal('hide');
                    window.location.reload();
                },
                error: function (response) {
                    $('#formulaire').find(".print-error-msg").find("ul").html('');
                    $('#formulaire').find(".print-error-msg").css('display', 'block');
                    $.each(response.responseJSON.errors, function (key, value) {
                        $('#formulaire').find(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                    });
                },
                complete: function() {
                    isSubmitting = false; // Reset the flag
                }
            });
        });

        
        const $submitButton = $('#savebtn'); 
        const $spinner = $submitButton.find('.spinner-border'); 
        const $btnText = $submitButton.find('.btn-text'); 
        const $defaultIcon = $submitButton.find('.default-icon');

        /* $('#vente2').submit(function (e) {
            e.preventDefault();
            
            if (isSubmitting) return; // Prevent multiple submissions
            isSubmitting = true;

            // Affiche le spinner et cache l’icône
            $defaultIcon.addClass('d-none'); 
            $spinner.removeClass('d-none'); 
            $btnText.removeClass('d-none');
            
            let formData = new FormData(this);
            let url = $(this).attr("action");

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: () => {
                    $('#vente')[0].reset(); 
                    Toast.fire({ 
                        icon: 'success', 
                        title: 'Vente enregistrée avec succès !' 
                    }); 
                    //window.open(window.location.origin + '/dev/transactions/ventes/', '_self');
                    // Attendre 2 secondes avant de rediriger 
                    setTimeout(() => { window.location.href = window.location.origin + '/dev/transactions/ventes/'; }, 2000);
                },
                error: function (response) {
                    $('#vente').find(".print-error-msg").find("ul").html('');
                    $('#vente').find(".print-error-msg").css('display', 'block');
                    if (response.responseJSON && response.responseJSON.errors) {
                        $.each(response.responseJSON.errors, function (key, value) {
                            $('#vente').find(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                        });
                    } else {
                        Toast.fire({ 
                            icon: 'error', 
                            title: 'Une erreur est survenue, veuillez réessayer.' 
                        });
                    }
                },
                complete: function() {
                    isSubmitting = false; // Reset the flag
                    // Réinitialise le bouton 
                    $spinner.addClass('d-none'); 
                    $btnText.addClass('d-none'); 
                    $defaultIcon.removeClass('d-none');
                }
            });
        });
 */
    </script>


    
    <script>

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 8000,
            timerProgressBar: true,
            /* onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            } */
        });

        let isSubmitting = false;

        $('#formulaire').submit(function (e) {
            e.preventDefault();
            $('#nv_client').html(' En cours...');
            
            /* const $submitButton = $(this).find('button[type="submit"]');
            $submitButton.prop('disabled', true).text('Submitting...'); */
            if (isSubmitting) {
                return; // Prevent multiple submissions
            }
            isSubmitting = true;

            /* var url = $(this).attr("action"); */
            let formData = new FormData(this);

            url = "{{ url('api/clients') }}";
        
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    $('#nv_client').html('Enregistrement');
                    $('#formulaire').trigger("reset");
                    $('#modal-form').modal('hide');
                    window.location.reload();
                },
                error: function (response) {
                    $('#formulaire').find(".print-error-msg").find("ul").html('');
                    $('#formulaire').find(".print-error-msg").css('display', 'block');
                    $.each(response.responseJSON.errors, function (key, value) {
                        $('#formulaire').find(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                    });
                },
                complete: function() {
                    isSubmitting = false; // Reset the flag
                }
            });
        });

        
        $('#vente').submit(function (e) {
            e.preventDefault();
            $('#savebtn').html(' En cours...');

            /* const $submitButton = $(this).find('button[type="submit"]');
            $submitButton.prop('disabled', true).text('Submitting...'); */
            if (isSubmitting) {
                return; // Prevent multiple submissions
            }
            isSubmitting = true;

            /* var url = $(this).attr("action"); */
            let formData = new FormData(this);

            url = "{{ url('api/ventes') }}";

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    $('#savebtn').html('Enregistrement');
                    /* $('#vente').trigger("reset"); */
                    $('#vente')[0].reset();
                    var url2 = window.location.origin+'/dev/transactions/ventes/';
                    window.open(url2, '_self');

                    Toast.fire({
                        icon: 'success',
                        title: 'Devis enregistré avec succès !'
                    });
                },
                error: function (response) {
                    $('#vente').find(".print-error-msg").find("ul").html('');
                    $('#vente').find(".print-error-msg").css('display', 'block');
                    $.each(response.responseJSON.errors, function (key, value) {
                        $('#vente').find(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                    });
                },
                complete: function() {
                    isSubmitting = false; // Reset the flag
                }
            });
        });

    </script>
@endpush