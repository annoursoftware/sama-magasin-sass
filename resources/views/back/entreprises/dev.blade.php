@extends('back.master')

@section('title', 'Entreprises')

@push('styles')

    {{-- <script src="{{ asset('back/lightbox/src/css/lightbox.css') }}"></script> --}}

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('back/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    
    
    <style>
        input:not([type="file"]).error, textarea.error, select.error {
            border: 1px solid red !important;
        }

        input:not([type="file"]).no-error, textarea.no-error, select.no-error {
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
                        <h1>Entreprises</h1>
                        {{-- <h1 class="m-0">
                            <img src="{{ asset('BEH.png') }}" alt="" width="240px" height="40px" class="img-fluid" />
                        </h1> --}} 
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Tableau de bord</a></li>
                            <li class="breadcrumb-item active">Entreprises</li>
                        </ol>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box shadow-lg">
                            <span class="info-box-icon bg-maroon"><i class="bi bi-building"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Entreprises</span>
                                <span class="info-box-number">{{ number_format($nb_entreprises, 0, ",",".") }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box shadow-lg">
                            <span class="info-box-icon bg-maroon"><i class="bi bi-shop-window"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Boutiques</span>
                                <span class="info-box-number">{{ number_format($nb_boutiques, 0, ",",".") }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box shadow-lg">
                            <span class="info-box-icon bg-maroon"><i class="bi bi-person-workspace"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Utilisateurs</span>
                                <span class="info-box-number">{{ number_format($nb_users, 0, ",",".") }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-md-12 col-sm-12 col-12 d-flex">
                        <button type="button" class="btn btn-flat btn-primary ml-auto" onclick="addForm()">
                            <i class="bi bi-plus-lg"></i> Ajouter une entreprise
                        </button>
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
                                            <th>#</th>
                                            <th>Entreprise</th>
                                            <th>Logo</th>
                                            <th>Boutiques</th>
                                            <th>Utilisateurs</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Entreprise</th>
                                            <th>Logo</th>
                                            <th>Boutiques</th>
                                            <th>Utilisateurs</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            @include('back.entreprises.form')
                            @include('back.entreprises.show')
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
    
    {{-- <script src="{{ asset('back/lightbox/src/js/lightbox.js') }}"></script> --}}
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
                ajax: "{{ route('entreprises.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'entreprise', name: 'entreprise'},
                    {data: 'Image', name: 'Image', orderable: false, searchable: false},
                    {data: 'total_boutiques', name: 'total_boutiques'},
                    {data: 'total_users', name: 'total_users'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });

        
        function addForm() {
            save_method = 'add';
            $('input[name_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Nouvel entreprise');
            $('#id').val('');
            $('#insertbtn').text(' Enregistrer');
        }

        let isSubmitting = false;
        $('#formulaire').submit(function (e) {
            e.preventDefault();
            $('#insertbtn').html(' En cours...');
            
            /* const $submitButton = $(this).find('button[type="submit"]');
            $submitButton.prop('disabled', true).text('Submitting...'); */
            if (isSubmitting) {
                return; // Prevent multiple submissions
            }
            isSubmitting = true;

            /* var url = $(this).attr("action"); */
            let formData = new FormData(this);

            var id = $('#id').val();
            if(save_method == 'add')
            url = "{{ url('api/entreprises') }}";
            else
            url = "{{ url('api/entreprises') . '/' }}" + id;
        
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
                    table.draw();
                    /* table.ajax.reload(); */
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

        function showData(id){
            alert(id);
            $.ajax({
                url: "{{ url('api/entreprises') }}" + "/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(row){
                    $('#modal-show').modal('show');
                    $('.modal-title-show').text('Visualisation entreprise');

                    $('#id-show').val(row.data.id);
                    /* $('.info-box-number').html(data.role); */
                    $('#entreprise-show').html(row.data.entreprise);
                    $('#telephone-show').html(row.data.telephone);
                    $('#email-show').html(row.data.email);
                    $('#responsable-show').html(row.data.responsable);
                    $('#ninea-show').html(row.data.ninea);
                    $('#rc-show').html(row.data.rc);
                    $('#regime_juridique-show').html(row.data.regime_juridique);
                    $('#siege-show').html(row.data.siege);
                    
                    if (row.data.logo==null) {
                        $('#logo-show').attr('src', '{{ asset('no-img.jpg') }}');
                        $('#logo-show').attr('width', '100px');
                    } else {
                        $('#logo-show').attr('src', '{{ asset("upload/Entreprises/Logos") }}'+'/'+row.data.logo);
                        $('#logo-show').attr('width', '100px');
                        $('#logo-show').attr('heigth', '100px');
                    }
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
                }
            });
        }

        function editData(id){
            alert(id);
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            /* $('#modal-form form')[0].reset(); */
            $.ajax({
                url: "{{ url('api/entreprises') }}" + '/' + id,
                type: "GET",
                dataType: "JSON",
                success: function(row){
                    var data = row.data;
                    console.log(data);
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Modification Entreprise');
                    $('#insertbtn').text(' Modifier');

                    $('#id').val(data.id);
                    $('#entreprise').val(data.entreprise);
                    $('#email').val(data.email);
                    $('#telephone').val(data.telephone);
                    $('#responsable').val(data.responsable);
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
        }

        function deleteData(id) {
            alert(id);
            Swal.fire({
                title: 'Etes vous sûr ?',
                text: "Voulez-vous vraiment supprimer ce Rôle",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Supprimer !'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('api/entreprises') }}" + '/' + id,
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
                        url : "{{ url('api/entreprises') . '/' }}" + id,
                        type: 'DELETE',
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function (){
                            Swal.fire(
                                'Suppression !',
                                'Entreprise supprimée avec succès.',
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