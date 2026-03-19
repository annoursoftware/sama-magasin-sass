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

            $prestation = DB::table('prestations as p')
                ->join('clients as cli', 'cli.id', 'p.client_id')
                ->join('users as u', 'u.id', 'p.user_id')
                ->select(
                    'p.id',
                    'p.code_prestation',
                    'p.etat',
                    'p.montant',
                    'p.remise',
                    'p.created_at',
                    'u.name',
                    'cli.client',
                    'cli.adresse',
                    'cli.telephone as telephone_primaire',
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
                        <h1>Prestations</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dev.dashboard') }}">Tableau de bord</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.prestations.prestations') }}">Prestations</a></li>
                            <li class="breadcrumb-item active">Prestation N°{{ $prestation->code_prestation }}</li>
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
                <div class="row">
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
                                        <a href="{{ route('dev.prestations.prestations') }}"
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
                            <div class="col-lg-12">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Client</h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12 col-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-maroon"><i
                                                            class="fas fa-user-alt"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Client</span>
                                                        <span class="info-box-number text-sm">{{ $prestation->client }}</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->

                                            <div class="col-md-4 col-sm-12 col-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-maroon"><i
                                                            class="fas fa-phone"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Telephone</span>
                                                        <span
                                                            class="info-box-number text-sm">{{ $prestation->telephone_primaire }}</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->

                                            <div class="col-md-4 col-sm-12 col-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-maroon"><i
                                                            class="fas fa-phone"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Adresse</span>
                                                        <span class="info-box-number text-sm">{{ $prestation->adresse }}</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                    </div>

                                    <!-- /.card-body -->
                                </div>
                            </div>

                            <div class="col-lg-12 mt-2">
                                <div class="card card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Tâches</h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <table
                                                class="table table-striped table-bordered table-condensed table-hover text-sm mt-1"
                                                id="details">
                                                <thead style="background-color:rgb(243, 64, 118)">
                                                    <tr class="text-white">
                                                        {{-- <th class="text-center" width="14%">#</th> --}}
                                                        <th width="45%">Activité</th>
                                                        <th class="text-center">Montant</th>
                                                        <th class="text-center">Sous total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0; ?>
                                                    @foreach ($taches as $t)
                                                        <?php $i++; ?>
                                                        <tr>
                                                            {{-- <td>{{ $i }}</td> --}}
                                                            <td>{{ $t->activite }}</td>
                                                            <td class="text-center">
                                                                {{ number_format($t->montant, 0, ',', '.') }} FCFA
                                                            </td>
                                                            <td class="text-center">
                                                                {{ number_format($t->montant/*  * $v->quantite */, 0, ',', '.') }}
                                                                FCFA
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-number/2.1.6/jquery.number.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
@endpush
