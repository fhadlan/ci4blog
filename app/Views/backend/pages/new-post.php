<?php $this->extend('backend/layout/page-layout'); ?>
<?php $this->section('content') ?>
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4><?= $pageTitle ?></h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= route_to('admin.home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= $pageTitle ?>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="" class="btn btn-primary">View All Posts</a>
        </div>
    </div>
</div>

<form action="" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name=<?= csrf_token() ?> value="<?= csrf_hash() ?>">
    <div class="row">
        <div class="col-md-9">
            <div class="card card-box mb-2">
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter title">
                        <span class="text-danger error-text title_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="content" class="form-control" placeholder="Enter content"></textarea>
                        <span class="text-danger error-text content_error"></span>
                    </div>
                </div>
            </div>
            <div class="card card-box mb2">
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Post Meta Keyword<small>(Comma separated)</small></label>
                        <input type="text" name="meta_keywords" class="form-control" placeholder="Enter meta keyword">
                    </div>
                    <div class="form-group">
                        <label for="">Post Meta Description</label>
                        <textarea name="meta_description" class="form-control" placeholder="Enter meta description"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-box mb-2">
                <div class="card-body">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category->id ?>"><?= $category->name ?></option>
                            <?php endforeach ?>
                        </select>
                        <span class="text-danger error-text category_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control-file form-control" height="auto">
                        <span class="text-danger error-text image_error"></span>
                    </div>
                    <div class="d-block-mb-3" style="max-width: 250px">
                        <img id="preview_image" src="" alt="" class="img-thumbnail">
                    </div>
                    <div class="form-group">
                        <label for="tags">Tags</label>
                        <input type="text" name="tags" class="form-control" placeholder="Enter tags">
                        <span class="text-danger error-text tags_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="status">Visibility</label>
                        <div class="custom-control custom-radio mb-5">
                            <input type="radio" id="customRadio1" name="visibility" value="1" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio1">Public</label>
                        </div>
                        <div class="custom-control custom-radio mb-5">
                            <input type="radio" id="customRadio2" name="visibility" value="0" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio2">Private</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary mt-3">Save Post</button>
    </div>
</form>
<?php $this->endSection() ?>