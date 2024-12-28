<div class="col-lg-12 col-md-6">
    <div class="widget">
        <h2 class="section-title mb-3">Categories</h2>
        <div class="widget-body">
            <ul class="widget-list">
                <?php foreach (get_sidebar_sub_categories() as $subcategory) : ?>
                    <li><a href="<?= route_to('category-posts', $subcategory->slug) ?>"><?= $subcategory->name ?><span class="ml-auto">(<?= $subcategory->number_of_posts ?>)</span></a>
                    <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>