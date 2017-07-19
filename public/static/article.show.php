<?php

require_once __DIR__ . '/inc/helpers.php';

$section = null;
$action = isset($action) ? $action : null;

if (isset($page)) {
    $section = $page;
} else {
    $page = $section;
}

if (!isset($article) || !$article) {
    header("location: /");
    exit;
}

include("inc/header.php");
?>

<div class="section page">
    <div class="wrapper">
        <?php // TODO: Add breadcrumbs ?>
        <div class="pull-right">
            <?php if ($article['author_id'] === $_SESSION['UserId']) : ?>
                <a href="/articles/<?= $article['id'] ?>/edit" type="button" class="btn btn-warning">
                    <span class="fa fa-pencil"></span> Edit data
                </a>
                <button type="button"
                        class="btn btn-danger"
                        id="delete-item"
                        data-id="<?= $article['id'] ?>"
                        style="width: 150px">
                    <span class="fa fa-trash-o fa-fw"></span> Delete article
                </button>
            <?php endif; ?>
        </div>

        <div class="blog-post">
            <h3 class="blog-post-title">
                <?= $article['title'] ?>
            </h3>
            <p class="blog-post-meta">Created at <?= $article['created_at'] ?></p>
            <p>
                <?= $article['text'] ?>
            </p>
            <p class="blog-post-meta">
                Author:
                <a href='/users/<?= $article['author_id'] ?>'>
                    <?= $article['author_name'] ?>
                </a>
            </p>
        </div>
    </div>
</div>

<h3 class="text-danger text-center">Unfortunately, comments not ready ;(</h3>

<div class="modal fade in" id="delete-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="false" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
                <h4 class="modal-title">
                    <span>Confirmation of item deletion</span>
                </h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to permanently delete this item?</p>
            </div>
            <input type="hidden" name="_method" value="delete" />
            <div class="modal-footer">
                <button class="btn btn-danger delete-btn">
                    <span class="fa fa-remove fa-fw"></span> Delete
                </button>
                <button class="btn btn-default close-btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include("inc/footer.php"); ?>
