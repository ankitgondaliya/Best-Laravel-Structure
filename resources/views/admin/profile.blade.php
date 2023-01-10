@extends('layouts.app')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements disabled -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Profile</h3>
                    </div>
                    <form id="profile_frm" name="profile_frm" method="post">
                        <div class="card-body">
                            <input type="hidden" name="id" id="id" value="{{$user->id}}">
                            <div class="row">
                                <div class="form-group col-md-12" id="password_note">
                                    <div class="callout callout-info">
                                        <h5><i class="icon fas fa-info"></i> Note :</h5>
                                        <p>Leave <b>Password</b> and <b>Confirm Password</b> empty, if you are not going to change the password.</p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Name <span class="red">*</span></label>
                                        <input type="text" class="form-control" placeholder="Please enter Name" id="name" name="name" value="{{$user->name}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email <span class="red">*</span></label>
                                        <input disabled type="text" class="form-control" placeholder="Please enter email" id="email" value="{{$user->email}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" placeholder="Please enter password" id="password" name="password">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" placeholder="Please enter confirm password" id="confirm_password" name="confirm_password">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" name="image" id="image" class="form-control p-1" placeholder="Enter Select Image" onchange="load_preview_image(this);" accept="image/x-png,image/jpg,image/jpeg">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group" id="preview_div" style="display: none">
                                        <img src="" id="image_preview">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <img class="profile-user-img img-fluid img-circle admin_profile" src="{{$user->image}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right" id="btn">Edit <span style="display: none" id="loader"><i class="fa fa-spinner fa-spin"></i></span></button>
                        </div>
                    </form>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
</section>
@endsection
@push('js')
<script>
    var myForm = document.getElementById('profile_frm');
    var formData = new FormData(myForm);
    $("#profile_frm").validate({
        rules: {
            name: {
                required: true,
                lettersonly: true
            },
            password: {
                minlength: 8,
            },
            confirm_password: {
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
            password: {
                required: "Please enter password",
                minlength: "Please enter password atleast 8 character!"
            },
            confirm_password: {
                required: "Please enter confirm password"
            },
            image: {
                accept: 'Only allow image!'
            },
        },
        submitHandler: function(form, e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('update_admin_profile') }}",
                type: "POST",
                data: new FormData(myForm),
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
                        $("#image").val('');
                        $("#password,#confirm_password").val('');
                        toastr.success(result.message);
                        $("#image_preview").hide();
                        $(".admin_profile").attr("src", result.data);
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
</script>
@endpush
