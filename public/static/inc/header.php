<?php
    require_once __DIR__ . '/helpers.php';
    $pageTitle = "Personal Blog";
    $pageTitle .= isset($title) ? ' | ' . $title : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $pageTitle; ?></title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Blog - test coding challenge for Check24">
    <meta name="author" content="Sergey Podgornyy">

    <link rel="stylesheet" type="text/css" href="/static/vendor/components-font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/static/vendor/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/static/vendor/summernote/dist/summernote.css">
    <link rel="stylesheet" type="text/css" href="/static/css/style.css">

    <script type="text/javascript" src="/static/vendor/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="/static/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/static/vendor/summernote/dist/summernote.min.js"></script>
</head>
<body>
    <div class="header">
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">Personal Blog</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li <?= $page == 'home' ? 'class="active"' : '' ?>>
                            <a href="/">Home</a>
                        </li>
                        <?php if (isLogedIn()) : ?>
                            <li <?= $page == 'articles' ? 'class="active"' : '' ?>>
                                <a href="/articles/create/">Add Entry</a>
                            </li>
                            <li>
                                <a id="logout">Log Out</a>
                            </li>
                        <?php else: ?>
                            <li <?= $page == 'login' ? 'class="active"' : '' ?>>
                                <a href="/login">Login</a>
                            </li>
                            <li <?= $page == 'register' ? 'class="active"' : '' ?>>
                                <a href="/register">Sign Up</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
    </div>
    <div id="content" data-page="<?= $page; ?>" data-action="<?= $action ?>">