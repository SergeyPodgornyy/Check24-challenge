<?php

require_once __DIR__ . '/inc/helpers.php';

$action = null;
$page = $page ?? 'home';

$articles = $articles ?? [];

include("inc/header.php");

?>
        <div class="row">
            <h2>The newest articles you'll find below</h2>
            <div class="col-sm-12 blog-main">
                <?php foreach ($articles as $article) : ?>
                    <div class="blog-post">
                        <h3 class="blog-post-title">
                            <a href="/articles/<?= $article['id'] ?>">
                                <?= $article['title'] ?>
                            </a>
                        </h3>
                        <p class="blog-post-meta">Created at <?= $article['created_at'] ?></p>
                        <p>
                            <?= strLimit(strip_tags($article['text']), 1000) ?>
                        </p>
                        <p class="blog-post-meta">
                            Author:
                            <a href='/users/<?= $article['author_id'] ?>'>
                                <?= $article['author_name'] ?>
                            </a>
                        </p>
                    </div>
                    <hr>
                <?php endforeach; ?>
            </div>
            <?php if(isset($totalCountArticles) && $totalCountArticles > 3) : ?>
                <button type="button" class="btn btn-primary btn-lg btn-block load-more">Load more articles</button>
            <?php endif; ?>
        </div>

<?php include("inc/footer.php"); ?>
