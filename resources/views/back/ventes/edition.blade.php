@extends('back.master')

@section('title', 'Devis')

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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" />

    <link rel="stylesheet" href="{{ asset('back/plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')

    @php
        
    @endphp

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Administration de vente</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dev.dashboard') }}">Tableau de bord</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dev.transactions.ventes') }}">Ventes</a></li>
                            <li class="breadcrumb-item active">Vente N°{{ $vente->num_vente }}</li>
                        </ol>
                    </div>
                </div>
                <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container">
                <div class="row">

                    <input type="hidden" value="{{ $vente->id }}" name="id" id="id">
                    <input type="hidden" value="{{ $vente->status_vente }}" name="status_vente" id="status_vente">

                    <div class="col-lg-4 col-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Vente</h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-maroon"><i class="bi bi-cart-plus-fill"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Vente N° {{ $vente->num_vente }}</span>
                                                        <span class="info-box-number text-sm">{{-- {{ $vente->status_vente=='f' ? 'Facture' : 'Devis' }} --}}
                                                            @if ($vente->status_vente=='f')
                                                                Facture
                                                                [
                                                                    {{ $vente->montant == $encaissement ? ' soldée' : ' non soldée' }}
                                                                    &
                                                                    {{ $vente->etat == 1 ? 'active' : 'annulée' }}
                                                                ]
                                                            @else
                                                                Devis
                                                            @endif
                                                            
                                                        </span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->

                                            <div class="col-md-12 col-sm-12 col-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-maroon"><i class="bi bi-person"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Gestionnaire</span>
                                                        <span class="info-box-number text-sm">{{ $vente->name }}</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->

                                            <div class="col-md-12 col-sm-12 col-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-maroon"><i class="bi bi-calendar3"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Date</span>
                                                        <span
                                                            class="info-box-number text-sm">{{\Carbon\Carbon::parse($vente->created_at)->format('d/m/Y à H:i:s')}}</span>
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
                                            <a href="{{ route('dev.transactions.ventes') }}" class="btn btn-primary float-left">
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

                            <div class="col-lg-12">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Details Financiers</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 col-12">
                                                <div class="info-box">

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Vente</span>
                                                        <span
                                                            class="info-box-number text-sm">{{number_format(($montant), 0, ",", ".")}}
                                                            FCFA</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->

                                            <div class="col-md-6 col-sm-12 col-12">
                                                <div class="info-box">

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Remise ({{ $vente->remise }}%)</span>
                                                        <span
                                                            class="info-box-number text-sm">{{number_format(($mt_remise), 0, ",", ".")}}
                                                            FCFA</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->

                                            @if ($vente->status_vente == 'f')
                                                <div class="col-md-6 col-sm-12 col-12">
                                                    <div class="info-box">

                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Encaissements</span>
                                                            <span
                                                                class="info-box-number text-sm">{{number_format(($encaissement), 0, ",", ".")}}
                                                                FCFA</span>
                                                        </div>
                                                        <!-- /.info-box-content -->
                                                    </div>
                                                    <!-- /.info-box -->
                                                </div>
                                                <!-- /.col -->

                                                <div class="col-md-6 col-sm-12 col-12">
                                                    <div class="info-box">

                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Restant</span>
                                                            <span
                                                                class="info-box-number text-sm">{{number_format((($montant - $mt_remise) - $encaissement), 0, ",", ".")}}
                                                                FCFA</span>
                                                        </div>
                                                        <!-- /.info-box-content -->
                                                    </div>
                                                    <!-- /.info-box -->
                                                </div>
                                                <!-- /.col -->
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-12">
                        <div class="row">
                            <div class="col-lg-4 col-6">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Etat Vente</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            @if ($vente->etat == 0)
                                                <div class="col-md-12 col-sm-12 col-12">
                                                    <div class="info-box">
                                                        {{-- <span class="info-box-icon bg-maroon"><i class="bi bi-person"></i></span> --}}

                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Etat</span>
                                                            <span class="info-box-number text-sm">Vente annulée</span>
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

                            <div class="col-lg-4 col-6">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Statut Vente</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            @if ($vente->status_vente == 'f')
                                                <div class="col-md-12 col-sm-12 col-12">
                                                    <div class="info-box">
                                                        {{-- <span class="info-box-icon bg-maroon"><i class="bi bi-person"></i></span> --}}

                                                        <div class="info-box-content">
                                                            {{-- <span class="info-box-text">Statut</span> --}}
                                                            <span class="info-box-number text-sm">Facture</span>
                                                        </div>
                                                        <!-- /.info-box-content -->
                                                    </div>
                                                    <!-- /.info-box -->
                                                </div>
                                                <!-- /.col -->
                                            @else
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="status_vente">Statut</label>
                                                        <select id="status_vente" name="status_vente" class="custom-select">
                                                            <option value="">*** Choix ***</option>
                                                            <option value="d" selected>Devis</option>
                                                            <option value="f">Facture</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-6">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Remise de la vente</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="remise">Remise (%)</label>
                                                    <input type="number" class="form-control rounded-0" id="remise" value="{{ $vente->remise }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-6">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Client</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="client">Client</label>
                                                    <select id="client" name="client" class="custom-select" required>
                                                        <option value="">****** Choix ******</option>
                                                        @foreach ($clients as $cli)
                                                            @if ($cli->id == $vente->client_id)
                                                                <option value="{{ $cli->id }}" selected>{{ $cli->client }}</option>
                                                            @else
                                                                <option value="{{ $cli->id }}">{{ $cli->client }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="telephone">Téléphone</label>
                                                    <input type="text" class="form-control rounded-0" id="telephone" value="{{ $vente->telephone }}" readonly />
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="adresse">Adresse</label>
                                                    <input type="text" class="form-control rounded-0" id="adresse" value="{{ $vente->adresse }}" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-2">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Details Vente</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    
                                    <div class="card-body">
                                        
                                        <div class="row mb-2">
                                            <div class="col-md-12 col-sm-12 col-12 d-flex">
                                                <button type="button" class="btn btn-flat btn-primary ml-auto" onclick="addForm()">
                                                    <i class="bi bi-plus-lg"></i> Ajouter un article
                                                </button>
                                            </div>
                                            
                                            <div class="col-md-12 col-12 mt-2">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-condensed table-hover text-sm mt-1">
                                                        <thead style="background-color:rgb(243, 64, 118)">
                                                            <tr class="text-white">
                                                                <th class="text-center" width="14%">#</th>
                                                                <th width="45%">Article</th>
                                                                <th class="text-center">Montant</th>
                                                                <th class="text-center" width="7%">Quantité</th>
                                                                <th class="text-center">Sous total</th>
                                                            </tr>
                                                        </thead>
                                                        
                                                        <tbody>
                                                            <?php $i = 0 ?>
                                                            @foreach($ventes as $v)
                                                            <?php $i++ ?>
                                                                <tr class="text-xs">
                                                                    @if ($vente->etat==1)
                                                                        @if ($v->etat==1)
                                                                            <td class="text-center">
                                                                                <button type="button" class="btn btn-outline-danger btn-sm deleteData" data-id="{{ $v->id }}">
                                                                                    <span class="bi bi-trash3-fill" aria-hidden="true"></span>
                                                                                </button>
                                                                                /
                                                                                <button type="button" class="btn btn-outline-primary btn-sm editData" data-id="{{ $v->id }}">
                                                                                    <span class="bi bi-pencil-fill" aria-hidden="true"></span>
                                                                                </button>
                                                                            </td>
                                                                        @else
                                                                            <td class="text-center">
                                                                                <button type="button" class="btn btn-outline-primary btn-sm editData" data-id="{{ $v->id }}">
                                                                                    <span class="bi bi-pencil-fill" aria-hidden="true"></span>
                                                                                </button>
                                                                            </td>
                                                                        @endif
                                                                    @else
                                                                        <td class="text-center">{{ $i }}</td>
                                                                    @endif
        

                                                                    @if ($vente->etat==1)    
                                                                        @if ($v->etat==1)
                                                                            <td>{{ $v->article }}</td>
                                                                            <td class="text-center">{{number_format($v->montant, 0, ",",".")}} FCFA</td>
                                                                            <td class="text-center">{{ $v->quantite }}</td>
                                                                            <td class="text-center">{{number_format($v->montant*$v->quantite, 0, ",",".")}} FCFA</td>
                                                                        @else
                                                                            <td><strike>{{ $v->article }}</strike</td>
                                                                            <td class="text-center"><strike>{{number_format($v->montant, 0, ",",".")}} FCFA</strike</td>
                                                                            <td class="text-center"><strike>{{ $v->quantite }}</strike</td>
                                                                            <td class="text-center"><strike>{{number_format($v->montant*$v->quantite, 0, ",",".")}} FCFA</strike</td>
                                                                        @endif
                                                                    @else
                                                                        <td><strike>{{ $v->article }}</strike</td>
                                                                        <td class="text-center"><strike>{{number_format($v->montant, 0, ",",".")}} FCFA</strike</td>
                                                                        <td class="text-center"><strike>{{ $v->quantite }}</strike</td>
                                                                        <td class="text-center"><strike>{{number_format($v->montant*$v->quantite, 0, ",",".")}} FCFA</strike</td>
                                                                    @endif
        
                                                                </tr>
                                                                @include('back.ventes.edit-article-detail-vente')
                                                            @endforeach
                                                        </tbody>
        
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        @include('back.ventes.form')
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
        
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 8000,
            timerProgressBar: true,
        });

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

        $('#article').on('change', function (e) {
            console.log(e);
            var article = $('#article').val()/* e.target.value */;
            $.get('/api/json-infos-article?id=' + article, function (data) {
                console.log(data);
                $('#pmontant').val(data.prix_vente_minimal);
                $('#pstock').val(data.stock);

                if (data.image == null) {
                    $('#img-article').attr('src', '{{ asset('no-img.jpg') }}');
                    $('#img-article').attr('width', '50px');
                } else {
                    $('#img-article').attr('src', '{{ asset("upload/Articles/Images") }}' + '/' + data.image);
                    $('#img-article').attr('width', '50px');
                    $('#img-article').attr('heigth', '50px');
                }
            });
        });

        /******* Changement client *******/
        $("#client").change(function(){
            var id = $("#id").val();
            var token = $("meta[name='csrf-token']").attr("content");
            var client = $('#client').val();
            
            /* load infos client */
            $.get('/api/json-infos-client?id=' + client,function(data) {
                console.log(data);
                $('#telephone').val(data.telephone);
                $('#adresse').val(data.adresse);
            });
            /* load infos client */
            
            /* modification client */
            $.ajax({
                url : "{{ url('api/modification-client-vente') . '/' }}" + id,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                    "client": client,
                },
                success: function (){
                    Swal.fire(
                        'Client',
                        'Client modifié avec succès.',
                        'success'
                    )

                    setInterval('location.reload()', 2500);
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            });
            /* modification client */
        });
        /******* Changement client *******/
        
        /******* Changement Etat *******/
        $("#etat").change(function(){
            var id = $("#id").val();
            var token = $("meta[name='csrf-token']").attr("content");
            var etat = $('#etat').val();
            /* alert(id, client) */
            $.ajax(
            {
                url : "{{ url('api/modification-etat-vente') . '/' }}" + id,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                    "etat": etat,
                },
                success: function (){
                    Swal.fire(
                        'Location',
                        'Etat vente modifié avec succès.',
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
                text: "Voulez-vous vraiment annuler cet article ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Supprimer !'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url : "{{ url('api/annulation-article-into-details-vente') . '/' }}" + id,
                        type: 'POST',
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function (){
                            Swal.fire(
                                'annulation !',
                                'Article annulé du detail de la Vente .',
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
                url: "{{ url('api/details-article-into-details-vente') }}" + "/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(row){
                    $('#modal-form-view-article-into-dv').modal('show');
                    $('.modal-title-show').text('Visualisation Détail Vente');

                    $('#dv_id').val(row.data.id);
                    $('#dv_article').val(row.data.article);
                    $('#dv_article_id').val(row.data.article_id);
                    $('#dv_montant').val(row.data.montant);
                    $('#dv_quantite').val(row.data.quantite);

                    if (row.data.etat==1) {
                        $('#dv_etat').val('active');
                    } else {
                        $('#dv_etat').val('annulée');
                    }

                    $('#prix_vente_minimal').val(row.data.prix_vente_minimal);
                    $('#stock').val(row.data.stock);
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
        
        
        $('#dv_montant').on('blur', function () {
            let montant = $(this).val();
            let id = $("#dv_id").val();
            let prix_vente_minimal = $("#prix_vente_minimal").val();
            let token = $("meta[name='csrf-token']").attr("content");
            
            /* var montant = $("#dv_montant"); */
            /* alert("Min : "+prix_vente_minimal+ "Montant actuel : "+montant); */

            if (montant < prix_vente_minimal) {
                Swal.fire(
                    'Modification',
                    'montant saisi inférieur au montant minimum accordé',
                    'warning'
                )

            } else {
                alert("c'est le bon montant")
                Swal.fire(
                    'Modification effective',
                    "c'est le bon montant",
                    'success'
                )
                $.ajax({
                    url: '{{ url('api/edit-montant-into-details-vente') }}' + "/" + id,
                    type: 'POST',
                    data: {
                        "id": id,
                        "_token": token,
                        "montant": montant,
                    },
                    success: function (){
                        Swal.fire(
                            'Modification',
                            'Montant détail vente modifié avec succès.',
                            'success'
                        )

                        setInterval('location.reload()', 8000);
                    },
                    error: function (data, textStatus, errorThrown) {
                        console.log(data);
                    },
                })
            }

        });
            
        
        $('#dv_quantite').on('blur', function () {
            let quantite = $(this).val();
            let id = $("#dv_id").val();
            let stock = $("#stock").val();
            let token = $("meta[name='csrf-token']").attr("content");
            
            /* var montant = $("#dv_montant"); */
            /* alert("Min : "+prix_vente_minimal+ "Montant actuel : "+montant); */

            if (quantite > stock) {
                Swal.fire(
                    'Modification',
                    'Quantité supérieure au stock restant',
                    'warning'
                )

            } else {
                Swal.fire(
                    'Modification effective',
                    "c'est la bonne quantité",
                    'success'
                )
                $.ajax({
                    url: '{{ url('api/edit-quantite-into-details-vente') }}' + "/" + id,
                    type: 'POST',
                    data: {
                        "id": id,
                        "_token": token,
                        "quantite": quantite,
                    },
                    success: function (){
                        Swal.fire(
                            'Modification',
                            'Quantité détail vente modifiée avec succès.',
                            'success'
                        )

                        setInterval('location.reload()', 8000);
                    },
                    error: function (data, textStatus, errorThrown) {
                        console.log(data);
                    },
                })
            }

        });

        function addForm() {
            save_method = 'add';
            $('input[name_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text("Ajout d'article dans le détail");
            $('#savebtn').text(' Enregistrer');
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-number/2.1.6/jquery.number.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>

    <script>

        /**************** Details Facture ************************/

        $(document).ready(function () {
            $("#btn_add").click(function () {
                ajouter_une_ligne();
            });
        });

        var cont = 0;
        total = 0;
        subtotal = [];
        $("#savebtn").hide();

        function ajouter_une_ligne() {
            var idproduit = $("#article").val();
            var produit = $("#article option:selected").text();
            var quantite = Number($("#pquantite").val());
            var stock = Number($("#pstock").val());
            var montant_init = Number($("#pmontant").val());
            var montant_negocie = Number($("#pchmontant").val());
            /* var remise = Number($("#remise").val()); */

            /* Nouvelle configuration */
            if (idproduit != "") {
                if (montant_negocie == "" || montant_negocie == 0) {

                    if (quantite == "" || quantite == 0 || quantite < 0) {
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
                        if (quantite > stock) {
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

                            subtotal[cont] = (montant * quantite);
                            total = total + subtotal[cont];
                            var nouvelle_ligne = '<tr class="selected" id="nouvelle_ligne' + cont + '"><td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="supprimer_ligne(' + cont + ');"><span class="fas fa-trash-alt" aria-hidden="true"></span></button></td> <td><input type="hidden" name="id_produit[]" value="' + idproduit + '">' + produit + ' </td> <td class="text-center"><input type="hidden" class="form-control" name="montant[]" value="' + montant + '" />' + montant + '</td> <td class="text-center"><input type="hidden" class="form-control" name="quantite[]" value="' + quantite + '" />' + quantite + '</td> <td class="text-center">' + subtotal[cont] + '</td> </tr>';
                            cont++;
                            initialiser();
                            $("#total").html(total);
                            evaluer();
                            $("#details").append(nouvelle_ligne);
                            $("#sous_total").val(total);
                            $("#a_payer").val(total);

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
                        if (quantite == "" || quantite == 0 || quantite < 0) {
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
                            if (quantite > stock) {
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

                                subtotal[cont] = (montant * quantite);
                                total = total + subtotal[cont];

                                var nouvelle_ligne = '<tr class="selected" id="nouvelle_ligne' + cont + '"><td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="supprimer_ligne(' + cont + ');"><span class="fas fa-trash-alt" aria-hidden="true"></span></button></td> <td><input type="hidden" name="id_produit[]" value="' + idproduit + '">' + produit + ' </td> <td class="text-center"><input type="hidden" class="form-control" name="montant[]" value="' + montant + '" />' + montant + '</td> <td class="text-center"><input type="hidden" class="form-control" name="quantite[]" value="' + quantite + '" />' + quantite + '</td> <td class="text-center">' + subtotal[cont] + '</td> </tr>';
                                cont++;
                                initialiser();
                                $("#total").html(total);
                                evaluer();
                                $("#details").append(nouvelle_ligne);
                                $("#sous_total").val(total);
                                $("#a_payer").val(total);
                            }
                        }
                    }
                }
            }
            else {
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


        /********* 1.) Initialisation de la qte, du prix d'achat et du prix de vente à nulle **************/
        function initialiser() {
            /* $("#pidproduit").val(""); */
            $('#pidproduit').val("").trigger('change');

            $("#pmontant").val(0);
            $("#pchmontant").val(0);
            $("#pquantite").val(0);
            $("#pstock").val(0);
        }

        /********* 2.) Evaluation du total avant envoie du formulaire **************/
        function evaluer() {
            if (total > 0) {
                $("#savebtn").show();
            }

            else {
                $("#savebtn").hide();
            }
        }

        function supprimer_ligne(index) {
            total = total - subtotal[index];
            $("#total").html("S/. " + total);
            $("#nouvelle_ligne" + index).remove();
            evaluer();
            $("#sous_total").val(total);

            $("#total_def").html(total);
            $("#total_def_val").val(total);
        }
    </script>

    <script>
        
        let isSubmitting = false;
        let id = $("#vente_id").val();
        $('#formulaire').submit(function (e) {
            e.preventDefault();
            $('#savebtn').html(" <i class='fa-solid fa-sync fa-spin'></i>"+" En cours d'enregistrement...");
            
            /* const $submitButton = $(this).find('button[type="submit"]');
            $submitButton.prop('disabled', true).text('Submitting...'); */
            if (isSubmitting) {
                return; // Prevent multiple submissions
            }
            isSubmitting = true;

            /* var url = $(this).attr("action"); */
            let formData = new FormData(this);

            //var id = $('#vente_id').val();
            url = "{{ url('api/ajout-articles-into-details-vente') . '/' }}" + id,
        
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    $('#savebtn').html('Enregistrement');
                    $('#formulaire').trigger("reset");
                    $('#modal-form').modal('hide');
                    /* table.draw(); */
                    //table.ajax.reload();
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
        
    </script>
@endpush