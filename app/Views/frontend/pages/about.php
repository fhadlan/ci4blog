<?= $this->extend('frontend/layout/pages-layout'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-lg-8 ">
        <div class="breadcrumbs mb-4"> <a href="<?= route_to('/') ?>">Home</a>
            <span class="mx-1">/</span> <a href="#">About</a>
        </div>
    </div>
    <div class="col-lg-8 mx-auto mb-5 mb-lg-0">
        <img loading="lazy" decoding="async" src="images/users/<?= $user->picture ?>" class="img-fluid w-100 mb-4" alt="Author Image">
        <h1 class="mb-4"><?= $user->name ?></h1>
        <div class="content">
            <?= $user->bio ?>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="widget-blocks">
            <div class="row">
                <?php include('partial/sidebar_about_me.php') ?>
                <?php include('partial/sidebar_latest_post.php') ?>
                <?php include('partial/sidebar-subcategories.php') ?>
                <?php include('partial/sidebar_tags.php') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>