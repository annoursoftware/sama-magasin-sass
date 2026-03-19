@extends('back.master')

@section('title', 'Soldes')

@push('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('back/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">


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
@endpush

@section('content')
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Solde</h1>
                        {{-- <h1 class="m-0">
                            <img src="{{ asset('BEH.png') }}" alt="" width="240px" height="40px" class="img-fluid" />
                        </h1> --}}
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dev.dashboard') }}">Tableau de bord</a></li>
                            <li class="breadcrumb-item active">Soldes</li>
                        </ol>
                    </div>
                </div>
                @php
                    $encaissements = DB::table('vue_encaissements_1')->where('montant_restant_a_encaisser', '>', 0)->orWhere('montant_restant_a_encaisser', 0)->sum('montant_encaisse');
                    $decaissements = DB::table('vue_depenses_1')->where('montant_restant_a_decaisser', '>', 0)->orWhere('montant_restant_a_decaisser', 0)->sum('montant_decaisse');
                    $solde = $encaissements - $decaissements;
                @endphp
                <div class="row mb-2">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box shadow-lg">
                            <span class="info-box-icon bg-maroon"><i class="bi bi-cash-stack"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Encaissements</span>
                                <span class="info-box-number">{{ number_format($encaissements, 0, ',', '.') }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box shadow-lg">
                            <span class="info-box-icon bg-maroon"><i class="bi bi-cash-stack"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Décaissements</span>
                                <span class="info-box-number">{{ number_format(-$decaissements, 0, ',', '.') }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box shadow-lg">
                            <span class="info-box-icon bg-maroon"><i class="bi bi-cash-coin"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Solde</span>
                                <span class="info-box-number">{{ number_format($solde, 0, ',', '.') }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-md-12 col-sm-12 col-12 d-flex">
                        <a href="{{ route('recouvrement.etat.soldes') }}" type="button"
                            class="btn btn-flat btn-danger ml-auto" target="_blank">
                            <i class="bi bi-filetype-pdf"></i> Impression du solde
                        </a>
                    </div>
                </div>
                <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">DataTable with minimal features & hover style</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <table id="table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">N° Contrat</th>
                                            {{-- <th>Transaction</th> --}}
                                            <th>Production</th>
                                            <th>Intermediaire</th>
                                            <th>Montant apres remise</th>
                                            <th>Trésorerie</th>
                                            <th>Restant</th>
                                            {{-- <th>Operations</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">N° Contrat</th>
                                            {{-- <th>Transaction</th> --}}
                                            <th>Production</th>
                                            <th>Intermediaire</th>
                                            <th>Montant apres remise</th>
                                            <th>Trésorerie</th>
                                            <th>Restant</th>
                                            {{-- <th>Operations</th> --}}
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
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
    <script>
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        })

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('back/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('back/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('back/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('back/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('back/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('back/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('back/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('back/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('back/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('back/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('back/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('back/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-number/2.1.6/jquery.number.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>

    <script>
        $(function() {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                /* paging: false,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
                responsive: true, */
                ajax: "{{ route('recouvrements.index') }}",
                columns: [
                    {
                        data: 'num_contrat',
                        name: 'num_contrat'
                    },
                    /* {
                        data: 'transaction',
                        name: 'transaction'
                    }, */
                    {
                        data: 'montant_facture',
                        name: 'montant_facture',
                        render: $.fn.dataTable.render.number('.', ',', 0)
                    },
                    {
                        data: 'intermediaire',
                        name: 'intermediaire'
                    },
                    {
                        data: 'montant_apres_remise',
                        name: 'montant_apres_remise',
                        render: $.fn.dataTable.render.number('.', ',', 0)
                    },
                    {
                        data: 'montant_compta',
                        name: 'montant_compta',
                        render: $.fn.dataTable.render.number('.', ',', 0)
                    },
                    {
                        data: 'montant_restant',
                        name: 'montant_restant',
                        render: $.fn.dataTable.render.number('.', ',', 0)
                    },
                    /* {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }, */
                ]
            });
        });
    </script>
@endpush
