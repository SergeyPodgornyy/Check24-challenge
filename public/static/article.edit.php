<?php

require_once __DIR__ . '/inc/helpers.php';

$section = null;
$action = $action ?? null;

if (!isLogedIn()) {
    header('Location: /');
} elseif ($action !== 'create' && $_SESSION['UserId'] !== $item['author_id']) {
    header('Location: /articles');
}

if (isset($page)) {
    $section = $page;
} else {
    $page = $section;
}

include("inc/header.php");

?>

<div class="section page">
    <div class="wrapper">
        <h1><?= $title ?? '' ?></h1>
        <form data-id="<?= $item['id'] ?? '' ?>" class="article">
            <div class="form-group">
                <label for="title" class="control-label">
                    Title <span class="required">(required)</span>
                </label>
                <input type="text"
                       id="title"
                       class="form-control"
                       name="title"
                       <?= isset($item['title']) ? "value='{$item['title']}'" : ""; ?>>
            </div>
            <div class="form-group">
                <label for="text" class="control-label">
                    Text <span class="required">(required)</span>
                </label>
                <textarea class="form-control" id="text" name="text" cols="50" rows="10"><?= $item['text'] ?? "" ?></textarea>
            </div>
            <input type="submit" value="<?= isset($item) ? 'Update' : 'Publish' ?>">
        </form>
    </div>
</div>

<?php include("inc/footer.php"); ?>