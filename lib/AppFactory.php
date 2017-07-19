<?php

class AppFactory
{
    public static $instance;

    public static function create($config)
    {
        // Prepare app
        $app = new \Framework\App($config['frameworkOptions']);
        $app->config = $config;

        // Prepare middleware
        $sessions = new \Controller\Session($app);
        $isAuth = [$sessions, 'check'];
        $isAdminOrSuper = [$sessions, 'checkAdminOrSuper'];
        $isSuper = [$sessions, 'checkSuper'];
        $isAuthOrReferer = [$sessions, 'checkAuthOrReferer'];
        $token = new \Controller\Token($app);
        $hasPermission = [$token, 'check'];

        // Define routes
        $dashboard = new \Controller\Dashboard($app);
        $app->get('/', [$dashboard, 'getIndex']);
        $app->get('/login', function () use ($app) {
            $app->render('login.php', ['title' => 'Login']);
        });
        $app->get('/register', function () use ($app) {
            $app->render('register.php', ['title' => 'Register']);
        });

        $article = new \Controller\Article($app);
        $app->get('/articles/', [$dashboard, 'getIndex']);
        $app->get('/articles/create/', [$article, 'getCreate']);
        $app->get('/articles/:id', [$article, 'getShow']);
        $app->get('/articles/:id/edit', [$article, 'getEdit']);

        $user = new \Controller\User($app);
        $app->get('/users/:id', [$user, 'getShow']);

        // Define API routes
        $app->get('/api/articles/', [$article, 'index']);
        $app->get('/api/articles/:id', [$article, 'show']);
        $app->post('/api/articles/', $isAuth, [$article, 'create']);
        $app->post('/api/articles/:id', $isAuth, [$article, 'update']);
        $app->delete('/api/articles/:id', $isAuth, [$article, 'delete']);

        $app->post('/api/users', $isAuthOrReferer, [$user, 'create']);
        $app->post('/api/users/:id', $isAuth, [$user, 'update']);

        $app->post('/api/session', [$sessions, 'create']);
        $app->delete('/api/session', $isAuth, [$sessions, 'delete']);

        return self::$instance = $app;
    }
}
