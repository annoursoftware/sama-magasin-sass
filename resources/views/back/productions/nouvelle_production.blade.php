@extends('back.master')

@section('title', 'Productions')

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
                        <h1>Productions</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dev.dashboard') }}">Tableau de bord</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dev.productions.productions') }}">Productions</a></li>
                            <li class="breadcrumb-item active">Production</li>
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
                                    <h3 class="card-title">Etapes de Productions</h3>
                                </div>

                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                                <div class="row">
                                    <div class="col-12">
                                        <blockquote class="quote-danger print-error-msg" style="display:none">
                                            <ul></ul>
                                        </blockquote>
                                    </div>
                                </div>

                                <div class="card-body mt-4">
                                    <div class="row mt-1">
                                        <div class="col-sm-4">
                                            <div class="card card-maroon">
                                                <div class="card-header">
                                                    <h3 class="card-title">Produits</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-10 col-sm-10 col-10">
                                                            <div class="form-group">
                                                                <label for="pidproduit">Produits</label>
                                                                <select name="pidproduit" id="produit" class="custom-select rounded-0 select"
                                                                    style="width: 100%;">
                                                                    <option value="">**** Choix ****</option>

                                                                    @foreach ($produits as $p)
                                                                        <option value="{{ $p->id }}">{{ $p->produit }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-1 col-sm-2 col-2">
                                                            <div class="form-group">
                                                                <label for="img-produit"></label>
                                                                <img id="img-produit" class="img">
                                                            </div>
                                                            <!-- /.info-box -->
                                                        </div>
                                                    </div>

                                                    <div class="row">

                                                        <div class="col-sm-6 col-6">
                                                            <div class="form-group">
                                                                <label for="pstock">Stock</label>
                                                                <input type="text" class="form-control rounded-0" id="pstock" readonly />
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 col-6">
                                                            <div class="form-group">
                                                                <label for="pquantite">Quantite</label>
                                                                <input type="number" class="form-control rounded-0" id="pquantite" />
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-1 col-6">
                                                            <div class="form-group">
                                                                <button type="button" id="btn_add" class="btn btn-danger btn-md">+</button>
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
                                                                <table class="table table-striped table-bordered table-condensed table-hover mt-1"
                                                                    id="details">
                                                                    <thead style="background-color:rgb(243, 64, 118)">
                                                                        <tr class="text-white text-sm">
                                                                            <th class="text-center" width="3%">Options
                                                                            </th>
                                                                            <th width="50%">Produits</th>
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

                                                    <div class="row d-flex">
                                                        <div class="col-sm-6 ml-auto">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-bordered table-condensed table-hover mt-0">
                                                                    <tfooter>
                                                                        <tr style="background-color:rgb(243, 64, 118)" class="text-white text-sm">
                                                                            <th class="text-center" colspan="1">Sous total</th>
                                                                            <th class="text-center" id="total"></th>
                                                                            <input type="hidden" class="form-control" name="montants" id="sous_total">
                                                                        </tr>
                                                                    </tfooter>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

        $('#produit').on('change', function(e){
            console.log(e);
            var produit = $('#produit').val()/* e.target.value */;
            $.get('/api/json-infos-produit?id=' + produit,function(data) {
                console.log(data);
                $('#pstock').val(data.production);

                if (data.image==null) {
                    $('#img-produit').attr('src', '{{ asset('no-img.jpg') }}');
                    $('#img-produit').attr('width', '50px');
                } else {
                    $('#img-produit').attr('src', '{{ asset("upload/Produits/Images") }}'+'/'+data.image);
                    $('#img-produit').attr('width', '50px');
                    $('#img-produit').attr('heigth', '50px');
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
            var idproduit = $("#produit").val();
            var produit = $("#produit option:selected").text();
            var quantite =  Number($("#pquantite").val());
            var stock =  Number($("#pstock").val());

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
                } else {

                    subtotal[cont] = (1*quantite);
                    total=total+subtotal[cont];
                    var nouvelle_ligne = '<tr class="selected" id="nouvelle_ligne'+cont+'"><td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="supprimer_ligne('+cont+');"><span class="fas fa-trash-alt" aria-hidden="true"></span></button></td> <td><input type="hidden" name="id_produit[]" value="'+idproduit+'">'+produit+' </td> <td class="text-center"><input type="hidden" class="form-control" name="quantite[]" value="'+quantite+'" />'+quantite+'</td> <td class="text-center">'+subtotal[cont]+'</td> </tr>';
                    cont++;
                    initialiser();
                    $("#total").html(total);
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
                    'Choisissez un Produit',
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
            
            $("#pquantite").val(0);
            $("#pstock").val(0);
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
        }

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

            url = "{{ url('api/productions') }}";

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    $('#savebtn').html('Enregistrement');
                    $('#vente')[0].reset();
                    var url = window.location.origin+'/admin/productions/productions/';
                    window.open(url, '_self');

                    Toast.fire({
                        icon: 'success',
                        title: 'Production enregistrée avec succès !'
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