<div class="col-lg-12 col-md-6">
    <div class="widget">
        <h2 class="section-title mb-3">Latest Posts</h2>
        <div class="widget-body">
            <div class="widget-list">
                <?php foreach (get_sidebar_latest_posts() as $post) : ?>
                    <a class="media align-items-center" href="<?= route_to('read-post', $post->slug) ?>">
                        <img loading="lazy" decoding="async" src="/images/posts/thumb_<?= $post->image ?>" alt="Post Thumbnail" class="w-100">
                        <div class="media-body ml-3">
                            <h3 style="margin-top:-5px"><?= $post->title ?></h3>
                            <p class="mb-0 small"><?= limit_words($post->content, 10) ?> </p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>