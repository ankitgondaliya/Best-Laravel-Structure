@extends('layouts.app')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All user lists</h3>
                        <div class="text-right">
                            <a href="javascript:void(0)" onclick="user_modal()" type="button" class="btn btn-primary">Add new user</a>
                            <a href="javascript:void(0)" onclick="reload_data()" type="button" class="btn btn-dark">Refresh</a>
                        </div>
                    </div>
                    <form id="frm-example" method="post">
                        <div class="card-body">
                            <table class="table data-table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Image</th>
                                        <th style="min-width: 130px">Action</th>
                                    </tr>
                                </thead>
                            </table>
                            <button type="submit" class="btn btn-danger" id="multiple_delete_btn" disabled>Delete selected <span style="display: none" id="multiple_user_delete_loader"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('users.modal')
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Get user data
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.index') }}",
            "order": [],
            columnDefs: [{
                    targets: 0,
                    checkboxes: {
                        selectRow: true
                    }
                },
                {
                    orderable: false,
                    targets: [0, 4]
                }
            ],
            select: {
                style: 'multi'
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'image',
                    name: 'image',
                    orderable: false
                },
                {
                    data: 'actions',
                    name: 'actions'
                }
            ],
        });
        jQuery('.data-table').wrap('<div class="dataTables_scroll" />');

        // Multiple Delete
        $('#frm-example').on('submit', function(e) {
            var rows_selected = table.column(0).checkboxes.selected();
            if (rows_selected.length > 0) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure want to delete multiple rows?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value == true) {
                        var selected_rows_array = [];
                        $.each(rows_selected, function(index, rowId) {
                            selected_rows_array.push(rowId);
                        });
                        e.preventDefault();
                        $.ajax({
                            type: 'POST',
                            data: {
                                ids: selected_rows_array,
                            },
                            url: '{{ url("multiple_user_delete")}}',
                            headers: {
                                'X-CSRF-TOKEN': csrf_token
                            },
                            beforeSend: function() {
                                $('#multiple_user_delete_loader').show();
                                $("#multiple_delete_btn").prop('disabled', true);
                            },
                            success: function(response) {
                                $('#multiple_user_delete_loader').hide();
                                if (response.status) {
                                    table.columns().checkboxes.deselect(true);
                                    toastr.success(response.message);
                                    $('.data-table').DataTable().ajax.reload();
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function() {
                                $('#multiple_user_delete_loader').hide();
                                $("#multiple_delete_btn").prop('disabled', false);
                                toastr.error('Please Reload Page.');
                            }
                        });
                    } else {
                        return false;
                    }
                });
            } else {
                toastr.error('Please select atleast any one row');
                e.preventDefault();
            }
        });
    });

    // Add user modal open
    function user_modal() {
        var $alertas = $('#add_edit_form');
        $alertas.validate().resetForm();
        $alertas.find('.error').removeClass('error');
        $('#add_edit_form')[0].reset();
        $("#add_edit_modal").modal('show');
        $("#id").val(0);
        $("#user_modal_title").text('Add user');
        $("#preview_div").hide();
        $('#btn').html('Add <span style="display: none" id="loader"><i class="fa fa-spinner fa-spin"></i></span>');
        $("#password_note,#password_note1").hide();
        $("#confirm_password_red,#password_red,#image_red").show();
        $("#email").prop('readonly', false);
    }

    // Add or Edit user details
    $("#add_edit_form").validate({
        rules: {
            name: {
                required: true,
                lettersonly: true,
                minlength: 3
            },
            user_name: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: "{{ url('check_email_dublicate') }}",
                    type: "get",
                    data: {
                        id: function() {
                            return $("#id").val();
                        }
                    }
                }
            },
            password: {
                required: {
                    depends: function() {
                        var id = $('#id').val();
                        if (id == 0 || id == '') {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                minlength: 6,
            },
            confirm_password: {
                required: {
                    depends: function() {
                        var id = $('#id').val();
                        if (id == 0 || id == '') {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                equalTo: "#password"
            },
            image: {
                accept: "image/jpg,image/jpeg,image/png"
            },
        },
        messages: {
            name: {
                required: "Please enter name",
                lettersonly: "Please enter valid name"
            },
            user_name: {
                required: "Please enter user name",
            },
            email: {
                required: "Please enter email",
                remote: "Email already taken!"
            },
            password: {
                required: "Please enter password",
                minlength: "Please enter password atleast 6 character!"
            },
            confirm_password: {
                required: "Please enter confirm password",
                equalTo: "Confirm Password does not match with Password!"
            },
            image: {
                accept: 'Please select only image!'
            },
        },
        submitHandler: function(form, e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('users.store') }}",
                type: "POST",
                data: new FormData(form),
                dataType: 'json',
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrf_token
                },
                beforeSend: function() {
                    $('#loader').show();
                    $('#btn').prop('disabled', true);
                },
                success: function(result) {
                    $('#loader').hide();
                    $('#btn').prop('disabled', false);
                    if (result.status) {
                        $('.data-table').DataTable().ajax.reload();
                        $("#add_edit_modal").modal('hide');
                        $("#add_edit_form")[0].reset();
                        toastr.success(result.message);
                    } else {
                        toastr.error(result.message);
                    }
                },
                error: function() {
                    toastr.error('Please Reload Page.');
                    $('#loader').hide();
                    $('#btn').prop('disabled', false);
                }
            });
            return false;
        }
    });

    // Edit user modal open
    function edit_user_modal(id) {
        var $alertas = $('#add_edit_form');
        $alertas.validate().resetForm();
        $("#confirm_password_red,#password_red,#image_red").hide();
        $alertas.find('.error').removeClass('error');
        $("#add_edit_modal").modal('show');
        $.ajax({
            type: 'GET',
            data: {
                id: id,
                _method: 'SHOW'
            },
            url: '{{ url("users")}}' + '/' + id,
            headers: {
                'X-CSRF-TOKEN': csrf_token
            },
            success: function(response) {
                console.log(response);
                if (response.status) {
                    $("#email").prop('readonly', true);
                    $("#password_note,#password_note1").show();
                    $("#user_modal_title").text('Edit user');
                    $("#id").val(response.data.id);
                    Object.keys(response.data).map(function(key) {
                        if (key == 'image') {
                            $("#image_preview").attr("src", response.data[key]);
                            $("#preview_div").show();
                        } else {
                            $(`#${key}`).val(response.data[key]);
                        }
                    });
                    $('#btn').html('Update <span style="display: none" id="loader"><i class="fa fa-spinner fa-spin"></i></span>');
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Please Reload Page.');
            }
        });
    }

    // View user modal open
    function view_user_modal(id) {
        $("#view_user_modal").modal('show');
        $.ajax({
            type: 'GET',
            data: {
                id: id,
                _method: 'SHOW'
            },
            url: '{{ url("users")}}' + '/' + id,
            headers: {
                'X-CSRF-TOKEN': csrf_token
            },
            success: function(response) {
                if (response.status) {
                    Object.keys(response.data).map(function(key) {
                        console.log(`#view_${key}`, 'view_address');
                        if (key == 'image') {
                            $("#view_image_preview").attr("src", response.data[key]);
                        }
                        $(`#view_${key}`).text(response.data[key]);

                    });
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Please Reload Page.');
            }
        });
    }

    // Delete record
    function DeleteData(id) {
        Swal.fire({
            title: 'Are you sure want to delete these record?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value == true) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id,
                        _method: 'DELETE'
                    },
                    url: '{{ url("users")}}' + '/' + id,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': csrf_token
                    },
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                            $('.data-table').DataTable().ajax.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('Please Reload Page.');
                    }
                });
            }
        })
    }
</script>
@endpush
