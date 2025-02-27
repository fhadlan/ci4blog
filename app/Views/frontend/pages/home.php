<?= $this->extend('frontend/layout/pages-layout'); ?>
<?= $this->section('page_meta'); ?>
<meta name="robots" content="index,follow" />
<meta name="title" content="<?= get_settings()->blog_title ?>" />
<meta name="description" content="<?= get_settings()->blog_meta_description ?>" />
<meta name="author" content="<?= get_settings()->blog_title ?>" />
<link rel="canonical" href="<?= base_url() ?>" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?= get_settings()->blog_title ?>" />
<meta property="og:description" content="<?= get_settings()->blog_meta_description ?>" />
<meta property="og:url" content="<?= base_url() ?>" />
<meta property="og:image" content="<?= base_url('images/blog/' . get_settings()->blog_logo) ?>" />
<meta name="twitter:domain" content="<?= base_url() ?>" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" property="og:title" itemprop="name" content="<?= get_settings()->blog_title ?>" />
<meta name="twitter:description" property="og:description" itemprop="description" content="<?= get_settings()->blog_meta_description ?>" />
<meta name="twitter:image" content="<?= base_url('images/blog/' . get_settings()->blog_logo) ?>" />
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<div class="row no-gutters-lg">
    <div class="col-12">
        <h2 class="section-title">Latest Articles</h2>
    </div>
    <div class="col-lg-8 mb-5 mb-lg-0">
        <div class="row">
            <div class="col-12 mb-4">
                <article class="card article-card">
                    <a href="<?= route_to('read-post', get_home_main_latest_posts()->slug) ?>">
                        <div class="card-image">
                            <div class="post-info"> <span class="text-uppercase"><?= date_formatter(get_home_main_latest_posts()->created_at) ?></span>
                                <span class="text-uppercase"><?= get_reading_time(get_home_main_latest_posts()->content) ?></span>
                            </div>
                            <img loading="lazy" decoding="async" src="/images/posts/resized_<?= get_home_main_latest_posts()->image ?>" alt="Post Thumbnail" class="w-100">
                        </div>
                    </a>
                    <div class="card-body px-0 pb-1">
                        <ul class="post-meta mb-2">
                            <?php foreach (explode(',', get_home_main_latest_posts()->tags) as $tag) : ?>
                                <li> <a href="<?= route_to('tag-posts', urlencode($tag)) ?>"><?= $tag ?></a>
                                <?php endforeach; ?>
                        </ul>
                        <h2 class="h1"><a class="post-title" href="<?= route_to('read-post', get_home_main_latest_posts()->slug) ?>"><?= get_home_main_latest_posts()->title ?></a></h2>
                        <p class="card-text"><?= limit_words(get_home_main_latest_posts()->content, 20) ?></p>
                        <div class="content"> <a class="read-more-btn" href="<?= route_to('read-post', get_home_main_latest_posts()->slug) ?>">Read Full Article</a>
                        </div>
                    </div>
                </article>
            </div>

            <?php if (count(get_6_home_latest_posts()) > 0): ?>
                <?php foreach (get_6_home_latest_posts() as $post): ?>
                    <div class="col-md-6 mb-4">
                        <article class="card article-card article-card-sm h-100">
                            <a href="<?= route_to('read-post', $post->slug) ?>">
                                <div class="card-image">
                                    <div class="post-info"> <span class="text-uppercase"><?= date_formatter($post->created_at) ?></span>
                                        <span class="text-uppercase"><?= get_reading_time($post->content) ?></span>
                                    </div>
                                    <img loading="lazy" decoding="async" src="/images/posts/resized_<?= $post->image ?>" alt="Post Thumbnail" class="w-100">
                                </div>
                            </a>
                            <div class="card-body px-0 pb-0">
                                <ul class="post-meta mb-2">
                                    <?php foreach (explode(',', $post->tags) as $tag) : ?>
                                        <li> <a href="<?= route_to('tag-posts', urlencode($tag)) ?>"><?= $tag ?></a>
                                        <?php endforeach; ?>
                                </ul>
                                <h2><a class="post-title" href="<?= route_to('read-post', $post->slug) ?>"><?= $post->title ?></a></h2>
                                <p class="card-text"><?= limit_words($post->content, 20) ?></p>
                                <div class="content"> <a class="read-more-btn" href="<?= route_to('read-post', $post->slug) ?>">Read Full Article</a>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <nav class="mt-4">
                            <!-- pagination -->
                            <nav class="mb-md-50">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item">
                                        <a class="page-link" href="#!" aria-label="Pagination Arrow">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                                            </svg>
                                        </a>
                                    </li>
                                    <li class="page-item active "> <a href="index.html" class="page-link">
                                            1
                                        </a>
                                    </li>
                                    <li class="page-item"> <a href="#!" class="page-link">
                                            2
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#!" aria-label="Pagination Arrow">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"></path>
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="widget-blocks">
            <div class="row">
                <?php include('partial/sidebar_about_me.php') ?>
                <div class="col-lg-12 col-md-6">
                    <div class="widget">
                        <h2 class="section-title mb-3">Random Posts</h2>
                        <div class="widget-body">
                            <div class="widget-list">
                                <?php if (count(get_sidebar_random_posts()) >= 4) :
                                    foreach (get_sidebar_random_posts() as $post) : ?>
                                        <a class="media align-items-center" href="<?= route_to('read-post', $post->slug) ?>">
                                            <img loading="lazy" decoding="async" src="/images/posts/thumb_<?= $post->image ?>" alt="Post Thumbnail" class="w-100">
                                            <div class="media-body ml-3">
                                                <h3 style="margin-top:-5px"><?= $post->title ?></h3>
                                                <p class="mb-0 small"><?= limit_words($post->content, 10) ?> </p>
                                            </div>
                                        </a>
                                <?php endforeach;
                                endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include('partial/sidebar-subcategories.php') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>