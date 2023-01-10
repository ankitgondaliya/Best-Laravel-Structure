<!-- Add new users -->
<div class="modal fade" id="add_edit_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="user_modal_title">Add user</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="post" name="add_edit_form" id="add_edit_form">
        <div class="modal-body">
            <div class="container-fluid">
                <input type="hidden" name="id" id="id" value="0">
                <div class="row">
                <div class="form-group col-md-6">
                    <label for="recipient-name" class="col-form-label">Name: <span class="red">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Please enter name">
                </div>
                <div class="form-group col-md-6">
                    <label for="user_name" class="col-form-label">User Name: <span class="red">*</span></label>
                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Please enter user name">
                </div>
                <div class="form-group col-md-6">
                    <label for="recipient-name" class="col-form-label">Email: <span class="red">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Please enter email">
                </div>
                <div class="form-group col-md-12" id="password_note">
                    <div class="callout callout-info">
                        <h5><i class="icon fas fa-info"></i> Note :</h5>
                        <p>Leave <b>Password</b> and <b>Confirm Password</b> empty, if you are not going to change the password.</p>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="recipient-name" class="col-form-label">Password:  <span class="red" id="password_red">*</span></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Please enter password">
                </div>
                <div class="form-group col-md-6">
                    <label for="recipient-name" class="col-form-label">Confirm Password: <span class="red" id="confirm_password_red">*</span></label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Please enter confirm password">
                </div>
                <div class="col-12 row">
                <div class="form-group col-md-6">
                    <label for="recipient-name" class="col-form-label">Image:</label>
                    <input type="file" name="image" id="image" class="form-control p-1" placeholder="Enter Select Image" onchange="load_preview_image(this);" accept="image/x-png,image/jpg,image/jpeg">
                </div>
                <div class="form-group col-md-6" id="preview_div" style="display: none">
                    <img src="" id="image_preview">
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary float-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btn">Add <span style="display: none" id="loader"><i class="fa fa-spinner fa-spin"></i></span></button>
        </div>
        </form>
        </div>
    </div>
</div>

<!-- View user details -->
<div class="modal fade" id="view_user_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" >View user</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" id="view_image_preview" src="" alt="User profile picture">
                </div>
                <h3 class="profile-username text-center" id="view_user_name">-</h3>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Name</b> <a class="float-right" id="view_name">-</a>
                    </li>
                    <li class="list-group-item">
                        <b>Email</b> <a class="float-right" id="view_email">-</a>
                    </li>
                    <li class="list-group-item">
                        <b>Created At</b> <a class="float-right" id="view_created_at">-</a>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b> <a class="float-right"><span class="right badge badge-info" id="view_status">-</span></a>
                    </li>
                </ul>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
