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
        $clients = DB::table('clients')->get();

        $prestation = DB::table('prestations as p')
            ->join('clients as cli', 'cli.id', 'p.client_id')
            ->join('users as u', 'u.id', 'p.user_id')
            ->select(
                'p.id',
                'p.code_prestation',
                'p.status_prestation',
                'p.etat',
                'p.montant',
                'p.remise',
                'p.client_id',
                'p.created_at',
                'u.name',
                'cli.client',
                'cli.adresse',
                'cli.telephone',
            )
            ->where('p.id', /* $id */ 4)
            ->first();

        $taches = DB::table('taches as t')
            ->join('prestations as p', 'p.id', 't.prestation_id')
            ->join('activites as a', 'a.id', 't.activite_id')
            ->select('t.*', 'a.activite')
            ->where('p.id', /* $id */ 4)
            ->get();

        $nbre = DB::table('taches')->where('prestation_id', /* $id */ 4)->count();

        $montant = DB::table('taches')->where('prestation_id', /* $id */ 4)->sum('montant');
        $mt_remise = $montant * ($prestation->remise / 100);

        $encaissement = DB::table('prestations as p')
            ->join('encaissements as E', 'E.prestation_id', 'p.id')
            ->join('detail_encaissements as DE', 'DE.encaissement_id', 'E.id')
            ->where('p.id', /* $id */ 4)
            ->sum('DE.montant');
    @endphp

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Administration de prestation</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dev.dashboard') }}">Tableau de bord</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.prestations.prestations') }}">Prestations</a></li>
                            <li class="breadcrumb-item active">Prestation N°{{ $prestation->code_prestation }}</li>
                        </ol>
                    </div>
                </div>
                <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container">
                <div class="row">

                    <input type="hidden" value="{{ $prestation->id }}" name="id" id="id">

                    <div class="col-lg-4 col-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Prestation</h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-maroon"><i
                                                            class="bi bi-cart-plus-fill"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Prestation N° {{ $prestation->code_prestation }}</span>
                                                        <span class="info-box-number text-sm">Prestation
                                                            [{{ $prestation->montant == $encaissement ? ' soldée' : ' non soldée' }}
                                                            &
                                                            {{ $prestation->etat == 1 ? 'active' : 'annulée' }}]</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->
                                            
                                            <div class="col-md-12 col-sm-12 col-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-maroon"><i
                                                            class="bi bi-person"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Gestionnaire</span>
                                                        <span class="info-box-number text-sm">{{ $prestation->name }}</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->

                                            <div class="col-md-12 col-sm-12 col-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-maroon"><i
                                                            class="bi bi-calendar3"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Date</span>
                                                        <span
                                                            class="info-box-number text-sm">{{ \Carbon\Carbon::parse($prestation->created_at)->format('d/m/Y à H:i:s') }}</span>
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
                                        {{-- @if (Request::is('admin/*'))
                                        <a href="{{ route('admin.vente.ventes') }}" class="btn btn-primary float-left">
                                            <i class="fas fa-home"></i> Retour
                                        </a>
                                        @elseif (Request::is('dev/*'))
                                        <a href="{{ route('dev.vente.ventes') }}" class="btn btn-primary float-left">
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
                                        @endif --}}
                                        <a href="{{ route('admin.prestations.prestations') }}"
                                            class="btn btn-primary float-left">
                                            <i class="fas fa-home"></i> Retour
                                        </a>
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
                                                        <span class="info-box-text">Prestation</span>
                                                        <span
                                                            class="info-box-number text-sm">{{ number_format($montant, 0, ',', '.') }}
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
                                                        <span class="info-box-text">Remise ({{ $prestation->remise }}%)</span>
                                                        <span
                                                            class="info-box-number text-sm">{{ number_format($mt_remise, 0, ',', '.') }}
                                                            FCFA</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->

                                            {{-- <div class="col-md-4 col-sm-12 col-12">
                                                        <div class="info-box">

                                                            <div class="info-box-content">
                                                                <span class="info-box-text">Produits</span>
                                                                <span class="info-box-number text-sm">{{ $nbre }}</span>
                                                            </div>
                                                            <!-- /.info-box-content -->
                                                        </div>
                                                        <!-- /.info-box -->
                                                    </div> --}}
                                            <!-- /.col -->

                                            <div class="col-md-6 col-sm-12 col-12">
                                                <div class="info-box">

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Encaissements</span>
                                                        <span
                                                            class="info-box-number text-sm">{{ number_format($encaissement, 0, ',', '.') }}
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
                                                            class="info-box-number text-sm">{{ number_format($montant - $mt_remise - $encaissement, 0, ',', '.') }}
                                                            FCFA</span>
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
                        </div>
                    </div>

                    <div class="col-lg-8 col-12">
                        <div class="row">
                            <div class="col-lg-4 col-6">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Etat Prestation</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            @if ($prestation->etat == 0)
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
                                                        <label for="status_vente">Etat</label>
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
                                        <h3 class="card-title">Statut Prestation</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            @if ($prestation->status_prestation == 'f')
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
                                        <h3 class="card-title">Remise de la prestation</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="remise">Remise (%)</label>
                                                    <input type="text" class="form-control rounded-0" id="remise" value="{{ $prestation->remise }}" />
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
                                                            @if ($cli->id == $prestation->client_id)
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
                                                    <input type="text" class="form-control rounded-0" id="telephone" value="{{ $prestation->telephone }}" readonly />
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="adresse">Adresse</label>
                                                    <input type="text" class="form-control rounded-0" id="adresse" value="{{ $prestation->adresse }}" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12 mt-2">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Tâches</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    
                                    <div class="card-body">
                                        
                                        <div class="row mb-2">
                                            <div class="col-md-12 col-sm-12 col-12 d-flex">
                                                <button type="button" class="btn btn-flat btn-primary ml-auto" onclick="addForm()">
                                                    <i class="bi bi-plus-lg"></i> Ajouter une activité
                                                </button>
                                            </div>
                                            
                                            <div class="col-md-12 col-12 mt-2">
                                                <div class="table-responsive">
                                                    <table
                                                        class="table table-striped table-bordered table-condensed table-hover text-sm mt-1">
                                                        <thead style="background-color:rgb(243, 64, 118)">
                                                            <tr class="text-white">
                                                                <th class="text-center" width="14%">#</th>
                                                                <th width="45%">Activité</th>
                                                                <th class="text-center">Montant</th>
                                                                <th class="text-center">Sous total</th>
                                                            </tr>
                                                        </thead>
                                                        
                                                        <tbody>
                                                            <?php $i = 0 ?>
                                                            @foreach($taches as $t)
                                                            <?php $i++ ?>
                                                                <tr class="text-xs">
                                                                    @if ($prestation->etat==1)
                                                                        @if ($t->etat==1)
                                                                            <td class="text-center">
                                                                                <button type="button" class="btn btn-outline-danger btn-sm deleteData" data-id="{{ $t->id }}">
                                                                                    <span class="bi bi-trash3-fill" aria-hidden="true"></span>
                                                                                </button>
                                                                                /
                                                                                <button type="button" class="btn btn-outline-primary btn-sm editData" data-id="{{ $t->id }}">
                                                                                    <span class="bi bi-pencil-fill" aria-hidden="true"></span>
                                                                                </button>
                                                                            </td>
                                                                        @else
                                                                            <td class="text-center">
                                                                                <button type="button" class="btn btn-outline-primary btn-sm editData" data-id="{{ $t->id }}">
                                                                                    <span class="bi bi-pencil-fill" aria-hidden="true"></span>
                                                                                </button>
                                                                            </td>
                                                                        @endif
                                                                    @else
                                                                        <td class="text-center">{{ $i }}</td>
                                                                    @endif
        

                                                                    @if ($prestation->etat==1)    
                                                                        @if ($t->etat==1)
                                                                            <td>{{ $t->activite }}</td>
                                                                            <td class="text-center">{{number_format($t->montant, 0, ",",".")}} FCFA</td>
                                                                            <td class="text-center">{{number_format($t->montant, 0, ",",".")}} FCFA</td>
                                                                        @else
                                                                            <td><strike>{{ $t->activite }}</strike</td>
                                                                            <td class="text-center"><strike>{{number_format($t->montant, 0, ",",".")}} FCFA</strike</td>
                                                                            <td class="text-center"><strike>{{number_format($t->montant, 0, ",",".")}} FCFA</strike</td>
                                                                        @endif
                                                                    @else
                                                                        <td><strike>{{ $t->activite }}</strike</td>
                                                                        <td class="text-center"><strike>{{number_format($t->montant, 0, ",",".")}} FCFA</strike</td>
                                                                        <td class="text-center"><strike>{{number_format($t->montant, 0, ",",".")}} FCFA</strike</td>
                                                                    @endif
        
                                                                </tr>
                                                                @include('back.prestations.edit-activite-tache')
                                                            @endforeach
                                                        </tbody>
        
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        @include('back.prestations.form')
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

        $('#article').on('change', function (e) {
            console.log(e);
            var article = $('#article').val()/* e.target.value */;
            $.get('/api/json-infos-activite?id=' + article, function (data) {
                console.log(data);
                $('#pmontant').val(data.montant);
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
                url : "{{ url('api/modification-client-prestation') . '/' }}" + id,
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
                url : "{{ url('api/modification-etat-prestation') . '/' }}" + id,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                    "etat": etat,
                },
                success: function (){
                    Swal.fire(
                        'Prestation',
                        'Etat prestation modifié avec succès.',
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
        
        
        /******* Changement Statut *******/
        $("#status_prestation").change(function(){
            var id = $("#id").val();
            var token = $("meta[name='csrf-token']").attr("content");
            /* var status_prestation = $('#status_prestation').val(); */
            /* alert(id, client) */
            $.ajax(
            {
                url : "{{ url('api/modification-statut-prestation') . '/' }}" + id,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                    /* "etat": etat, */
                },
                success: function (){
                    Swal.fire(
                        'Prestation',
                        'Prestation validée avec succès.',
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
                text: "Voulez-vous vraiment annuler cette activité ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Supprimer !'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url : "{{ url('api/annulation-activite-into-taches') . '/' }}" + id,
                        type: 'POST',
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function (){
                            Swal.fire(
                                'annulation !',
                                'Activité annulée des tâches.',
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
                url: "{{ url('api/details-activite-into-taches') }}" + "/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(row){
                    $('#modal-form-view-activite-into-tache').modal('show');
                    $('.modal-title-show').text('Visualisation Tâches');

                    $('#dv_id').val(row.data.id);
                    $('#dv_article_id').val(row.data.activite_id);
                    $('#dv_montant').val(row.data.montant);

                    if (row.data.etat==1) {
                        $('#dv_etat').val('active');
                    } else {
                        $('#dv_etat').val('annulée');
                    }

                    $('#montant_minimal').val(row.data.montant_minimal_prestation);
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
            let montant_minimal = $("#montant_minimal_prestation").val();
            let token = $("meta[name='csrf-token']").attr("content");
            
            /* var montant = $("#dv_montant"); */
            /* alert("Min : "+prix_vente_minimal+ "Montant actuel : "+montant); */

            if (montant < montant_minimal) {
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
                    url: '{{ url('api/edit-montant-into-taches') }}' + "/" + id,
                    type: 'POST',
                    data: {
                        "id": id,
                        "_token": token,
                        "montant": montant,
                    },
                    success: function (){
                        Swal.fire(
                            'Modification',
                            'Montant activité modifié avec succès.',
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
            $('.modal-title').text("Ajout d'activités dans le détail");
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

        function ajouter_une_ligne()
        {
            var idproduit = $("#activite").val();
            var produit = $("#activite option:selected").text();

            var montant_init = Number($("#pmontant").val());
            var montant_negocie = Number($("#pchmontant").val());
            var remise = Number($("#remise").val());

            // Initialize an empty array to store the items
            let articleArray = [];

            /* Nouvelle configuration */
            if(idproduit != "")
            {
                if (montant_negocie=="" || montant_negocie==0) {

                    montant = montant_init;

                    subtotal[cont] = (montant*1);
                    total=total+subtotal[cont];
                    var nouvelle_ligne = '<tr class="selected" id="nouvelle_ligne'+cont+'"><td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="supprimer_ligne('+cont+');"><span class="fas fa-trash-alt" aria-hidden="true"></span></button></td> <td><input type="hidden" name="id_produit[]" value="'+idproduit+'">'+produit+' </td> <td class="text-center"><input type="hidden" class="form-control" name="montant[]" value="'+montant+'" />'+montant+'</td> <td class="text-center">'+subtotal[cont]+'</td> </tr>';
                    cont++;
                    initialiser();
                    $("#total").html(total);
                    evaluer();
                    $("#details").append(nouvelle_ligne);
                    $("#sous_total").val(total);
                    $("#a_payer").val(total);
                } 
                else {
                    if (montant_negocie < montant_init) {
                        Swal.fire(
                            'Erreurs dans la saisie !',
                            'Le montant SAISI doit être superieur ou egal au montant minimum',
                            'error'
                        )
                    } else {
                        montant = montant_negocie;

                        subtotal[cont] = (montant*1);
                        total=total+subtotal[cont];

                        var nouvelle_ligne = '<tr class="selected" id="nouvelle_ligne'+cont+'"><td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="supprimer_ligne('+cont+');"><span class="fas fa-trash-alt" aria-hidden="true"></span></button></td> <td><input type="hidden" name="id_produit[]" value="'+idproduit+'">'+produit+' </td> <td class="text-center"><input type="hidden" class="form-control" name="montant[]" value="'+montant+'" />'+montant+'</td> <td class="text-center">'+subtotal[cont]+'</td> </tr>';
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
            else
            {
                Swal.fire(
                    'Attention !',
                    'Choisissez une activité',
                    'warning'
                )
            }
            /* Nouvelle configuration */
        }


        /********* 1.) Initialisation de la qte, du prix d'achat et du prix de vente à nulle **************/
        function initialiser() {
            /* $("#pidproduit").val(""); */
            $('#activite').val("").trigger('change');
            $('#activite').val("");
            
            $("#pmontant").val(0);
            $("#pchmontant").val(0);
            /* $("#pquantite").val(0); */

            $("#remise").val('');
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

        function supprimer_ligne(index)
        {
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

        $(function () {
            $("#remise").keyup(function () {
                sous_total = $("#sous_total").val();
                remise = $("#remise").val();

                if (remise == "" || remise == 0) {
                    $("#total_def").html(sous_total);
                    $("#total_def_val").val(sous_total);

                    $("#montant_remise").html(sous_total);
                } else if (remise < 0) {
                    Swal.fire(
                        'Attention !',
                        'La remise ne doit pas être négative',
                        'danger'
                    )
                    $("#remise").val(0);
                    $("#total_def").html(sous_total);
                    $("#total_def_val").val(sous_total);

                    $("#montant_remise").html(sous_total);
                } else {
                    $("#total_def").html(sous_total - (sous_total * (remise / 100)));
                    $("#total_def_val").val(sous_total - (sous_total * (remise / 100)));

                    $("#montant_remise").html(sous_total * (remise / 100));
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
        });

        let isSubmitting = false;

        var id = $("#id").val();
        
        $('#vente').submit(function (e) {
            alert(id)
            e.preventDefault();
            $('#savebtn').html(' En cours...');

            /* const $submitButton = $(this).find('button[type="submit"]');
            $submitButton.prop('disabled', true).text('Submitting...'); */
            if (isSubmitting) {
                return; // Prevent multiple submissions
            }
            isSubmitting = true;

            let formData = new FormData(this);

            url = "{{ url('api/ajout-activites-into-taches') . '/' }}" + id,

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    $('#savebtn').html('Enregistrement');
                    /* $('#vente').trigger("reset"); */

                    /* $('#vente')[0].reset();
                    var url = window.location.origin + '/admin/transactions/ventes/';
                    window.open(url, '_self'); */

                    Toast.fire({
                        icon: 'success',
                        title: 'Activités enregistrées avec succès !'
                    });
                },
                error: function (response) {
                    $('#vente').find(".print-error-msg").find("ul").html('');
                    $('#vente').find(".print-error-msg").css('display', 'block');
                    $.each(response.responseJSON.errors, function (key, value) {
                        $('#vente').find(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                    });
                },
                complete: function () {
                    isSubmitting = false; // Reset the flag
                }
            });
        });

    </script>
@endpush