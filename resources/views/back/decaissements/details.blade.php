@extends('back.master')

@section('title', 'Décaissements')

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

        @php
            $query_1 = DB::table('decaissements as d')
                ->join('achats as a', 'a.id', 'd.achat_id')
                ->join('fournisseurs as f', 'f.id', 'a.fournisseur_id')
                ->select(
                    'd.id',
                    'd.num_decaissement',
                    'd.created_at',
                    'a.num_achat as num_production',
                    'a.montant',
                    /* 'a.remise', */
                    'a.created_at as date_etablissement',
                    'f.fournisseur as beneficiaire',
                    'f.telephone',
                    'f.adresse'
                );

            $query_2 = DB::table('decaissements as d')
                ->join('depenses as dep', 'dep.id', 'd.depense_id')
                ->join('beneficiaires as b', 'b.id', 'dep.beneficiaire_id')
                ->select(
                    'd.id',
                    'd.num_decaissement',
                    'd.created_at',
                    'dep.num_depense as num_production',
                    'dep.montant',
                    /* 'dep.remise', */
                    'dep.created_at as date_etablissement',
                    'b.beneficiaire as beneficiaire',
                    'b.telephone',
                    'b.adresse'
                );

            $decaissement = $query_1->union($query_2)
                ->where('d.id', 4)
                ->first();

            $decaissements = DB::table('detail_decaissements as dd')
                ->join('decaissements as d', 'd.id', 'dd.decaissement_id')
                ->join('users as u', 'u.id', 'dd.user_id')
                ->select('dd.id', 'dd.updated_at', 'dd.mode_decaissement', 'dd.ref_decaissement', 'dd.montant', 'u.name')
                ->where('d.id', 4)
                ->get();

            /* Achat */
            $achat = DB::table('decaissements as d')
                ->join('achats as a', 'a.id', 'd.achat_id')
                ->join('detail_achats as da', 'a.id', 'da.achat_id')
                ->where('d.id', 4)
                ->sum(DB::raw('da.montant*da.quantite'));

            /* $requete_query_1 = $query_1->first();
            $montant_remise_achat = $achat * ($requete_query_1->remise / 100);
            $achat_apres_remise = $achat - $montant_remise_achat; */
            /* Achat */

            /* Depense */
            $depense = DB::table('decaissements as d')
                ->join('depenses as dep', 'dep.id', 'd.depense_id')
                ->where('d.id', 4)
                ->sum(DB::raw('dep.montant'));

            /* $requete_query_2 = $query_2->first();
            $montant_remise_depense = $depense * ($requete_query_2->remise / 100);
            $depense_apres_remise = $depense - $montant_remise_depense; */
            /* Depense */

            /* dd($requete_query_1, $requete_query_2); */

            $production = $achat + $depense;
        @endphp

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Décaissement</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dev.dashboard') }}">Tableau de bord</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.finances.decaissements') }}">Décaissement</a></li>
                                <li class="breadcrumb-item active">Décaissement N°{{ $decaissement->num_decaissement }}</li>
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
                                                        <span class="info-box-icon bg-maroon"><i class="bi bi-cash"></i></span>

                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Decaissement</span>
                                                            <span class="info-box-number text-sm">
                                                                {{ $decaissement->num_decaissement }} 
                                                                /
                                                                {{ \Carbon\Carbon::parse($decaissement->created_at)->format('d-m-Y h:i:s') }}
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
                                                                {{ $decaissement->num_production }}
                                                                /
                                                                {{ \Carbon\Carbon::parse($decaissement->date_etablissement)->format('d-m-Y h:i:s') }}
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
                                                            <span class="info-box-text">Bénéficiaire</span>
                                                            <span class="info-box-number text-sm">{{ $decaissement->beneficiaire }}</span>
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
                                                            <span class="info-box-number text-sm">{{ $decaissement->telephone }} | {{ $decaissement->telephone }}</span>
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
                                                            <span class="info-box-number text-sm">{{ $decaissement->adresse }}</span>
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
                                            <a href="{{ route('admin.finances.decaissements') }}"
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

                                                {{-- <div class="col-md-6 col-sm-12 col-12">
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
                                                </div> --}}
                                                <!-- /.col -->

                                                <div class="col-md-6 col-sm-12 col-12">
                                                    <div class="info-box">

                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Decaissements</span>
                                                            <span
                                                                class="info-box-number text-sm">{{ number_format($decaissements->sum('montant'), 0, ',', '.') }}
                                                                FCFA
                                                            </span>
                                                        </div>
                                                        <!-- /.info-box-content -->
                                                    </div>
                                                    <!-- /.info-box -->
                                                </div>
                                                <!-- /.col -->

                                                <div class="col-md-12 col-sm-12 col-12">
                                                    <div class="info-box">

                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Restant</span>
                                                            <span class="info-box-number text-sm">
                                                                {{number_format($production-$decaissements->sum('montant'), 0, ",",".")}} FCFA
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
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="card card-maroon">
                                <div class="card-header">
                                    <h3 class="card-title">Details Decaissement</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="table-responsive-sm">
                                                <table class="table table-striped table-bordered table-condensed table-hover text-sm mt-3" id="details">
                                                    <thead style="background-color:rgb(243, 64, 118)">
                                                        <tr class="text-white">
                                                            <th class="text-center">Date</th>
                                                            <th>Mode</th>
                                                            <th>Reference</th>
                                                            <th class="text-center">Caissier</th>
                                                            <th class="text-center">Montant</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($decaissements)==0)
                                                            <tr class="text-center table-danger">
                                                                <td colspan="4">Aucun Decaissement enregistré</td>
                                                            </tr>
                                                        @else
                                                            @foreach($decaissements as $e)
                                                            <tr>
                                                                <td class="text-center">{{\Carbon\Carbon::parse(($e->updated_at))->format('d/m/Y')}}</td>
                                                                <td>{{ $e->mode_decaissement }}</td>
                                                                <td>{{ $e->ref_decaissement }}</td>
                                                                <td class="text-center">{{ $e->name }}</td>
                                                                <td class="text-center">{{number_format($e->montant, 0, ",",".")}} FCFA</td>
                                                            </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="text-center">Décaissements</td>
                                                            <td><h6 id="sous_total">{{number_format($decaissements->sum('montant'), 0, ",",".")}} FCFA</h4></td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="4" class="text-center">
                                                                Production
                                                            </td>
                                                            <td><h6 id="sous_total">{{number_format($production, 0, ",",".")}} FCFA</h4></td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="4" class="text-center">Restant à Payer</td>
                                                            <td><h6 id="sous_total">{{number_format($production-$decaissements->sum('montant'), 0, ",",".")}} FCFA</h4></td>
                                                        </tr>

                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
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
