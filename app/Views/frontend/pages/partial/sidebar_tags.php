<div class="col-lg-12 col-md-6">
    <div class="widget">
        <h2 class="section-title mb-3">Tags</h2>
        <div class="widget-body">
            <ul class="widget-list">
                <?php foreach (get_sidebar_tags() as $tag) : ?>
                    <li><a href="<?= route_to('tag-posts', urlencode($tag)) ?>"><?= $tag ?><span class="ml-auto"></span></a>
                    <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>