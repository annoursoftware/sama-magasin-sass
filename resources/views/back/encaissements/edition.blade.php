@extends('back.master')

@section('title', 'Encaissements')

@push('styles')

    <style>
        input:not([type="file"]).error,
        textarea.error,
        select.error {
            border: 1px solid red !important;
        }

        input:not([type="file"]).no-error,
        textarea.no-error,
        select.no-error {
            border: 1px solid green !important;
        }

        div.error-field {
            color: red;
            font-size: small;
        }
    </style>

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
                        <h1>Administration encaissement</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dev.dashboard') }}">Tableau de bord</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dev.finances.encaissements') }}">Encaissements</a></li>
                            <li class="breadcrumb-item active">Encaissement N°{{ $encaissement->num_encaissement }}</li>
                        </ol>
                    </div>
                </div>
                <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container">
                <div class="row">

                    <input type="hidden" value="{{ $encaissement->id }}" name="id" id="id">

                    <div class="col-lg-4 col-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Encaissement</h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-maroon"><i class="bi bi-cash"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Encaissement</span>
                                                        <span class="info-box-number text-sm">
                                                            {{ $encaissement->num_encaissement }}
                                                            /
                                                            {{ \Carbon\Carbon::parse($encaissement->created_at)->format('d-m-Y h:i:s') }}
                                                        </span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->

                                            <div class="col-md-12 col-sm-12 col-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-maroon"><i class="bi bi-pencil"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Production</span>
                                                        <span class="info-box-number text-sm">
                                                            {{ $encaissement->num_production }}
                                                            /
                                                            {{ \Carbon\Carbon::parse($encaissement->date_etablissement)->format('d-m-Y h:i:s') }}
                                                        </span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->

                                            <div class="col-md-12 col-sm-6 col-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-maroon"><i class="bi bi-person"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Client</span>
                                                        <span class="info-box-number text-sm">{{ $encaissement->client }}</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->

                                            <div class="col-md-12 col-sm-6 col-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-maroon"><i class="bi bi-phone"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Telephone</span>
                                                        <span class="info-box-number text-sm">{{ $encaissement->telephone }} |
                                                            {{ $encaissement->telephone }}</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->

                                            <div class="col-md-12 col-sm-6 col-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-maroon"><i class="bi bi-geo"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Adresse</span>
                                                        <span class="info-box-number text-sm">{{ $encaissement->adresse }}</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        @if (Request::is('admin/*'))
                                            <a href="{{ route('admin.vente.ventes') }}" class="btn btn-primary float-left">
                                                <i class="fas fa-home"></i> Retour
                                            </a>
                                        @elseif (Request::is('dev/*'))
                                            <a href="{{ route('dev.finances.encaissements') }}" class="btn btn-primary float-left">
                                                <i class="fas fa-home"></i> Retour
                                            </a>
                                        @elseif (Request::is('vendeur/*'))
                                            <a href="{{ route('vendeur.vente.ventes') }}" class="btn btn-primary float-left">
                                                <i class="fas fa-home"></i> Retour
                                            </a>
                                        @else
                                            <a href="{{ route('dev.vente.ventes') }}" class="btn btn-primary float-left">
                                                <i class="fas fa-home"></i> Retour
                                            </a>
                                        @endif
                                    </div>

                                    <!-- /.card-body -->
                                </div>
                            </div>
                            
                            <div class="col-lg-12 col-12">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Statut Encaissement</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            @if ($encaissement->etat == 0)
                                                <div class="col-md-12 col-sm-12 col-12">
                                                    <div class="info-box">
                                                        <span class="info-box-icon bg-maroon"><i class="bi bi-pencil"></i></span>

                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Etat</span>
                                                            <span class="info-box-number text-sm">Encaissement annulé</span>
                                                        </div>
                                                        <!-- /.info-box-content -->
                                                    </div>
                                                    <!-- /.info-box -->
                                                </div>
                                                <!-- /.col -->
                                            @else
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="etat">Etat</label>
                                                        <select id="etat" name="etat" class="custom-select">
                                                            <option value="">*** Choix ***</option>
                                                            <option value="1" selected>En cours</option>
                                                            <option value="0">Annulée</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-12">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Détails Financiers</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12 col-12">
                                                <div class="info-box">

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Production</span>
                                                        <span
                                                            class="info-box-number text-sm">{{ number_format($production, 0, ',', '.') }}
                                                            FCFA</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->

                                            <div class="col-md-4 col-sm-12 col-12">
                                                <div class="info-box">

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Encaissements</span>
                                                        <span
                                                            class="info-box-number text-sm">{{ number_format($encaissements->sum('montant'), 0, ',', '.') }}
                                                            FCFA
                                                        </span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->

                                            <div class="col-md-4 col-sm-12 col-12">
                                                <div class="info-box {{ $production-$encaissements->sum('montant')==0 ? 'bg-success' : 'bg-danger' }}">

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Restant</span>
                                                        <span class="info-box-number text-sm">
                                                            {{number_format($production-$encaissements->sum('montant'), 0, ",",".")}} FCFA
                                                        </span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-2">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Détails des encaissements</h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <div class="card-body">

                                        <div class="row mb-2">
                                            @if ($production-$encaissements->sum('montant')==0)
                                                
                                            @else
                                            <div class="col-md-12 col-sm-12 col-12 d-flex">
                                                <button type="button" class="btn btn-flat btn-primary ml-auto" onclick="addForm()">
                                                    <i class="bi bi-plus-lg"></i> Ajouter un encaissement
                                                </button>
                                            </div>
                                            @endif

                                            <div class="col-md-12 col-12 mt-2">
                                                <div class="table-responsive">
                                                    <table
                                                        class="table table-striped table-bordered table-condensed table-hover text-sm mt-1">
                                                        <thead style="background-color:rgb(243, 64, 118)">
                                                            <tr class="text-white">
                                                                <th class="text-center">#</th>
                                                                <th class="text-center">Date</th>
                                                                <th>Mode</th>
                                                                <th>Référence</th>
                                                                <th class="text-center">Caissier</th>
                                                                <th class="text-center">Montant</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @if (count($encaissements) == 0)
                                                                <tr class="text-center table-danger">
                                                                    <td colspan="4">Aucun Encaissement enregistré</td>
                                                                </tr>
                                                            @else
                                                                <?php $i = 0 ?>
                                                                @foreach($encaissements as $e)
                                                                <?php $i++ ?>
                                                                    <tr class="text-xs">
                                                                        @if ($encaissement->etat == 1)
                                                                            @if ($e->etat == 1)
                                                                                <td class="text-center">
                                                                                    <button type="button" class="btn btn-outline-danger btn-sm deleteData" data-id="{{ $e->id }}">
                                                                                        <span class="bi bi-trash3-fill" aria-hidden="true"></span>
                                                                                    </button>
                                                                                    /
                                                                                    <button type="button" class="btn btn-outline-primary btn-sm editData" data-id="{{ $e->id }}">
                                                                                        <span class="bi bi-pencil-fill" aria-hidden="true"></span>
                                                                                    </button>
                                                                                </td>
                                                                            @else
                                                                                <td class="text-center">
                                                                                    <button type="button" class="btn btn-outline-primary btn-sm editData" data-id="{{ $e->id }}">
                                                                                        <span class="bi bi-pencil-fill" aria-hidden="true"></span>
                                                                                    </button>
                                                                                </td>
                                                                            @endif
                                                                        @else
                                                                            <td class="text-center">{{ $i }}</td>
                                                                        @endif

                                                                        @if ($encaissement->etat == 1)    
                                                                            @if ($e->etat == 1)
                                                                                <td class="text-center">{{\Carbon\Carbon::parse(($e->created_at))->format('d/m/Y')}}</td>
                                                                                <td>{{ $e->mode_encaissement }}</td>
                                                                                <td>{{ $e->ref_encaissement }}</td>
                                                                                <td class="text-center">{{ $e->name }}</td>
                                                                                <td class="text-center">{{number_format($e->montant, 0, ",",".")}} FCFA</td>
                                                                            @else
                                                                                <td class="text-center"><strike>{{\Carbon\Carbon::parse(($e->created_at))->format('d/m/Y')}}</strike></td>
                                                                                <td><strike>{{ $e->mode_encaissement }}</strike></td>
                                                                                <td><strike>{{ $e->ref_encaissement }}</strike></td>
                                                                                <td class="text-center"><strike>{{ $e->name }}</strike></td>
                                                                                <td class="text-center"><strike>{{number_format($e->montant, 0, ",",".")}} FCFA</strike></td>
                                                                            @endif
                                                                        @else
                                                                            <td class="text-center"><strike>{{\Carbon\Carbon::parse(($e->created_at))->format('d/m/Y')}}</strike></td>
                                                                            <td><strike>{{ $e->mode_encaissement }}</strike></td>
                                                                            <td><strike>{{ $e->ref_encaissement }}</strike></td>
                                                                            <td class="text-center"><strike>{{ $e->name }}</strike></td>
                                                                            <td class="text-center"><strike>{{number_format($e->montant, 0, ",",".")}} FCFA</strike></td>
                                                                        @endif

                                                                    </tr>
                                                                    @include('back.encaissements.edit-encaissement')
                                                                @endforeach
                                                            @endif
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        @include('back.encaissements.form')
                                    </div>
                                    <!-- /.card-body -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="{{ asset('back/plugins/select2/js/select2.min.js') }}"></script>

    <script>

        $(document).ready(function () {
            $('.select').select2({
                theme: 'bootstrap4',
                allowClear: false
            });
        });

        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        })

        $(document).ready(function () {
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

        
        /******* Changement Etat *******/
        $("#etat").change(function(){
            var id = $("#id").val();
            var token = $("meta[name='csrf-token']").attr("content");
            var etat = $('#etat').val();
            /* alert(id, client) */
            $.ajax(
            {
                url : "{{ url('api/modification-etat-encaissement') . '/' }}" + id,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                    "etat": etat,
                },
                success: function (){
                    Swal.fire(
                        'Etat',
                        'Etat encaissement modifié avec succès.',
                        'success'
                    )

                    //setInterval('location.reload()', 1000);
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            });
        });
        /******* Changement Etat *******/
            
        /* Remise */
        $('#remise').on('blur', function () {
            let quantite = $(this).val();
            let id = $("#id").val();
            let remise = $("#remise").val();
            let token = $("meta[name='csrf-token']").attr("content");
            
            $.ajax({
                url: '{{ url('api/actualisation-remise-vente') }}' + "/" + id,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                    "remise": remise,
                },
                success: function (){
                    Swal.fire(
                        'Modification',
                        'Remise actualisée avec succès.',
                        'success'
                    )

                    setInterval('location.reload()', 8000);
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            })

        });
        /* Remise */

        /******* Changement Etat *******/
        $("#status_vente").change(function(){
            var id = $("#id").val();
            var token = $("meta[name='csrf-token']").attr("content");
            var status_vente = $('#status_vente').val();
            /* alert(id, client) */
            $.ajax(
            {
                url : "{{ url('api/modification-statut-vente') . '/' }}" + id,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                    /* "etat": etat, */
                },
                success: function (){
                    Swal.fire(
                        'Statut',
                        'Devis validé avec succès.',
                        'success'
                    )

                    //setInterval('location.reload()', 1000);
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            });
        });
        /******* Changement Statut *******/

        $(".deleteData").click(function(){
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            /* alert(id, token) */

            Swal.fire({
                title: 'Etes vous sûr ?',
                text: "Voulez-vous vraiment annuler cet encaissement ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Supprimer !'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url : "{{ url('api/annulation-details-encaissement') . '/' }}" + id,
                        type: 'POST',
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function (){
                            Swal.fire(
                                'annulation !',
                                "Ligne d'encaissement annulé avec succès !",
                                'success'
                            );
                            setInterval('location.reload()', 2000);
                        }
                    });
                }
            })

        });
        
        $(".editData").click(function(){
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            alert(id, token)

            $.ajax({
                url: "{{ url('api/details-encaissement') }}" + "/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(row){
                    $('#modal-form-view-detail-encaissement').modal('show');
                    $('.modal-title-show').text('Visualisation Détails Encaissement');

                    $('#dv_id').val(row.data.id);
                    $('#dv_mode_encaissement').val(row.data.mode_encaissement);
                    $('#dv_ref_encaissement').val(row.data.ref_encaissement);
                    $('#dv_lieu_encaissement').val(row.data.lieu_encaissement);
                    $('#dv_montant').val(row.data.montant);
                    $('#dv_created_at').val(row.data.created_at);
                    $('#dv_etat').val(row.data.etat);

                    /* if (row.data.etat==1) {
                        $('#dv_etat').val('active');
                    } else {
                        $('#dv_etat').val('annulée');
                    } */

                    $('#dv_caissier').val(row.data.name);
                },
                error: function(){
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true
                    });
                    Toast.fire({
                        icon: 'error',
                        title: 'Quelque chose ne va pas : (Code '+data.status+')'
                    });
                }
            });

        });
        

        /******* Changement Etat *******/
        $("#dv_etat").change(function(){
            var id = $("#dv_id").val();
            var token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url : "{{ url('api/annulation-details-encaissement') . '/' }}" + id,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (){
                    Swal.fire(
                        'annulation !',
                        "Ligne d'encaissement annulé avec succès !",
                        'success'
                    );
                    setInterval('location.reload()', 2000);
                }
            });
        });
        /******* Changement Etat *******/

        
        $('#dv_montant').on('blur', function () {
            let montant = $(this).val();
            let id = $("#dv_id").val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: '{{ url('api/edit-montant-into-details-encaissement') }}' + "/" + id,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                    "montant": montant,
                },
                success: function (){
                    Swal.fire(
                        'Modification',
                        'Montant encaissement modifié avec succès.',
                        'success'
                    )

                    setInterval('location.reload()', 8000);
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            })

        });
            
        
        $('#dv_ref_encaissement').on('blur', function () {
            let reference = $(this).val();
            let id = $("#dv_id").val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: '{{ url('api/edit-reference-into-details-encaissement') }}' + "/" + id,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                    "reference": reference,
                },
                success: function (){
                    Swal.fire(
                        'Modification',
                        'Référence encaissement modifiée avec succès.',
                        'success'
                    )

                    setInterval('location.reload()', 8000);
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            })

        });
        
        /* Nouvel Encaissement */
        
        function addForm() {
            save_method = 'add';
            $('input[name_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text("Nouvel encaissement");
            $('#insertbtn').text(' Enregistrer');
        }

        let isSubmitting = false;
        $('#formulaire').submit(function (e) {
            e.preventDefault();
            /* var encaissement = parseNumberInput(document.getElementById('encaissement')); */
            var encaissement = $("#encaissement").val();
            var restant = $("#restant").val();

            if (encaissement > {{ $production-$encaissements->sum('montant') }}) {
                Swal.fire(
                    'Attention !',
                    "Le montant de l'encaissement ne doit pas dépasser le restant (" + '{{ number_format($production-$encaissements->sum('montant'), 0, ',', '.') }}' + " FCFA).",
                    'danger'
                )
                
                $('#insertbtn').attr('disabled', true);
                $('#encaissement').focus();
            } 
            else {
                $('#insertbtn').html(' En cours...');
                
                /* const $submitButton = $(this).find('button[type="submit"]');
                $submitButton.prop('disabled', true).text('Submitting...'); */
                if (isSubmitting) {
                    return; // Prevent multiple submissions
                }
                isSubmitting = true;

                let formData = new FormData(this);
                
                var id = $('#encaissement_id').val();
                url = "{{ url('api/ajout-encaissement-into-details-encaissement') . '/' }}" + id;

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        $('#insertbtn').html('Enregistrement');
                        $('#formulaire').trigger("reset");
                        $('#modal-form').modal('hide');
                        
                        setInterval('location.reload()', 8000);
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
            }

        });

        /* Nouvel Encaissement */
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-number/2.1.6/jquery.number.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>

    <script>

        /**************** Details Facture ************************/

        $(function () {
            /* $("#encaissement").keyup(function() {
                
            }); */

            $('#encaissement').on('blur', function () {
                var encaissement = $("#encaissement").val();
                var restant = $("#restant").val();
                
                if (encaissement == "" || encaissement == 0) {
                    encaissement = 0;
                    /* $('#restant').val(restant-encaissement); */
                    $('#encaissement').focus();
                    $('#insertbtn').attr('disabled', true);
                } else if (encaissement < 0) {
                    Swal.fire(
                        'Attention !',
                        "Le montant de l'encaissement ne doit pas être négatif",
                        'warning'
                    )
                    $("#encaissement").val(0);
                    $('#encaissement').focus();
                    /* $('#restant').val(restant); */
                    $('#insertbtn').attr('disabled', true);
                } else {
                    /* $('#restant').val(restant-encaissement); */
                    $('#insertbtn').attr('disabled', false);
                }

            });
        });
    </script>

@endpush