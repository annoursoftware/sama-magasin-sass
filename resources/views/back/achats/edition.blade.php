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
        $fournisseurs = DB::table('fournisseurs')->get();

        $achat = DB::table('achats as a')
                ->join('fournisseurs as f', 'f.id', 'a.fournisseur_id')
                ->join('users as u', 'u.id', 'a.user_id')
                ->select(
                    'a.*',
                    'u.name',
                    'f.fournisseur',
                    'f.adresse',
                    'f.telephone',
                )
                ->where('a.id', /* $id */ 4)
                ->first();

        $achats = DB::table('detail_achats as da')
            ->join('achats as a', 'a.id', 'da.achat_id')
            ->join('articles as art', 'art.id', 'da.article_id')
            ->select('da.*', 'art.article')
            ->where('a.id', /* $id */ 4)
            ->get();

        $nbre = DB::table('detail_achats')->where('achat_id', /* $id */ 4)->count();

        $montant = DB::table('detail_achats')->where('achat_id', /* $id */ 4)->sum(DB::raw('montant*quantite'));
        $mt_remise = $montant * ($achat->remise / 100);

        $decaissement = DB::table('achats as a')
            ->join('decaissements as d', 'd.achat_id', 'a.id')
            ->join('detail_decaissements as dd', 'dd.decaissement_id', 'd.id')
            ->where('a.id', /* $id */ 4)
            ->sum('dd.montant');
    @endphp

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Administration d'achat</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dev.dashboard') }}">Tableau de bord</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.transactions.ventes') }}">Achats</a></li>
                            <li class="breadcrumb-item active">Achat N°{{ $achat->num_achat }}</li>
                        </ol>
                    </div>
                </div>
                <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container">
                <div class="row">

                    <input type="hidden" value="{{ $achat->id }}" name="id" id="id">

                    <div class="col-lg-4 col-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Achat</h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-maroon"><i
                                                            class="bi bi-cart-plus-fill"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Achat N° {{ $achat->num_achat }}</span>
                                                        <span class="info-box-number text-sm">Achat
                                                            [{{ $achat->montant == $decaissement ? ' soldé' : ' non soldé' }}
                                                            &
                                                            {{ $achat->etat == 1 ? 'actif' : 'annulé' }}]</span>
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
                                                        <span class="info-box-number text-sm">{{ $achat->name }}</span>
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
                                                            class="info-box-number text-sm">{{\Carbon\Carbon::parse($achat->created_at)->format('d/m/Y à H:i:s')}}</span>
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
                                        <a href="{{ route('admin.depenses.achats.achats') }}"
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
                                                        <span class="info-box-text">Achat</span>
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
                                                        <span class="info-box-text">Remise ({{ $achat->remise }}%)</span>
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
                                                        <span class="info-box-text">Décaissements</span>
                                                        <span
                                                            class="info-box-number text-sm">{{ number_format($decaissement, 0, ',', '.') }}
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
                                                            class="info-box-number text-sm">{{ number_format($montant - $mt_remise - $decaissement, 0, ',', '.') }}
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
                                        <h3 class="card-title">Etat Achat</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            @if ($achat->etat == 0)
                                                <div class="col-md-12 col-sm-12 col-12">
                                                    <div class="info-box">
                                                        {{-- <span class="info-box-icon bg-maroon"><i class="bi bi-person"></i></span> --}}

                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Etat</span>
                                                            <span class="info-box-number text-sm">Achat annulé</span>
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
                                        <h3 class="card-title">Statut Achat</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            @if ($achat->status_achat == 'f')
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
                                                        <label for="status_achat">Statut</label>
                                                        <select id="status_achat" name="status_achat" class="custom-select">
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
                                        <h3 class="card-title">Remise de l'achat</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="remise">Remise (%)</label>
                                                    <input type="text" class="form-control rounded-0" id="remise" value="{{ $achat->remise }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-6">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Fournisseurs</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="fournisseur">Fournisseur</label>
                                                    <select id="fournisseur" name="fournisseur" class="custom-select" required>
                                                        <option value="">****** Choix ******</option>
                                                        @foreach ($fournisseurs as $f)
                                                            @if ($f->id == $achat->fournisseur_id)
                                                                <option value="{{ $f->id }}" selected>{{ $f->fournisseur }}</option>
                                                            @else
                                                                <option value="{{ $f->id }}">{{ $f->fournisseur }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="telephone">Téléphone</label>
                                                    <input type="text" class="form-control rounded-0" id="telephone" value="{{ $achat->telephone }}" readonly />
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="adresse">Adresse</label>
                                                    <input type="text" class="form-control rounded-0" id="adresse" value="{{ $achat->adresse }}" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-2">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Details Achat</h3>
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
                                                    <table
                                                        class="table table-striped table-bordered table-condensed table-hover text-sm mt-1">
                                                        <thead style="background-color:rgb(243, 64, 118)">
                                                            <tr class="text-white">
                                                                <th class="text-center" width="15%">#</th>
                                                                <th>Article</th>
                                                                <th class="text-center" width="15%">Montant</th>
                                                                <th class="text-center" width="5%">Quantité</th>
                                                                <th class="text-center" width="5%">Livraison</th>
                                                                <th class="text-center" width="13%">Sous total</th>
                                                            </tr>
                                                        </thead>
                                                        
                                                        <tbody>
                                                            <?php $i = 0 ?>
                                                            @foreach($achats as $a)
                                                            <?php $i++ ?>
                                                                <tr class="text-xs">
                                                                    @if ($achat->etat==1)
                                                                        @if ($a->etat==1)
                                                                            @if ($a->quantite==$a->livraison)
                                                                                <td class="text-center">
                                                                                    <button type="button" class="btn btn-outline-warning btn-sm deleteData" data-id="{{ $a->id }}">
                                                                                        <span class="bi bi-eye" aria-hidden="true"></span>
                                                                                    </button>
                                                                                </td>
                                                                            @else
                                                                                <td class="text-center">
                                                                                    <button type="button" class="btn btn-outline-danger btn-sm deleteData" data-id="{{ $a->id }}">
                                                                                        <span class="bi bi-trash3-fill" aria-hidden="true"></span>
                                                                                    </button>
                                                                                    /
                                                                                    <button type="button" class="btn btn-outline-primary btn-sm editData" data-id="{{ $a->id }}">
                                                                                        <span class="bi bi-pencil-fill" aria-hidden="true"></span>
                                                                                    </button>
                                                                                </td>
                                                                            @endif
                                                                            {{-- <td class="text-center">
                                                                                <button type="button" class="btn btn-outline-danger btn-sm deleteData" data-id="{{ $a->id }}">
                                                                                    <span class="bi bi-trash3-fill" aria-hidden="true"></span>
                                                                                </button>
                                                                                /
                                                                                <button type="button" class="btn btn-outline-primary btn-sm editData" data-id="{{ $a->id }}">
                                                                                    <span class="bi bi-pencil-fill" aria-hidden="true"></span>
                                                                                </button>
                                                                            </td> --}}
                                                                        @else
                                                                            <td class="text-center">
                                                                                <button type="button" class="btn btn-outline-primary btn-sm editData" data-id="{{ $a->id }}">
                                                                                    <span class="bi bi-pencil-fill" aria-hidden="true"></span>
                                                                                </button>
                                                                            </td>
                                                                        @endif
                                                                    @else
                                                                        <td class="text-center">{{ $i }}</td>
                                                                    @endif
        

                                                                    @if ($achat->etat==1)    
                                                                        @if ($a->etat==1)
                                                                            <td>{{ $a->article }}</td>
                                                                            <td class="text-center">{{number_format($a->montant, 0, ",",".")}} FCFA</td>
                                                                            <td class="text-center">{{ $a->quantite }}</td>
                                                                            <td class="text-center">{{ $a->livraison }}</td>
                                                                            <td class="text-center">{{number_format($a->montant*$a->quantite, 0, ",",".")}} FCFA</td>
                                                                        @else
                                                                            <td><strike>{{ $a->article }}</strike</td>
                                                                            <td class="text-center"><strike>{{number_format($a->montant, 0, ",",".")}} FCFA</strike</td>
                                                                            <td class="text-center"><strike>{{ $a->quantite }}</strike</td>
                                                                            <td class="text-center"><strike>{{ $a->livraison }}</strike</td>
                                                                            <td class="text-center"><strike>{{number_format($a->montant*$a->quantite, 0, ",",".")}} FCFA</strike</td>
                                                                        @endif
                                                                    @else
                                                                        <td><strike>{{ $a->article }}</strike</td>
                                                                        <td class="text-center"><strike>{{number_format($a->montant, 0, ",",".")}} FCFA</strike</td>
                                                                        <td class="text-center"><strike>{{ $a->quantite }}</strike</td>
                                                                        <td class="text-center"><strike>{{ $a->livraison }}</strike</td>
                                                                        <td class="text-center"><strike>{{number_format($a->montant*$a->quantite, 0, ",",".")}} FCFA</strike</td>
                                                                    @endif
        
                                                                </tr>
                                                                @include('back.achats.edit-article-detail-achat')
                                                            @endforeach
                                                        </tbody>
        
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        @include('back.achats.form')
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
        $("#fournisseur").change(function(){
            var id = $("#id").val();
            var token = $("meta[name='csrf-token']").attr("content");
            var fournisseur = $('#fournisseur').val();
            
            /* load infos client */
            $.get('/api/json-infos-fournisseur?id=' + fournisseur,function(data) {
                console.log(data);
                $('#telephone').val(data.telephone);
                $('#adresse').val(data.adresse);
            });
            /* load infos client */
            
            /* modification client */
            $.ajax({
                url : "{{ url('api/modification-fournisseur-achat') . '/' }}" + id,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                    "fournisseur": fournisseur,
                },
                success: function (){
                    Swal.fire(
                        'Fournisseur',
                        'Fournisseur modifié avec succès.',
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
                url : "{{ url('api/modification-etat-achat') . '/' }}" + id,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                    "etat": etat,
                },
                success: function (){
                    Swal.fire(
                        'Location',
                        'Etat achat modifié avec succès.',
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
                url: '{{ url('api/actualisation-remise-achat') }}' + "/" + id,
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
        $("#status_achat").change(function(){
            var id = $("#id").val();
            var token = $("meta[name='csrf-token']").attr("content");
            var status_achat = $('#status_achat').val();
            /* alert(id, client) */
            $.ajax(
            {
                url : "{{ url('api/modification-statut-achat') . '/' }}" + id,
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
                        url : "{{ url('api/annulation-article-into-details-achat') . '/' }}" + id,
                        type: 'POST',
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function (){
                            Swal.fire(
                                'annulation !',
                                "Article annulé du detail de l'achat .",
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
                url: "{{ url('api/details-article-into-details-achat') }}" + "/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(row){
                    $('#modal-form-view-article-into-dv').modal('show');
                    $('.modal-title-show').text('Visualisation Détail Achat');

                    $('#dv_id').val(row.data.id);
                    $('#dv_article').val(row.data.article);
                    $('#dv_montant').val(row.data.montant);
                    $('#dv_quantite').val(row.data.quantite);
                    $('#dv_livre').val(row.data.livraison);
                    $('#dv_restant').val(row.data.quantite-row.data.livraison);

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
            let token = $("meta[name='csrf-token']").attr("content");
            
            $.ajax({
                url: '{{ url('api/edit-montant-into-details-achat') }}' + "/" + id,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                    "montant": montant,
                },
                success: function (){
                    Swal.fire(
                        'Mise à jour',
                        "Montant mise à jour avec succès !",
                        'success'
                    )

                    setInterval('location.reload()', 8000);
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            })

        });
            
        
        $('#dv_quantite').on('blur', function () {
            let quantite = $(this).val();
            let id = $("#dv_id").val();
            let token = $("meta[name='csrf-token']").attr("content");
            
            $.ajax({
                url: '{{ url('api/edit-quantite-into-details-achat') }}' + "/" + id,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                    "quantite": quantite,
                },
                success: function (){
                    Swal.fire(
                        'Mise à jour',
                        'Quantité achetée mise à jour avec succès.',
                        'success'
                    )

                    setInterval('location.reload()', 8000);
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            })

        });
        
        /* Gestion de la livraison */
        $("#dv_livraison").keyup(function() {
            let livraison = $(this).val();
            let quantite = $("#dv_quantite").val();
            let livree = $("#dv_livre").val();
            let restant = $("#dv_restant").val();
            
            let n_quantite = Number(quantite);
            let n_livree = Number(livree);
            let n_livraison = Number(livraison);
            
            /* A voire */
            let previousValue;

            $('#dv_livre').on('focus', function() {
                // Store the current value when the input gains focus
                previousValue = $(this).val();
            });

            $('#dv_livre').on('change', function() {
                // Access the previous value stored during focus
                console.log('Previous Value:', previousValue);
                console.log('New Value:', $(this).val());
            });
            /* A voire */
            
            if (n_livraison<0) {
                Swal.fire(
                    'Livraison',
                    'Quantité à livrer ne peut pas être négative.',
                    'danger'
                )
            } else if(n_livraison==0) {
                Swal.fire(
                    'Livraison',
                    'Quantité à livrer ne peut pas être egale à 0.',
                    'danger'
                )
            } else if(n_livraison=="") {
                Swal.fire(
                    'Livraison',
                    'La Quantité à livrer ne peut pas être vide',
                    'danger'
                )
            } else {
                if (n_livraison<=restant) {
                    $("#dv_livre").val(n_livraison+n_livree);
                    $("#dv_restant").val(n_quantite-n_livree);
                } else {
                    Swal.fire(
                        'Livraison',
                        'La quantité à livrer ne peut pas être supérieure à la quantité restante !',
                        'warning'
                    )

                    $("#dv_livre").val();
                    $("#dv_restant").val();
                    $("#dv_livraison").focus();
                }

            }
        });

        /* $('#dv_livraison').on('blur', function () {
            let livraison = $(this).val();
            let id = $("#dv_id").val();
            let token = $("meta[name='csrf-token']").attr("content");
            
            $.ajax({
                url: '{{ url('api/edit-livraison-into-details-achat') }}' + "/" + id,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                    "livraison": livraison,
                },
                success: function (){
                    Swal.fire(
                        'Mise à jour',
                        'Quantité livrée mise à jour avec succès.',
                        'success'
                    )

                    setInterval('location.reload()', 8000);
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            })

        }); */
        /* Gestion de la livraison */
        
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
            var remise = Number($("#remise").val());

            // Initialize an empty array to store the items
            let articleArray = [];

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

        function supprimer_ligne(index) {
            total = total - subtotal[index];
            $("#total").html("S/. " + total);
            $("#nouvelle_ligne" + index).remove();
            evaluer();
            $("#sous_total").val(total);

            remise = 0;
            $("#remise").val("");

            $("#total_def").html(total - (total * (remise / 100)));
            $("#total_def_val").val(total - (total * (remise / 100)));

            $("#montant_remise").html(total * (remise / 100));
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

            url = "{{ url('api/ajout-articles-into-details-vente') . '/' }}" + id,

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
                        title: 'Articles enregistrés avec succès !'
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