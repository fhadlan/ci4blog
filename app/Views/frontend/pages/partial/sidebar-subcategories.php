<div class="widget-body">
    <ul class="widget-list">
        <?php foreach (get_sidebar_sub_categories() as $subcategory) : ?>
            <li><a href="<?= route_to('category-posts', $subcategory->slug) ?>"><?= $subcategory->name ?><span class="ml-auto">(<?= $subcategory->number_of_posts ?>)</span></a>
            <?php endforeach; ?>
    </ul>
</div>