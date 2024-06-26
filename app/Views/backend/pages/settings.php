<?php $this->extend('backend/layout/page-layout'); ?>
<?php $this->section('content') ?>
<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Settings</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= route_to('admin.home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Settings
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- end of page header  -->
<div class="pd-20 card-box mb-4">
    <div class="tab">
        <!-- navikasi menu tab -->
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#general_settings" role="tab" aria-selected="true">General Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#logo_favicon" role="tab" aria-selected="false">Logo & Favicon</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#social_media" role="tab" aria-selected="false">Social Media</a>
            </li>
        </ul>

        <!-- tab general settings -->
        <div class="tab-content">
            <div class="tab-pane fade show active" id="general_settings" role="tabpanel">
                <div class="pd-20">
                    <form action="<?= route_to('update-general-settings') ?>" method="post" id="general_settings_form">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Blog Title</label>
                                    <input type="text" name="blog_title" class="form-control" placeholder="Enter blog title" value="<?= get_settings()->blog_title ?>">
                                    <span class="text-danger error-text blog_title_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Blog Email</label>
                                    <input type="text" name="blog_email" class="form-control" placeholder="Enter blog email" value="<?= get_settings()->blog_email ?>">
                                    <span class="text-danger error-text blog_email_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Blog Phone Number</label>
                                    <input type="text" name="blog_phone" class="form-control" placeholder="Enter blog phone number" value="<?= get_settings()->blog_phone ?>">
                                    <span class="text-danger error-text blog_phone_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Blog Meta Keyword</label>
                                    <input type="text" name="blog_meta_keywords" class="form-control" placeholder="Enter blog meta keyword" value="<?= get_settings()->blog_meta_keywords ?>">
                                    <span class="text-danger error-text blog_meta_keywords_error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Blog Meta Description</label>
                            <textarea name="blog_meta_description" class="form-control" placeholder="Write blog meta description"><?= get_settings()->blog_meta_description ?></textarea>
                            <span class="text-danger error-text blog_meta_description_error"></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end of general tab setting -->

            <!-- start logo/navicon -->
            <div class="tab-pane fade" id="logo_favicon" role="tabpanel">
                <div class="pd-20">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Set Blog Logo</h5>
                            <img src="" alt="Preview" id="preview_blog_logo">
                            <form action="<?= route_to('update-blog-logo') ?>" method="post" enctype="multipart/form-data" id="update_blog_logo_form">
                                <?= csrf_field() ?>
                                <div class="mb-2">
                                    <input type="file" name="blog_logo" id="blog_logo" class="form-control">
                                    <span class="text-danger error-text blog_logo_error"></span>
                                </div>
                                <button type="submit" class="btn btn-primary">Change Logo</button>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Set Blog Favicon</h5>
                            <img src="" alt="Preview" id="preview_blog_favicon">
                            <form action="<?= route_to('update-blog-favicon') ?>" method="post" id="update_blog_favicon_form" enctype="multipart/form-data">
                                <? csrf_field() ?>
                                <div class="mb-2">
                                    <input type="file" name="blog_favicon" id="blog_favicon" class="form-control">
                                    <span class="text-danger error-text"></span>
                                </div>
                                <button type="submit" class="btn btn-primary">Change Favicon</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of logo/favicon -->

            <div class="tab-pane fade" id="social_media" role="tabpanel">
                <div class="pd-20">
                    <form action="<?= route_to('update-social-media') ?>" method="post" id="social_media_form">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Facebook URL</label>
                                    <input type="text" name="facebook_url" id="" class="form-control" placeholder="Enter facebook URL" value="<?= get_social_media()->facebook_url ?>">
                                    <span class="text-danger error-text facebook_url_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Twitter URL</label>
                                    <input type="text" name="twitter_url" id="" class="form-control" placeholder="Enter twitter URL" value="<?= get_social_media()->twitter_url ?>">
                                    <span class="text-danger error-text twitter_url_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Instagram URL</label>
                                    <input type="text" name="instagram_url" id="" class="form-control" placeholder="Enter instagram URL" value="<?= get_social_media()->instagram_url ?>">
                                    <span class="text-danger error-text instagram_url_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Youtube URL</label>
                                    <input type="text" name="youtube_url" id="" class="form-control" placeholder="Enter youtube URL" value="<?= get_social_media()->youtube_url ?>">
                                    <span class="text-danger error-text youtube_url_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Github URL</label>
                                    <input type="text" name="github_url" id="" class="form-control" placeholder="Enter github URL" value="<?= get_social_media()->github_url ?>">
                                    <span class="text-danger error-text github_url_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">LinkedIn URL</label>
                                    <input type="text" name="linkedin_url" id="" class="form-control" placeholder="Enter linkedin URL" value="<?= get_social_media()->linkedin_url ?>">
                                    <span class="text-danger error-text linkedin_url_error"></span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Change</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    // function general setting 
    $('#general_settings_form').on('submit', function(e) {
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
                //cek jika response error kosong
                if ($.isEmptyObject(response.error)) {
                    if (response.status == 1) {
                        alert(response.msg);
                    } else {
                        alert(response.msg);
                    }
                } else {
                    //jika ada validasi error modifikasi span error text
                    $.each(response.error, function(prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val);
                    });
                }
            }

        });
    });

    // funtion untuk blog logo 
    function readURL(input) {
        if (input.files && input.files[0]) {
            var name = $(input).attr('name');
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#preview_' + name).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#blog_logo').on('change', function() {
        readURL(this)
    })

    $('#update_blog_logo_form').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);

        var inputFileVar = $('#blog_logo').val();

        if (inputFileVar.length > 0) {

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

                    if (response.status == 1) {
                        alert(response.msg);
                        $(form)[0].reset();
                    } else {

                        alert(response.msg);
                    }
                }
            });
        } else {
            $(form).find('span.error-text').text('required');
        }
    });

    // fucntion untuk favicon 

    $('#blog_favicon').on('change', function() {
        readURL(this)
    })

    $('#update_blog_favicon_form').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);

        var inputFileVar = $('#blog_favicon').val();

        if (inputFileVar.length > 0) {

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
                    if (response.status == 1) {
                        alert(response.msg);
                        $(form)[0].reset();
                    } else {
                        alert(response.msg);
                    }
                }
            });

        } else {
            $(form).find('span.error-text').text('select favicon');
        }
    });

    //social media function
    $('#social_media_form').on('submit', function(e) {
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
                if ($.isEmptyObject(response.error)) {
                    if (response.status == 1) {
                        alert(response.msg);
                        $(form)[0].reset();
                    } else {
                        alert(response.msg);
                    }
                } else {
                    $.each(response.error, function(prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val)
                    })
                }
            }
        });
    });
</script>
<?php $this->endSection() ?>