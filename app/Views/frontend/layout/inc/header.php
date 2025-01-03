<header class="navigation">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light px-0">
            <a class="navbar-brand order-1 py-0" href="<?= route_to('/') ?>">
                <img loading="prelaod" decoding="async" class="img-fluid" src="/images/blog/<?= get_settings()->blog_logo ?>" alt="<?= get_settings()->blog_title ?>" style="max-height: 50px;">
            </a>
            <div class="navbar-actions order-3 ml-0 ml-md-4">
                <button aria-label="navbar toggler" class="navbar-toggler border-0" type="button" data-toggle="collapse"
                    data-target="#navigation"> <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <form action="<?= route_to('search-posts') ?>" method="get" class=" order-lg-3 order-md-2 order-3 ml-auto">
                <div class="input-group">
                    <div class="form-outline">
                        <input id="search-query" name="s" type="search" class="form-control" placeholder="Search..." autocomplete="off" value="<?= isset($search) ? $search : '' ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            <div class="collapse navbar-collapse text-center order-lg-2 order-4" id="navigation">
                <ul class="navbar-nav mx-auto mt-3 mt-lg-0">
                    <li class="nav-item"> <a class="nav-link" href="<?= route_to('/') ?>">Home</a>
                    </li>
                    <?php foreach (get_parent_categories() as $category): ?>
                        <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $category->name ?>
                            </a>
                            <div class="dropdown-menu">
                                <?php foreach (get_sub_categories($category->id) as $subcategory): ?>
                                    <a class="dropdown-item" href="<?= route_to('category-posts', $subcategory->slug) ?>"><?= $subcategory->name ?></a>
                                <?php endforeach; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                    <?php foreach (get_dependant_sub_categories() as $category): ?>
                        <li class="nav-item"> <a class="nav-link" href="<?= route_to('category-posts', $category->slug) ?>"><?= $category->name ?></a>
                        </li>
                    <?php endforeach; ?>
                    <li class="nav-item"> <a class="nav-link" href="<?= route_to('contact-us') ?>">Contact</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>