<?php
use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<style>
.architect-pagination-container {
    display: inline-flex;
    align-items: center;
    border: 1px solid #dcdfe6;
    border-radius: 6px;
    background-color: #ffffff;
    overflow: hidden;
    padding: 0;
    margin: 0;
    list-style: none;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
}

.architect-pagination-container .page-item {
    display: flex;
    margin: 0;
    padding: 0;
    border-right: 1px solid #dcdfe6;
}

.architect-pagination-container .page-item:last-child {
    border-right: none;
}

.architect-pagination-container .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 38px;
    min-width: 38px;
    padding: 0 14px;
    font-size: 14px;
    font-weight: 500;
    color: #007bff;
    background-color: #ffffff;
    border: none !important;
    border-radius: 0 !important;
    text-decoration: none;
    transition: background-color 0.15s ease, color 0.15s ease;
    box-shadow: none !important;
    outline: none !important;
    line-height: 1;
}

.architect-pagination-container .page-item.active .page-link {
    background-color: #007bff !important;
    color: #ffffff !important;
    font-weight: 600;
}

.architect-pagination-container .page-item:not(.active):not(.disabled) .page-link:hover {
    background-color: #f8fafc !important;
    color: #0056b3 !important;
}

.architect-pagination-container .page-item.disabled .page-link {
    color: #a0aec0 !important;
    background-color: #ffffff !important;
    cursor: not-allowed;
}
</style>

<nav aria-label="Page navigation">
    <ul class="pagination architect-pagination-container mb-0">
        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item">
                <a href="<?= $pager->getPrevious() ?>" class="page-link" aria-label="Previous">Previous</a>
            </li>
        <?php else : ?>
            <li class="page-item disabled">
                <span class="page-link">Previous</span>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a href="<?= $link['uri'] ?>" class="page-link">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li class="page-item">
                <a href="<?= $pager->getNext() ?>" class="page-link" aria-label="Next">Next</a>
            </li>
        <?php else : ?>
            <li class="page-item disabled">
                <span class="page-link">Next</span>
            </li>
        <?php endif ?>
    </ul>
</nav>
