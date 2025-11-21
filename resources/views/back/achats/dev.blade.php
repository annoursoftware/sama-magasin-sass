@extends('back.master')

@section('title', 'Achats')

@push('styles')

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('back/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" />

@endpush

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Achats</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dev.dashboard') }}">Tableau de bord</a></li>
                            <li class="breadcrumb-item active">Achats</li>
                        </ol>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-2 col-sm-6 col-12">
                        <div class="info-box shadow-lg">
                            <span class="info-box-icon bg-maroon"><i class="bi bi-cart-plus-fill"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Achats</span>
                                <span class="info-box-number">{{ number_format($nb_achats, 0, ",",".") }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box shadow-lg">
                            <span class="info-box-icon bg-maroon"><i class="bi bi-cash-stack"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Montant des achats</span>
                                <span class="info-box-number">{{ number_format($nb_achats, 0, ",",".") }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box shadow-lg">
                            <span class="info-box-icon bg-maroon"><i class="bi bi-cash-stack"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Moyenne</span>
                                <span class="info-box-number">{{ number_format($nb_achats, 0, ",",".") }} F.CFA</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box shadow-lg">
                            <span class="info-box-icon bg-maroon"><i class="bi bi-cash-stack"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Meilleure achat</span>
                                <span class="info-box-number">{{ number_format($nb_achats, 0, ",",".") }} F.CFA</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    {{-- <div class="col-md-12 col-sm-12 col-12 d-flex">
                        <button type="button" class="btn btn-flat btn-primary ml-auto" onclick="addForm()">
                            <i class="bi bi-plus-lg"></i> Effectuer une vente
                        </button>
                    </div> --}}
                </div>
                <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
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
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th>Fournisseur</th>
                                            <th>Montant</th>
                                            <th>Gestionnaire</th>
                                            <th>Boutique</th>
                                            <th>Entreprise</th>
                                            <th>Statut</th>
                                            <th>Finances</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th>Fournisseur</th>
                                            <th>Montant</th>
                                            <th>Gestionnaire</th>
                                            <th>Boutique</th>
                                            <th>Entreprise</th>
                                            <th>Statut</th>
                                            <th>Finances</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            {{-- @include('back.achats.form') --}}
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

    $(document).ready(function(){
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
    <!-- Moment -->
    <script src="{{ asset('back/plugins/moment/moment.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-number/2.1.6/jquery.number.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>

    <script>
        $(function () {
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
                ajax: "{{ route('achats.index') }}",
                columns: [
                    /* {data: 'id', name: 'id'}, */
                    {data: 'num_achat', name: 'num_achat'},
                    { data: 'status_achat', name: 'status_achat',
                        render: function(data, type, row) {
                            if(row.status_achat == 'f'){
                                return '<span class="badge badge-warning">Facture</span>';
                            } else {
                                return '<span class="badge badge-danger">Devis</span>'
                            }
                        },
                    },
                    { data: "created_at",
                        "render": function (value) {
                            if (value === null) return "";
                            return moment(value).format('DD/MM/YYYY');
                        }
                    },
                    { data: 'fournisseur', name: 'fournisseur' },
                    { data: 'montant', name: 'montant',
                        render: $.fn.dataTable.render.number( '.', ',', 0 )
                    },
                    { data: 'gestionnaire', name: 'gestionnaire' },
                    { data: 'boutique', name: 'boutique' },
                    { data: 'entreprise', name: 'entreprise' },
                    { data: 'etat', name: 'etat',
                        render: function(data, type, row) {
                            if(row.etat == 1){
                                return '<span class="badge badge-primary">Actif</span>'
                            }else{
                                return '<span class="badge badge-danger">Inactif</span>'
                            }
                        },
                    },
                    { data: 'etat', name: 'etat',
                        render: function(data, type, row) {
                            if(row.etat == 1){
                                if (row.montant>row.decaissements) {
                                    return '<span class="badge badge-warning">non soldée</span>';
                                } else {
                                    return '<span class="badge badge-success">soldée</span>';
                                }
                            } else{
                                return '<span class="badge badge-danger">annulée</span>'
                            }
                        },
                    },
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                "order": [[0, 'desc']],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                }
            });
        });

        
        function addForm() {
            var url = window.location.origin+'/admin/transactions/achats/nouveau/';
            window.open(url, '_self');
        }
        
        /***********************   Redirection vers la page visualisation  ******************************/
        function showData(id){
            //alert(id);
            var url = window.location.origin+'/admin/depenses/achats/visualisation/'+id;
            window.open(url, '_self');
        }
        /***********************   Redirection vers la page visualisation  ******************************/
        
        /***********************   Redirection vers la page edition  ******************************/
        function editData(id){
            //alert(id);
            var url = window.location.origin+'/admin/depenses/achats/modification/'+id;
            window.open(url, '_self');
        }
        /***********************   Redirection vers la page edition  ******************************/

        function deleteData(id) {
            alert(id);
            Swal.fire({
                title: 'Etes vous sûr ?',
                text: "Voulez-vous vraiment supprimer cet article ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Supprimer !'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('api/articles') }}" + '/' + id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(row){
                            var data = row.data;
                            console.log(data);
                            var id = data.id
                        },
                        error: function(){
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                onOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            });
                            Toast.fire({
                                icon: 'error',
                                title: 'Quelque chose ne va pas : (Code '+data.status+')'
                            });
                        },

                    });

                    var token = $("meta[name='csrf-token']").attr("content");
                    $.ajax(
                    {
                        url : "{{ url('api/articles') . '/' }}" + id,
                        type: 'DELETE',
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function (){
                            Swal.fire(
                                'Suppression !',
                                'Transaction supprimée avec succès.',
                                'success'
                            )
                            table.draw();
                        },
                        error: function (data, textStatus, errorThrown) {
                            console.log(data);
                        },
                    });

                }
            })
        }
    </script>
@endpush