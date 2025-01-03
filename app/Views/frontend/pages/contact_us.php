<?= $this->extend('frontend/layout/pages-layout'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="breadcrumbs mb-4"> <a href="/">Home</a>
            <span class="mx-1">/</span> <a href="#!">Contact</a>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="pr-0 pr-lg-4">
            <div class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labor.
                <div class="mt-5">
                    <p class="h3 mb-3 font-weight-normal"><a class="text-dark" href="mailto:<?= get_settings()->blog_email ?>"><?= get_settings()->blog_email ?></a>
                    </p>
                    <p class="mb-3"><a class="text-dark" href="tel:<?= get_settings()->blog_phone ?>"><?= get_settings()->blog_phone ?></a>
                    </p>
                    <p class="mb-2">Indonesia</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mt-4 mt-lg-0">
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success text-center col-12 mb-4">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger text-center col-12 mb-4">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= route_to('contact-us-send') ?>" class="row">
            <?= csrf_field() ?>
            <?php
            $validation =  \Config\Services::validation();
            ?>
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Name" name="name" id="name" value="<?= set_value('name') ?>">
                <span class="d-block text-danger mb-1">
                    <?= $validation->getError('name') ?  $validation->getError('name') : '&nbsp;' ?>
                </span>
            </div>
            <div class="col-md-6">
                <input type="email" class="form-control " placeholder="Email" name="email" id="email" value="<?= set_value('email') ?>">
                <span class="d-block text-danger mb-1">
                    <?= $validation->getError('email') ?  $validation->getError('email') : '&nbsp;' ?>
                </span>
            </div>
            <div class="col-12">
                <input type="text" class="form-control " placeholder="Subject" name="subject" id="subject" value="<?= set_value('subject') ?>">
                <span class="d-block text-danger mb-1">
                    <?= $validation->getError('subject') ? $validation->getError('subject') : '&nbsp;' ?>
                </span>
            </div>
            <div class="col-12">
                <textarea name="message" id="message" class="form-control " placeholder="Type Your Message Here" rows="5"><?= set_value('message') ?></textarea>
                <span class="d-block text-danger mb-1">
                    <?= $validation->getError('message') ? $validation->getError('message') : '&nbsp;' ?>
                </span>
            </div>
            <div class="col-12">
                <button class="btn btn-outline-primary" type="submit">Send Message</button>
            </div>

        </form>
    </div>
</div>
<?= $this->endSection(); ?>