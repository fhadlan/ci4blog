<footer class="bg-dark mt-5">
    <div class="container section">
        <div class="row">
            <div class="col-lg-10 mx-auto text-center">
                <a class="d-inline-block mb-4 pb-2" href="<?= route_to('/') ?>">
                    <img loading="prelaod" decoding="async" class="img-fluid" src="/images/blog/<?= get_settings()->blog_logo ?>" alt="<?= get_settings()->blog_title ?>" style="max-height: 50px;">
                </a>
                <ul class="p-0 d-flex navbar-footer mb-0 list-unstyled">
                    <li class="nav-item my-0"> <a class="nav-link" href="about.html">About</a></li>
                    <li class="nav-item my-0"> <a class="nav-link" href="article.html">Elements</a></li>
                    <li class="nav-item my-0"> <a class="nav-link" href="privacy-policy.html">Privacy Policy</a></li>
                    <li class="nav-item my-0"> <a class="nav-link" href="terms-conditions.html">Terms Conditions</a></li>
                    <li class="nav-item my-0"> <a class="nav-link" href="404.html">404 Page</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="copyright bg-dark content">
        &copy; Copyright <?= date('Y') ?> All Rights Reserved
    </div>
</footer>