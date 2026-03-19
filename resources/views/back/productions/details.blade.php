@extends('back.master')

@section('title', 'Production N°'.$production->num_production)

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
                            <li class="breadcrumb-item active">Production N°{{ $production->num_production }}</li>
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
                                        <h3 class="card-title">Production</h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-maroon"><i class="bi bi-building-fill-gear"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Production N° {{ $production->num_production }}</span>
                                                        <span class="info-box-number text-sm">Production [{{ $production->etat == 1 ? 'active' : 'annulée' }}]</span>
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
                                                        <span class="info-box-number text-sm">{{ $production->name }}</span>
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
                                                            class="info-box-number text-sm">{{ \Carbon\Carbon::parse($production->created_at)->format('d/m/Y à H:i:s') }}</span>
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
                                        <a href="{{ route('dev.productions.productions') }}" class="btn btn-primary float-left">
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
                                        <h3 class="card-title">Ingrédients</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 col-12">
                                                <div class="info-box">

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Nombre</span>
                                                        <span
                                                            class="info-box-number text-sm">{{ number_format($productions->count(), 0, ',', '.') }}</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->

                                            <div class="col-md-6 col-sm-12 col-12">
                                                <div class="info-box">

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Quantité</span>
                                                        <span
                                                            class="info-box-number text-sm">{{ number_format($productions->sum('quantite'), 0, ',', '.') }}</span>
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
                                        <h3 class="card-title">Details Production</h3>
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
                                                        <th width="45%">Article</th>
                                                        <th class="text-center" width="7%">Quantité</th>
                                                        <th class="text-center">Sous total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0; ?>
                                                    @foreach ($productions as $p)
                                                        <?php $i++; ?>
                                                        <tr>
                                                            {{-- <td>{{ $i }}</td> --}}
                                                            <td>{{ $p->produit }}</td>
                                                            <td class="text-center">{{ $p->quantite }}</td>
                                                            <td class="text-center">{{ $p->quantite }}</td>
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
