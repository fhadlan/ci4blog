<?= $this->extend('frontend/layout/pages-layout'); ?>
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
                <?php foreach (explode(',', $post->tags) as $tag) : ?>
                    <li> <a href="<?= route_to('tag-posts', urlencode($tag)) ?>"><?= $tag ?></a></li>
                <?php endforeach; ?>
            </ul>
            <div class="content text-left">
                <?= $post->content ?>
            </div>
        </article>
        <div class="mt-5">
            <div id="disqus_thread"></div>
            <script type="application/javascript">
                var disqus_config = function() {



                };
                (function() {
                    if (["localhost", "127.0.0.1"].indexOf(window.location.hostname) != -1) {
                        document.getElementById('disqus_thread').innerHTML = 'Disqus comments not available by default when the website is previewed locally.';
                        return;
                    }
                    var d = document,
                        s = d.createElement('script');
                    s.async = true;
                    s.src = '//' + "themefisher-template" + '.disqus.com/embed.js';
                    s.setAttribute('data-timestamp', +new Date());
                    (d.head || d.body).appendChild(s);
                })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a>
            </noscript>
            <a href="https://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="widget-blocks">
            <div class="row">
                <div class="col-lg-12">
                    <div class="widget">
                        <div class="widget-body">
                            <img loading="lazy" decoding="async" src="images/author.jpg" alt="About Me" class="w-100 author-thumb-sm d-block">
                            <h2 class="widget-title my-3">Hootan Safiyari</h2>
                            <p class="mb-3 pb-2">Hello, I’m Hootan Safiyari. A Content writter, Developer and Story teller. Working as a Content writter at CoolTech Agency. Quam nihil …</p> <a href="about.html" class="btn btn-sm btn-outline-primary">Know
                                More</a>
                        </div>
                    </div>
                </div>

                <?php include('partial/sidebar_latest_post.php') ?>
                <?php include('partial/sidebar-subcategories.php') ?>
                <?php include('partial/sidebar_tags.php') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>