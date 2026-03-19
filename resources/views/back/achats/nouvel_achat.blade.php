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
                        <h1>Achat</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dev.dashboard') }}">Tableau de bord</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dev.depenses.achats.achats') }}">Achats</a></li>
                            <li class="breadcrumb-item active">Achat</li>
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
                <form id="vente" class="form-horizontal" method="POST" action="{{ url('api/achats') }}" validate="true">
                    @csrf
                    @method('POST')

                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <div class="card card-maroon">
                                <div class="card-header">
                                    <h3 class="card-title">Etapes d'achat</h3>
                                </div>
                                
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" id="type_achat" name="type_achat" value="f">
                                    
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
                                                    <span class="bs-stepper-label">Fournisseur</span>
                                                </button>
                                            </div>
    
                                            <div class="line"></div>
    
                                            <div class="step" data-target="#detail-part">
                                                <button type="button" class="step-trigger" role="tab" aria-controls="detail-part"
                                                    id="detail-part-trigger" aria-selected="false" disabled="disabled">
                                                    <span class="bs-stepper-circle">2</span>
                                                    <span class="bs-stepper-label">Details Achat</span>
                                                </button>
                                            </div>
    
                                            <div class="line"></div>
    
                                            <div class="step" data-target="#encaissement-part">
                                                <button type="button" class="step-trigger" role="tab"
                                                    aria-controls="encaissement-part" id="encaissement-part-trigger"
                                                    aria-selected="false" disabled="disabled">
                                                    <span class="bs-stepper-circle">3</span>
                                                    <span class="bs-stepper-label">Decaissement</span>
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
                                                                <h3 class="card-title">Fournisseur</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <div class="form-group">
                                                                            <label for="fournisseur">Fournisseur</label>
                                                                            <select id="fournisseur" name="fournisseur_id" class="custom-select rounded-0 select"
                                                                                required style="width: 100%;">
                                                                                <option value="">****** Choix ******</option>
                                                                                @foreach ($fournisseurs as $cli)
                                                                                    <option value="{{ $cli->id }}"> {{ $cli->fournisseur }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="type">Type</label>
                                                                            <input type="text" class="form-control rounded-0"
                                                                                id="type_fournisseur" readonly>
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
                                                                <h3 class="card-title">Nouveau Fournisseur</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="row">
                                                                            <div class="col-md-12 col-sm-12 col-12 d-flex">
                                                                                <button type="button" class="btn btn-flat btn-primary ml-auto" onclick="addForm()">
                                                                                    <i class="bi bi-plus-lg"></i> Ajouter un Fournisseur
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
                                                                    <div class="col-md-12 col-sm-12 col-12">
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
                                                                    
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-3 col-sm-3 col-3">
                                                                        <div class="form-group">
                                                                            <label for="img-article"></label>
                                                                            <img id="img-article" class="img">
                                                                        </div>
                                                                        <!-- /.info-box -->
                                                                    </div>
                                                                    
                                                                    <div class="col-sm-6 col-6">
                                                                        <div class="form-group">
                                                                            <label for="pstock">Stock</label>
                                                                            <input type="text" class="form-control rounded-0" id="pstock" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6 col-6">
                                                                        <div class="form-group">
                                                                            <label for="pmontant">Montant</label>
                                                                            <input type="text" class="form-control rounded-0" id="pmontant" />
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
                                                                <h3 class="card-title">Details Achats</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="table-responsive">
                                                                            <table
                                                                                class="table table-striped table-bordered table-condensed table-hover mt-1"
                                                                                id="details">
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
    
                                                                                </tbody class="text-xs">
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
                                                                        <h3 class="card-title">Achat</h3>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-12 col-6">
                                                                                <div class="form-group">
                                                                                    <label for="sous_total">Sous total</label>
                                                                                    <h6 id="total">S/. 0.00</h6>
                                                                                    <input type="hidden" class="form-control"
                                                                                        name="montants" id="sous_total">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12 col-6">
                                                                                <div class="form-group">
                                                                                    <label for="sous_total">Remise (%)</label>
                                                                                    <input type="number" class="form-control rounded-0"
                                                                                        name="remise" id="remise"
                                                                                        placeholder="La Remise">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12">
                                                                                <div class="form-group">
                                                                                    <label for="total">Total</label>
                                                                                    <h6 id="total_def">S/. 0.00</h6>
                                                                                    <input type="hidden" class="form-control"
                                                                                        name="montants_apres_remise" id="total_def_val">
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
                                                                <h3 class="card-title">Decaissement</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-4 col-12">
                                                                        <div class="form-group">
                                                                            <label for="systeme_decaissement">Systeme Paie</label>
                                                                            <select name="systeme_decaissement"
                                                                                id="systeme_decaissement" class="custom-select rounded-0">
                                                                                <option value="">*** Choix ***</option>
                                                                                <option value="mobile_money">Mobile money</option>
                                                                                <option value="banque">Banque</option>
                                                                                <option value="espece">Espece</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
    
                                                                    <div class="col-sm-4 col-12">
                                                                        <div class="form-group">
                                                                            <label for="mode_decaissement">Mode</label>
                                                                            <select name="mode_decaissement" id="mode_decaissement"
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
                                                                            <label for="ref_decaissement">Reference</label>
                                                                            <input type="text" class="form-control rounded-0"
                                                                                name="ref_decaissement" id="ref_decaissement">
                                                                        </div>
                                                                    </div>
    
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="decaissement">Décaissement</label>
                                                                            <input type="text" class="form-control rounded-0"
                                                                                name="decaissement" id="decaissement" />
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
    
                                <div class="card-footer justify-content-end">
                                    <button type="submit" class="btn btn-primary fas fa-save" id="savebtn"> Enregistrer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </form>

                
                @include('back.fournisseurs.form')
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
        $('#systeme_decaissement').on('change', function(e){
            console.log(e);

            var systeme_encaissement = $('#systeme_decaissement').val();
            $.get('/api/json-moyens-paie?systeme_encaissement=' + systeme_encaissement,function(data) {
                console.log(data);
                if (systeme_encaissement=='espece') {
                    
                    alert('espece activé')
                    $('#mode_decaissement').empty();
                    $('#mode_decaissement').append('<option value="ESPECE">ESPECE</option>');
                    
                    $("#ref_decaissement").attr("readonly", "true");
                    $("#ref_decaissement").val("ESPECE");
                    
                    $("#lieu").attr("readonly", "true");
                    $("#lieu").val("CAISSE");
                    $("#section_bank").hide();
                } else if(systeme_encaissement=='banque') {
                    $('#mode_decaissement').empty();
                    $('#mode_decaissement').append('<option value="0" disable="true" selected="true">* ('+data.length+') Choix Chargées *</option>');

                    $.each(data, function(index, modObj){
                        $('#mode_decaissement').append('<option value="'+modObj.entite+'">'+ modObj.entite +'</option>');
                    })
                    
                    $("#ref_decaissement").removeAttr("readonly", "true");
                    $("#ref_decaissement").val();
                    $("#section_bank").show();
                } else if(systeme_encaissement=='mobile_money') {
                    $('#mode_decaissement').empty();
                    $('#mode_decaissement').append('<option value="0" disable="true" selected="true">* ('+data.length+') Choix Chargées *</option>');

                    $.each(data, function(index, modObj){
                        $('#mode_decaissement').append('<option value="'+modObj.entite+'">'+ modObj.entite +'</option>');
                    })
                    
                    $("#ref_decaissement").removeAttr("readonly", "true");
                    $("#ref_decaissement").val();
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
        
        $('#fournisseur').on('change', function(e){
            console.log(e);
            var fournisseur = $('#fournisseur').val()/* e.target.value */;
            $.get('/api/json-infos-fournisseur?id=' + fournisseur,function(data) {
                console.log(data);
                $('#telephone').val(data.telephone);
                $('#adresse').val(data.adresse);
                $('#email').val(data.email);
                if (data.type=='i') {
                    $('#type_fournisseur').val('Informel');
                } else if(data.type=='f') {
                    $('#type_fournisseur').val('Formel');
                } else {
                    $('#type_fournisseur').val('Inconnu');
                }
            });
        });

        $('#article').on('change', function(e){
            console.log(e);
            var article = $('#article').val()/* e.target.value */;
            $.get('/api/json-infos-article?id=' + article,function(data) {
                console.log(data);
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
            $('.modal-title').text('Nouveau fournisseur');
            $('#id').val('');
            $('#nv_fournisseur').text(' Enregistrer');
        }
        
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-number/2.1.6/jquery.number.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>

    <script>
        
        /**************** Details Facture ************************/
        
        $(document).ready(function(){
            $("#btn_add").click(function(){
              ajouter_une_ligne();
            });
        });

        var cont = 0;
        total = 0;
        subtotal = [];
        $("#savebtn").hide();

        function ajouter_une_ligne()
        {
            var idproduit = $("#article").val();
            var produit = $("#article option:selected").text();
            var quantite =  Number($("#pquantite").val());
            var stock =  Number($("#pstock").val());
            var montant_init = Number($("#pmontant").val());
            var remise = Number($("#remise").val());

            // Initialize an empty array to store the items
            let articleArray = [];

            /* Nouvelle configuration */
            if(idproduit != "")
            {
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
            else
            {
                Swal.fire(
                    'Attention !',
                    'Choisissez un article',
                    'warning'
                )
            }
            /* Nouvelle configuration */

        }


        /********* 1.) Initialisation de la qte, du prix d'achat et du prix de vente à nulle **************/
        function initialiser()
        {
            /* $("#pidproduit").val(""); */
            $('#pidproduit').val("").trigger('change');
            
            $("#pmontant").val(0);
            $("#pquantite").val(0);
            $("#pstock").val(0);

            $("#remise").val('');
        }

        /********* 2.) Evaluation du total avant envoie du formulaire **************/
        function evaluer()
        {
            if(total > 0)
            {
                $("#savebtn").show();
            }

            else
            {
                $("#savebtn").hide();
            }
        }

        function supprimer_ligne(index)
        {
            total = total-subtotal[index];
            $("#total").html("S/. "+total);
            $("#nouvelle_ligne" + index).remove();
            evaluer();
            $("#sous_total").val(total);

            remise = 0;
            $("#remise").val("");
            $("#decaissement").val(0);
            $("#restant").val(0);

            $("#total_def").html(total-(total*(remise/100)));
            $("#total_def_val").val(total-(total*(remise/100)));
        }

        $(function() {
            $("#remise").keyup(function() {
                sous_total = $("#sous_total").val();
                remise = $("#remise").val();
                
                if (remise=="" || remise==0) {
                    $("#total_def").html(sous_total);
                    $("#total_def_val").val(sous_total);
                    $("#decaissement").val(0);
                    $("#restant").val(0);
                } else if(remise<0) {
                    Swal.fire(
                        'Attention !',
                        'La remise ne doit pas être négative',
                        'danger'
                    )
                    $("#remise").val(0);
                    $("#total_def").html(sous_total);
                    $("#total_def_val").val(sous_total);
                    $("#decaissement").val(0);
                    $("#restant").val(0);
                } else {
                    $("#total_def").html(sous_total-(sous_total*(remise/100)));
                    $("#total_def_val").val(sous_total-(sous_total*(remise/100)));
                    $("#decaissement").val(0);
                    $("#restant").val(0);
                }
            });

            /* Gestion des encaissements */
            $("#decaissement").blur(function() {
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
                
                var decaissement = $("#decaissement").val();
                var sous_total = $("#sous_total").val();
                var total_def_val = $("#total_def_val").val();

                if (decaissement=="" || decaissement==0) {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Ajoutez un decaissement'
                    });
                    $('#decaissement').focus();
                    $('#decaissement').attr('required', true);
                    $('#savebtn').attr('disabled', true);
                } else {
                    if (decaissement>total_def_val) {
                        Toast.fire({
                            icon: 'warning',
                            title: "Le décaissement ne peut être pas être supérieur au montant facturé"
                        });
                        
                        $('#savebtn').attr('disabled', true);
                    } else {
                        $('#savebtn').attr('disabled', false);
                    }
                }
            });


            $("#decaissement").keyup(function() {
                var decaissement = $("#decaissement").val();
                var sous_total = $("#sous_total").val();
                var total_def_val = $("#total_def_val").val();
                var remise = $("#remise").val();

                $('#savebtn').attr('disabled', false);

                if (remise==0) {
                    $('#restant').val(sous_total-decaissement);
                } else {
                    $('#restant').val(total_def_val-decaissement);    
                }
                
            });
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
        
        $('#formulaire').submit(function (e) {
            e.preventDefault();
            $('#nv_fournisseur').html(' En cours...');
            
            /* const $submitButton = $(this).find('button[type="submit"]');
            $submitButton.prop('disabled', true).text('Submitting...'); */
            if (isSubmitting) {
                return; // Prevent multiple submissions
            }
            isSubmitting = true;

            /* var url = $(this).attr("action"); */
            let formData = new FormData(this);

            url = "{{ url('api/fournisseurs') }}";
        
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    $('#nv_fournisseur').html('Enregistrement');
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

            url = "{{ url('api/achats') }}";

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    $('#savebtn').html('Enregistrement');
                    $('#vente')[0].reset();
                    var url = window.location.origin+'/admin/depenses/achats/achats/';
                    window.open(url, '_self');

                    Toast.fire({
                        icon: 'success',
                        title: 'Achat enregistré avec succès !'
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