@extends('back.master')

@section('title', 'Utilisateurs')

@push('styles')
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
@endpush

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Utilisateurs</h1>    
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Tableau de bord</a></li>
                            <li class="breadcrumb-item active">Utilisateurs</li>
                        </ol>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box shadow-lg">
                            <span class="info-box-icon bg-maroon"><i class="bi bi-people-fill"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Utilisateurs</span>
                                <span class="info-box-number">{{ number_format($nb_users, 0, ",",".") }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box shadow-lg">
                            <span class="info-box-icon bg-maroon"><i class="bi bi-people-fill"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Entrepreneurs</span>
                                <span class="info-box-number">{{ number_format($nb_entrepreneurs, 0, ",",".") }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box shadow-lg">
                            <span class="info-box-icon bg-maroon"><i class="bi bi-people-fill"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Vendeurs</span>
                                <span class="info-box-number">{{ number_format($nb_vendeurs, 0, ",",".") }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box shadow-lg">
                            <span class="info-box-icon bg-maroon"><i class="bi bi-people-fill"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Gestionnaires</span>
                                <span class="info-box-number">{{ number_format($nb_gestionnaires, 0, ",",".") }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-12 col-sm-12 col-12 d-flex">
                        <button type="button" class="btn btn-flat btn-primary ml-auto" onclick="addForm()">
                            <i class="bi bi-plus-lg"></i> Ajouter un utilisateur
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
                            {{-- <div class="card-header">
                                <h3 class="card-title">DataTable with minimal features & hover style</h3>
                            </div> --}}
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Utilisateurs</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Boutique</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Utilisateurs</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Boutique</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            @include('back.utilisateurs.form')
                            @include('back.roles.show')
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

    
    <script>
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
            ajax: "{{ route('users.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'role', name: 'role'},
                {data: 'boutique', name: 'boutique'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "order": [[ 0, "desc" ]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            }
        });

        function add() {
            /* alert('add'); */
            $('#myModal').show();
            $('#ajax-form').find(".print-error-msg").css('display', 'none');
            $('#ajax-form').trigger("reset");
            $('#btn-save').val("create-post");
            $('#ajax-form').attr("action", "{{ route('users.store') }}");
            $('#formulaire-modal').find('.modal-title').text('Créer un nouvel utilisateur');
        }
        
        function addForm() {
            save_method = 'add';
            $('input[name_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Nouvel utilisateur');
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
            url = "{{ url('api/users') }}";
            else
            url = "{{ url('api/users') . '/' }}" + id;
        
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
                url: "{{ url('api/users') }}" + "/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(row){
                    $('#modal-show').modal('show');
                    $('.modal-title-show').text('Visualisation utilisateur');

                    $('#id-show').val(row.data.id);
                    /* $('.info-box-number').html(data.role); */
                    $('#name-show').val(row.data.name);
                    $('#email-show').val(row.data.email);
                    $('#email-show').val(row.data.role);
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
                url: "{{ url('api/users') }}" + '/' + id,
                type: "GET",
                dataType: "JSON",
                success: function(row){
                    var data = row.data;
                    console.log(data);
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Modification utilisateur');
                    $('#insertbtn').text(' Modifier');

                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#sexe').val(data.sexe);
                    $('#email').val(data.email);
                    $('#username').val(data.username);
                    $('#telephone').val(data.telephone);
                    $('#adresse').val(data.adresse);
                    $('#role').val(data.role_id);
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
                text: "Voulez-vous vraiment supprimer cet utilisateur",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Supprimer !'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('api/users') }}" + '/' + id,
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
                        url : "{{ url('api/users') . '/' }}" + id,
                        type: 'DELETE',
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function (){
                            Swal.fire(
                                'Suppression !',
                                'Utilisateur supprimé avec succès.',
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


        $(document).ready(function () {
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
            
            $('#email').on('blur', function () {
                let value = $(this).val();

                $.ajax({
                    url: '{{ route('check-email-users') }}',
                    type: 'POST',
                    data: {
                        value: value,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.exists) {
                            
                            Toast.fire({
                                icon: 'error',
                                title: 'Email existe déjà !'
                            });
                        } else {
                                
                            Toast.fire({
                                icon: 'success',
                                title: 'Email libre !'
                            });
                        }
                    },
                    error: function () {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
            
            $('#username').on('blur', function () {
                let value = $(this).val();

                $.ajax({
                    url: '{{ route('check-username-users') }}',
                    type: 'POST',
                    data: {
                        value: value,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.exists) {
                            
                            Toast.fire({
                                icon: 'error',
                                title: 'Username existe déjà !'
                            });
                        } else {
                                
                            Toast.fire({
                                icon: 'success',
                                title: 'Username libre !'
                            });
                        }
                    },
                    error: function () {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
            
            $('#telephone').on('blur', function () {
                let value = $(this).val();

                $.ajax({
                    url: '{{ route('check-telephone-users') }}',
                    type: 'POST',
                    data: {
                        value: value,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.exists) {
                            
                            Toast.fire({
                                icon: 'error',
                                title: 'Téléphone existe déjà !'
                            });
                        } else {
                                
                            Toast.fire({
                                icon: 'success',
                                title: 'Téléphone libre !'
                            });
                        }
                    },
                    error: function () {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });

    </script>
@endpush