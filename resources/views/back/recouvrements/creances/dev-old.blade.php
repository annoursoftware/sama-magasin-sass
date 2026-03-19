@extends('master')

@section('title', 'Creances')

@section('content')
<div>

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-end animated fadeInRightBig">
                        <a href="{{ url('api/recouvrement/etat/creances') }}" target="_BLANK" class="btn btn-outline-danger mb-3 mr-1">
                            <i class=" fas fa-file-pdf"></i> Impression des creances
                        </a>
                    </div>
                </div>
                @php
                    $nombre_impayes=DB::table('creances')->where('restant', '>', 0)->count();
                    $mt_transaction=DB::table('creances')->where('restant', '>', 0)->sum('montant');
                    $mt_encaisse=DB::table('creances')->where('restant', '>', 0)->sum('montant_encaisse');
                    $restant = DB::table('creances')->where('restant', '>', 0)->sum('restant');
                @endphp

                <div class="col-md-3 col-sm-6 col-12 animated fadeInLeftBig">
                    <div class="info-box shadow-lg">
                        <span class="info-box-icon bg-maroon"><i class="fas fa-handshake"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Creance(s)</span>
                            <span class="info-box-number">{{ $nombre_impayes }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-12 animated fadeInRightBig">
                    <div class="info-box shadow-lg">
                        <span class="info-box-icon bg-maroon"><i class="fas fa-money-bill-alt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Montant</span>
                            <span class="info-box-number">{{ number_format($mt_transaction, 0, ",",".") }} FCFA</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-12 animated fadeInRightBig">
                    <div class="info-box shadow-lg">
                        <span class="info-box-icon bg-maroon"><i class="fas fa-money-bill-alt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Encaissements</span>
                            <span class="info-box-number">{{ number_format($mt_encaisse, 0, ",",".") }} FCFA</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-12 animated fadeInRightBig">
                    <div class="info-box shadow-lg">
                        <span class="info-box-icon bg-maroon"><i class="fas fa-money-bill"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Restant</span>
                            <span class="info-box-number">{{ number_format($restant, 0, ",",".") }} FCFA</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="recouvrements" class="table table-bordered table-hover table-striped animated bounceInDown">
                                        <thead>
                                            <tr>
                                                <th class="text-center">N° Facture</th>
                                                <th>Client</th>
                                                <th>Facture</th>
                                                <th>N° Encaissement</th>
                                                <th>Encaissement</th>
                                                <th>Restant</th>
                                                {{-- <th>Operations</th> --}}
                                            </tr>
                                        </thead>

                                        <tbody class="text-center"></tbody>

                                        <tfoot>
                                            <tr>
                                                <th class="text-center">N° Facture</th>
                                                <th>Client</th>
                                                <th>Facture</th>
                                                <th>N° Encaissement</th>
                                                <th>Encaissement</th>
                                                <th>Restant</th>
                                                {{-- <th>Operations</th> --}}
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->

            </div>
              <!-- /.row -->
        </div><!-- /.container -->

    </div>
    <!-- /.content -->
</div>
@endsection

@push('scripts')

    <script>
        var recouvrements = $('#recouvrements').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            info: true,
            ajax: "{{ url('api/recouvrement/creances') }}",
            columns: [
                { data: 'n_contrat', name: 'n_contrat' },
                { data: 'client', name: 'client' },
                { data: 'montant', name: 'montant',
                    render: $.fn.dataTable.render.number( '.', ',', 0 )
                },
                /* { data: 'voiture', name: 'voiture' },
                { data: 'immatriculation', name: 'immatriculation' }, */
                { data: 'num_encaissement', name: 'num_encaissement' },
                { data: 'montant_encaisse', name: 'montant_encaisse',
                    render: $.fn.dataTable.render.number( '.', ',', 0 )
                },
                { data: 'restant', name: 'restant',
                    render: $.fn.dataTable.render.number( '.', ',', 0 )
                },
                /* { data: 'action', name: 'action', orderable: false, searchable: false }, */
            ],

            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            }

        });

        function addForm() {
            save_method = 'add';
            $('input[name_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Nouvelle Instance');
            $('#insertbtn').text(' Enregistrer');

        }

    </script>

@endpush

