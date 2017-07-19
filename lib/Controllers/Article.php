<?php

namespace Controller;

class Article extends Base
{
    // API goes here
    public function index()
    {
        $data = $this->app->params();

        $this->run(function () use ($data) {
            return $this->action(\Service\Article\Index::class)->run($data);
        });
    }

    public function show($id)
    {
        $data = $this->app->params();
        $data['Id'] = $id;

        $this->run(function () use ($data) {
            return $this->action(\Service\Article\Show::class)->run($data);
        });
    }

    public function create()
    {
        $data = $this->app->params();

        $this->run(function () use ($data) {
            return $this->action(\Service\Article\Create::class)->run($data);
        });
    }

    public function update($id)
    {
        $data = $this->app->params();
        $data['Id'] = $id;

        $this->run(function () use ($data) {
            return $this->action(\Service\Article\Update::class)->run($data);
        });
    }

    public function delete($id)
    {
        $data['Id'] = $id;

        $this->run(function () use ($data) {
            return $this->action(\Service\Article\Delete::class)->run($data);
        });
    }

    // Static pages goes here
    public function getIndex()
    {
        $data = $this->app->params();

        $res = $this->run(function () use ($data) {
            return $this->action(\Service\Article\Index::class)->run($data);
        }, true);

        $this->app->render('catalog.php', [
            'page'      => 'articles',
            'title'     => 'Articles',
            'articles'  => $res['Status'] == 1 ? $res['Articles'] : [],
        ]);
    }

    public function getShow($id)
    {
        $data = $this->app->params();
        $data['Id'] = $id;

        $res = $this->run(function () use ($data) {
            return $this->action(\Service\Article\Show::class)->run($data);
        }, true);

        $this->app->render('article.show.php', [
            'page'      => 'articles',
            'action'    => 'show',
            'title'     => $res['Status'] == 1 ? $res['Article']['title'] : '',
            'article'   => $res['Status'] == 1 ? $res['Article'] : [],
        ]);
    }

    public function getCreate()
    {
        $this->app->render('article.edit.php', [
            'page'      => 'articles',
            'action'    => 'create',
            'title'     => 'Insert new article',
        ]);
    }

    public function getEdit($id)
    {
        $data['Id'] = $id;

        $item = $this->run(function () use ($data) {
            return $this->action(\Service\Article\Show::class)->run($data);
        }, true);

        $this->app->render('article.edit.php', [
            'page'      => 'articles',
            'action'    => 'update',
            'title'     => $item['Status'] == 1 ? $item['Article']['title'] : '',
            'item'      => $item['Status'] == 1 ? $item['Article'] : [],
        ]);
    }
}