<div class="col-lg-12">
    <div class="widget">
        <div class="widget-body">
            <?php $about_me = get_about_me() ?>
            <img loading="lazy" decoding="async" src="/images/users/<?= $about_me->picture ?>" alt="About Me" class="w-100 author-thumb-sm d-block">
            <h2 class="widget-title my-3"><?= $about_me->name ?></h2>
            <p class="mb-3 pb-2"><?= limit_words($about_me->bio, 20) ?></p> <a href="<?= route_to('about') ?>" class="btn btn-sm btn-outline-primary">Know
                More</a>
        </div>
    </div>
</div>