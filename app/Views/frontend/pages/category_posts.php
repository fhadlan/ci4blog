<?= $this->extend('frontend/layout/pages-layout'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="breadcrumbs mb-4"> <a href="<?= route_to('/') ?>">Home</a>
            <span class="mx-1">/</span> <a href="#!">Articles</a>
            <span class="mx-1">/</span> <a href="#!">Travel</a>
        </div>
        <h1 class="mb-4 border-bottom border-primary d-inline-block"><?= $pageTitle; ?></h1>
    </div>
    <div class="col-lg-8 mb-5 mb-lg-0">
        <div class="row">
            <?php foreach ($posts as $post) : ?>
                <div class="col-md-6 mb-4">
                    <article class="card article-card article-card-sm h-100">
                        <a href="<?= route_to('read-post', $post->slug) ?>">
                            <div class="card-image">
                                <div class="post-info"> <span class="text-uppercase"><?= date_formatter($post->created_at) ?></span>
                                    <span class="text-uppercase"><?= get_reading_time($post->content) ?></span>
                                </div>
                                <img loading="lazy" decoding="async" src="/images/posts/thumb_<?= $post->image ?>" alt="Post Thumbnail" class="w-100" width="420" height="280">
                            </div>
                        </a>
                        <div class="card-body px-0 pb-0">

                            <h2><a class="post-title" href="<?= route_to('read-post', $post->slug) ?>"><?= $post->title ?></a></h2>
                            <p class="card-text"><?= limit_words($post->content, 20) ?></p>
                            <div class="content"> <a class="read-more-btn" href="<?= route_to('read-post', $post->slug) ?>">Read Full Article</a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
        <div>
            <?= $pager->links('default', 'custom_pagination') ?>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="widget-blocks">
            <div class="row">
                <div class="col-lg-12">
                    <div class="widget">
                        <div class="widget-body">
                            <img loading="lazy" decoding="async" src="/frontend/images/author.jpg" alt="About Me" class="w-100 author-thumb-sm d-block">
                            <h2 class="widget-title my-3">Hootan Safiyari</h2>
                            <p class="mb-3 pb-2">Hello, I’m Hootan Safiyari. A Content writter, Developer and Story teller. Working as a Content writter at CoolTech Agency. Quam nihil …</p> <a href="about.html" class="btn btn-sm btn-outline-primary">Know
                                More</a>
                        </div>
                    </div>
                </div>
                <?php include('partial/sidebar_latest_post.php') ?>
                <?php include('partial/sidebar-subcategories.php') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>