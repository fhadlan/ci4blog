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
                        Posts
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a class="btn btn-primary" href="<?= route_to('new-post') ?>" role="button">
                Make a new post
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card card-box">
            <div class="card-header">
                <div class="clearfix">
                    <div class="pull-left">All Posts</div>
                    <div class="pull-right"></div>
                </div>
            </div>
            <div class="card-body">
                <table class="data-table table stripe hover noWrap dataTable no-footer dtr-inline collapsed" id="posts_table">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">ID</th>
                            <th class="text-center" scope="col">Image</th>
                            <th class="text-center" scope="col">Title</th>
                            <th class="text-center" scope="col">Category</th>
                            <th class="text-center" scope="col">Visibility</th>
                            <th class="text-center" scope="col">Action</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>

<?php $this->section('stylesheets') ?>
<!-- datatable stylesheets -->
<link rel="stylesheet" href="/backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/backend/src/plugins/datatables/css/responsive.bootstrap4.min.css">
<?php $this->endSection() ?>


<?php $this->section('scripts') ?>
<!-- datatable scripts -->
<script src="/backend/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="/backend/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>

<script>

</script>
<?php $this->endSection() ?>