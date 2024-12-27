<!-- app/Views/frontend/pages/partial/custom_pagination.php -->
<?php if ($pager): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($pager->hasPreviousPage()): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $pager->getFirst() ?>" aria-label="First">
                        <span aria-hidden="true">First</span>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="<?= $pager->getPreviousPage() ?>" aria-label="Previous">
                        <span aria-hidden="true">&#x2190;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php foreach ($pager->links() as $link): ?>
                <li class="page-item<?= $link['active'] ? ' active' : '' ?>">
                    <a class="page-link" href="<?= $link['uri'] ?>">
                        <?= $link['title'] ?>
                    </a>
                </li>
            <?php endforeach; ?>

            <?php if ($pager->hasNextPage()): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $pager->getNextPage() ?>" aria-label="Next">
                        <span aria-hidden="true">&#x2192;</span>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="<?= $pager->getLast() ?>" aria-label="Last">
                        <span aria-hidden="true">Last</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <p class="text-center">
        Page <?= $pager->getCurrentPageNumber() ?> of <?= $pager->getPageCount() ?>
    </p>
<?php endif; ?>