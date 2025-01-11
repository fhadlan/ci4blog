<?php $this->extend('backend/layout/page-layout'); ?>
<?php $this->section('content') ?>
<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Profile</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= route_to('admin.home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Profile
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- header end -->


<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <div class="profile-photo">
                <a href="javascript:;" onclick="event.preventDefault();document.getElementById('user_profile_file').click();" class="edit-avatar"><i class="fa fa-pencil"></i></a>
                <input type="file" name="user_profile_file" id="user_profile_file" class="d-none" style="opacity: 0;">
                <img src="/images/users/<?= get_user()->picture == null ? 'default-avatar.webp' : get_user()->picture   ?>" alt="" class="avatar-photo">
            </div>
            <h5 class="text-center h5 mb-0"><?= get_user()->name; ?></h5>
            <p class="text-center text-muted font-14"><?= get_user()->email; ?></p>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
        <div class="card-box height-100-p overflow-hidden">
            <div class="profile-tab height-100-p">
                <div class="tab height-100-p">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#personal_details" role="tab">Personal Detail</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#change_password" role="tab">Change Password</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- personal details Tab start -->
                        <div class="tab-pane fade show active" id="personal_details" role="tabpanel">
                            <div class="pd-20">
                                <form action="<?= route_to('update-personal-details') ?>" id='personal_details_form' method="post">
                                    <?= csrf_field(); ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Name</label>
                                                <input type="text" name="name" class="form-control" placeholder="Enter full name" value="<?= get_user()->name ?>">
                                                <span class="text-danger error-text name_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Username</label>
                                                <input type="text" name="username" class="form-control" placeholder="Enter username" value="<?= get_user()->username ?>">
                                                <span class="text-danger error-text username_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Bio</label>
                                        <textarea name="bio" id="bio" class="form-control" placeholder="Enter bio"><?= get_user()->bio ?></textarea>
                                        <span class="text-danger error-text bio_error"></span>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- personal details Tab End -->
                        <!-- change password Tab start -->
                        <div class="tab-pane fade" id="change_password" role="tabpanel">
                            <div class="pd-20 ">
                                <form action="<?= route_to('change-password') ?>" method="post" id="change_password_form">
                                    <?= csrf_field() ?>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Current Password</label>
                                                <input type="password" class="form-control" placeholder="Enter Current Password" name="current_password">
                                                <span class="text-danger error-text current_password_error"></span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">New Password</label>
                                                <input type="password" class="form-control" placeholder="Enter New Password" name="new_password">
                                                <span class="text-danger error-text new_password_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Confrim New Password</label>
                                                <input type="password" class="form-control" placeholder="Retype New Password" name="confirm_new_password">
                                                <span class="text-danger error-text confirm_new_password_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- changepassword Tab End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
<?php $this->section('stylesheets') ?>
<link rel="stylesheet" type="text/css" href="/backend/src/plugins/bootstrap-wysihtml5-master/bootstrap-wysihtml5.css">
<?php $this->endSection() ?>
<?php $this->section('scripts') ?>
<script src="/backend/src/plugins/bootstrap-wysihtml5-master/bootstrap-wysihtml5.js"></script>
<script>
    $('#bio').wysihtml5();
    // AJAX
    $('#personal_details_form').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formData,
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function() {

                $(form).find('span.error-text').text('');
            },
            success: function(response) {
                if ($.isEmptyObject(response.error)) {
                    if (response.status == 1) {
                        $('.ci-user-name').each(function() {
                            $(this).html(response.user_info.name);
                        })
                        alert(response.msg);
                    } else {

                    }
                } else {
                    $.each(response.error, function(prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val);
                    });
                }
            }
        });
    });

    // ijabocroptool
    $('#user_profile_file').ijaboCropTool({
        preview: '.avatar-photo',
        setRatio: 1,
        allowedExtensions: ['jpg', 'jpeg', 'png'],
        processUrl: '<?= route_to('update-profile-picture'); ?>',
        withCSRF: ['<?= csrf_token() ?>', '<?= csrf_hash() ?>'],
        onSuccess: function(message, element, status) {
            alert(message);
        },
        onError: function(message, element, status) {
            alert(message);
        }
    });

    //send new password
    $('#change_password_form').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);


        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formData,
            processData: false,
            dataType: 'json',
            contentType: false,
            cache: false,
            beforeSend: function() {
                $(form).find('span.error-text').text('');
            },
            success: function(response) {

                console.log(response.status);
                if ($.isEmptyObject(response.error)) {
                    if (response.status == 1) {
                        $(form)[0].reset();
                        alert(response.msg);
                    } else {
                        alert(response.msg);
                    }
                } else {
                    $.each(response.error, function(prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val);
                    });
                }
            }
        });
    });
</script>
<?php $this->endSection() ?>