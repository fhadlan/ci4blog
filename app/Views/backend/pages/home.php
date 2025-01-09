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
                        Dashboard
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row pb-10">
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark"><?= $numberOfPosts ?></div>
                    <div class="font-14 text-secondary weight-500">
                        Posts
                    </div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#00eccf" style="color: rgb(0, 236, 207);">
                        <i class="icon-copy dw dw-newspaper"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark"><?= $numberOfSubCategories ?></div>
                    <div class="font-14 text-secondary weight-500">
                        Sub Categories
                    </div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#ff5b5b" style="color: rgb(255, 91, 91);">
                        <span class="icon-copy dw dw-list"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-sm-12">
        chart here
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="card-box mb-30">
            <h5 class="pd-20 h5 mb-0">Categories</h5>
            <div class="list-group">
                <?php foreach ($categories as $category) : ?>
                    <span class="list-group-item d-flex align-items-center justify-content-between">
                        <?= $category->name ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="card-box mb-30">
            <h5 class="pd-20 h5 mb-0">Latest Post</h5>
            <div class="latest-post">
                <ul>
                    <?php foreach ($latestPosts as $post) : ?>
                        <li>
                            <h4>
                                <a href="<?= route_to('read-post', $post->slug) ?>"><?= $post->title ?></a>
                            </h4>
                            <span><?= $post->name ?></span>
                        </li>
                    <?php endforeach; ?>

                </ul>
            </div>
        </div>

    </div>
</div>
<?php $this->endSection() ?>