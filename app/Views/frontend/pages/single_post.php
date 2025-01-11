<?= $this->extend('frontend/layout/pages-layout'); ?>
<?= $this->section('page_meta'); ?>
<meta name="keywords" content="<?= $post->meta_keywords ?>" />
<meta name="description" content="<?= $post->meta_description ?>" />
<link rel="canonical" href="<?= current_url() ?>" />
<meta itemprop="name" content="<?= $post->title ?>" />
<meta itemprop="description" content="<?= $post->meta_description ?>" />
<meta itemprop="image" content="<?= base_url('images/posts/' . $post->image) ?>" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?= $post->title ?>" />
<meta property="og:description" content="<?= $post->meta_description ?>" />
<meta property="og:image" content="<?= base_url('images/posts/' . $post->image) ?>" />
<meta property="og:url" content="<?= current_url() ?>" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:domain" content="<?= base_url() ?>" />
<meta name="twitter:title" property="og:title" content="<?= $post->title ?>" />
<meta name="twitter:description" property="og:description" content="<?= $post->meta_description ?>" />
<meta name="twitter:image" property="og:image" content="<?= base_url('images/posts/' . $post->image) ?>" />
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-lg-8 mb-5 mb-lg-0">
        <article>
            <img loading="lazy" decoding="async" src="/images/posts/<?= $post->image ?>" alt="Post Thumbnail" class="w-100">
            <ul class="post-meta mb-2 mt-4">
                <li>
                    <i class="bi bi-calendar"></i><span><?= date_formatter($post->created_at) ?></span>
                </li>
            </ul>
            <h1 class="my-3"><?= $post->title ?></h1>
            <ul class="post-meta mb-4">
                <?php
                foreach (explode(',', $post->tags) as $tag) : ?>
                    <li> <a href="<?= route_to('tag-posts', urlencode($tag)) ?>"><?= $tag ?></a></li>
                <?php endforeach; ?>
            </ul>
            <div class="content text-left">
                <?= $post->content ?>
            </div>
        </article>

        <div class="prev-next-posts mt-5">
            <div class="row justify-content-between p-4">
                <div class="col-md-6 mb-2 shadow-sm rounded p-3">
                    <a href="<?= route_to('read-post', get_prev_post($post->id)->slug) ?>">
                        <h4>&#171; Previous Post</h4>
                        <p class="text-primary"><?= get_prev_post($post->id)->title ?></p>
                    </a>
                </div>
                <div class="col-md-6 mb-2 text-right shadow-sm rounded p-3">
                    <a href="<?= route_to('read-post', get_next_post($post->id)->slug) ?>">
                        <h4>Next Post &#187;</h4>
                        <p class="text-primary"><?= get_next_post($post->id)->title ?></p>
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <div class="widget">
                <h2 class="widget-title">Related Posts</h2>
                <div class="widget-body">
                    <div class="widget-list">
                        <?php
                        foreach (get_related_posts($post->id, $post->tags) as $rpost) : ?>
                            <a class="media align-items-center" href="<?= route_to('read-post', $rpost->slug) ?>">
                                <img loading="lazy" decoding="async" src="/images/posts/thumb_<?= $rpost->image ?>" alt="Post Thumbnail" class="w-100">
                                <div class="media-body ml-3">
                                    <h3 style="margin-top:-5px"><?= $rpost->title ?></h3>
                                    <p class="mb-0 small"><?= limit_words($rpost->content, 10) ?> </p>
                                </div>
                            </a>
                        <?php endforeach;
                        ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <div id="disqus_thread"></div>
            <script>
                /**
                 *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                 *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
                /*
                var disqus_config = function () {
                this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                };
                */

                document.addEventListener('DOMContentLoaded', function() {
                    var d = document,
                        s = d.createElement('script');
                    s.src = 'https://fadlan-1.disqus.com/embed.js';
                    s.setAttribute('data-timestamp', +new Date());
                    (d.head || d.body).appendChild(s);
                });
            </script>
            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
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

<?= $this->section('stylesheets') ?>
<link rel="stylesheet" href="/socialshare/jquery.floating-social-share.min.css" />
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="/socialshare/jquery.floating-social-share.min.js"></script>
<script>
    $("body").floatingSocialShare({
        buttons: [
            "facebook", "linkedin", "pinterest", "reddit",
            "telegram", "tumblr", "twitter", "viber", "vk", "whatsapp"
        ],
        text: "share with: ",
        url: "<?= current_url() ?>",
    });
</script>
<?= $this->endSection() ?>