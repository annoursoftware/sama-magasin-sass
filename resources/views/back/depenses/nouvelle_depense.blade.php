@extends('back.master')

@section('title', 'Dépenses')

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
                            <h1>Dépenses</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dev.dashboard') }}">Tableau de bord</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('dev.autres-depenses.depenses') }}">Dépenses</a></li>
                                <li class="breadcrumb-item active">Dépense</li>
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
                    <form id="vente" class="form-horizontal" method="POST" action="{{ url('api/depenses') }}" validate="true">
                        @csrf
                        @method('POST')

                        <div class="row mt-4">
                            <div class="col-sm-12">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Etapes de dépenses</h3>
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

                                                <div class="step active" data-target="#benef-part">
                                                    <button type="button" class="step-trigger" role="tab" aria-controls="benef-part"
                                                        id="benef-part-trigger" aria-selected="false" disabled="disabled">
                                                        <span class="bs-stepper-circle">1</span>
                                                        <span class="bs-stepper-label">Bénéficiaire</span>
                                                    </button>
                                                </div>

                                                <div class="line"></div>

                                                <div class="step" data-target="#detail-part">
                                                    <button type="button" class="step-trigger" role="tab" aria-controls="detail-part"
                                                        id="detail-part-trigger" aria-selected="false" disabled="disabled">
                                                        <span class="bs-stepper-circle">2</span>
                                                        <span class="bs-stepper-label">Dépense</span>
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

                                                <div id="benef-part" class="content active dstepper-block" role="tabpanel"
                                                    aria-labelledby="benef-part-trigger">
                                                    <div class="row mt-2">
                                                        <div class="col-sm-8 col-12 p-3">
                                                            <div class="card card-maroon">
                                                                <div class="card-header">
                                                                    <h3 class="card-title">Bénéficiaires</h3>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-8">
                                                                            <div class="form-group">
                                                                                <label for="beneficiaire">Bénéficiaire</label>
                                                                                <select id="beneficiaire" name="beneficiaire_id" class="custom-select rounded-0 select"
                                                                                    required style="width: 100%;">
                                                                                    <option value="">****** Choix ******</option>
                                                                                    @foreach ($beneficiaires as $b)
                                                                                        <option value="{{ $b->id }}">
                                                                                        {{ $b->beneficiaire }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-4">
                                                                            <div class="form-group">
                                                                                <label for="tel">Telephone</label>
                                                                                <input type="text" class="form-control rounded-0"
                                                                                    id="telephone" readonly>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-7">
                                                                            <div class="form-group">
                                                                                <label for="email">Email</label>
                                                                                <input type="text" class="form-control rounded-0"
                                                                                    id="email" readonly>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-5">
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
                                                                    <h3 class="card-title">Nouveau Bénéficiaire</h3>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div class="row">
                                                                                <div class="col-md-12 col-sm-12 col-12 d-flex">
                                                                                    <button type="button" class="btn btn-flat btn-primary ml-auto" onclick="addForm()">
                                                                                        <i class="bi bi-plus-lg"></i> Ajouter un Bénéficiaire
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
                                                    <div class="row mt-2">
                                                        <div class="col-sm-12">
                                                            <div class="card card-maroon">
                                                                <div class="card-header">
                                                                    <h3 class="card-title">Dépense</h3>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                                <label for="libelle">Libellé <span class="text-danger">*</span></label>
                                                                                <input type="text" class="form-control rounded-0" name="libelle" id="libelle" required
                                                                                    placeholder="Le libelle de la dépense" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-4">
                                                                            <div class="form-group">
                                                                                <label for="numero_facture_benef">N° Facture</label>
                                                                                <input type="text" class="form-control rounded-0" name="numero_facture_benef" id="numero_facture_benef"
                                                                                    placeholder="N° facture beneficiaire" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-4">
                                                                            <div class="form-group">
                                                                                <label for="montant">montant (XOF) <span class="text-danger">*</span></label>
                                                                                <input type="number" class="form-control rounded-0" name="montant" id="montant" required
                                                                                    placeholder="Montant facture" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-4">
                                                                            <div class="form-group">
                                                                                <label for="type">Type dépense</label>
                                                                                <select class="custom-select rounded-0" id="type" name="type" required>
                                                                                    <option value="">*** Choix ***</option>
                                                                                    <option value="dir">Directe</option>
                                                                                    <option value="dif">Différé</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <div class="form-group">
                                                                                <label for="effet">Effet</label>
                                                                                <input type="date" class="form-control rounded-0" name="effet" id="effet" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <div class="form-group">
                                                                                <label for="limite">Limite</label>
                                                                                <input type="date" class="form-control rounded-0" name="limite" id="limite" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-4">
                                                                            <div class="form-group">
                                                                                <label for="boutique">Boutique</label>
                                                                                <select class="custom-select rounded-0" id="boutique" name="boutique_id">
                                                                                    <option value="">*** Choix ***</option>
                                                                                    @foreach ($boutiques as $b)
                                                                                        <option value="{{ $b->id }}">{{ $b->boutique }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row mt-2">
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
                                                                                        <label for="sous_total">Montant à payer</label>
                                                                                        <h6 id="total">S/. 0.00</h6>
                                                                                        <input type="hidden" class="form-control"
                                                                                            name="montants" id="sous_total">
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


                    @include('back.beneficiaires.form')
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
        
        $('#beneficiaire').on('change', function(e){
            console.log(e);
            var beneficiaire = $('#beneficiaire').val()/* e.target.value */;
            $.get('/api/json-infos-beneficiaire?id=' + beneficiaire,function(data) {
                console.log(data);
                $('#telephone').val(data.telephone);
                $('#adresse').val(data.adresse);
                $('#email').val(data.email);
            });
        });

        function addForm() {
            save_method = 'add';
            $('input[name_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Nouveau bénéficiaire');
            $('#id').val('');
            $('#nv_beneficiaire').text(' Enregistrer');
        }
        
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-number/2.1.6/jquery.number.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>

    <script>
        
        /**************** Details Facture ************************/
        /* $("#savebtn").hide(); */

        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
            });
            
            $("#montant").blur(function() {
                var montant_depense = $("#montant").val();
                var sous_total = $("#sous_total").val(montant_depense);
                var affiche_total = $("#total").html(montant_depense);
                Toast.fire({
                    icon: 'success',
                    title: 'montant dépense fixé à : '+montant_depense
                });
            });
            
            $("#type").change(function() {
                var type = $("#type").val();
                
                if (type=="dir") {
                    Toast.fire({
                        icon: 'warning',
                        title: "La dépense est en mode paiement direct"
                    });

                    /* Gestion des decaissements */
                    $("#decaissement").blur(function() {
                        var decaissement = $("#decaissement").val();
                        var sous_total = $("#montant").val();

                        if (decaissement=="" || decaissement==0) {
                            Toast.fire({
                                icon: 'warning',
                                title: 'Ajoutez un decaissement'
                            });
                            $('#decaissement').focus();
                            $('#decaissement').attr('required', true);
                            $('#savebtn').attr('disabled', true);
                        } else {
                            if (decaissement>sous_total) {
                                Toast.fire({
                                    icon: 'warning',
                                    title: "Le décaissement ne peut être pas être supérieur au montant facturé"
                                });
                                
                                $('#savebtn').attr('disabled', true);
                            } else {
                                $('#savebtn').attr('disabled', false);

                                Toast.fire({
                                    icon: 'success',
                                    title: "Super !"
                                });
                            }
                        }
                    });


                    $("#decaissement").keyup(function() {
                        var decaissement = $("#decaissement").val();
                        var sous_total = $("#montant").val();

                        $('#restant').val(sous_total-decaissement);
                        
                        $('#savebtn').attr('disabled', false);
                    });

                } else if(type=="") {
                    Toast.fire({
                        icon: 'danger',
                        title: "Veuillez choisir un type de dépense !"
                    });
                    $("#type").focus();
                } else {
                    Toast.fire({
                        icon: 'warning',
                        title: "La dépense est en mode paiement différé"
                    });
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
            $('#nv_beneficiaire').html(' En cours...');
            
            /* const $submitButton = $(this).find('button[type="submit"]');
            $submitButton.prop('disabled', true).text('Submitting...'); */
            if (isSubmitting) {
                return; // Prevent multiple submissions
            }
            isSubmitting = true;

            /* var url = $(this).attr("action"); */
            let formData = new FormData(this);

            url = "{{ url('api/beneficiaires') }}";
        
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    $('#nv_beneficiaire').html('Enregistrement');
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

            url = "{{ url('api/depenses') }}";

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    $('#savebtn').html('Enregistrement');
                    $('#vente')[0].reset();
                    var url = window.location.origin+'/admin/autres-depenses/depenses/';
                    window.open(url, '_self');

                    Toast.fire({
                        icon: 'success',
                        title: 'Dépense enregistrée avec succès !'
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