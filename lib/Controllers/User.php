<?php

namespace Controller;

class User extends Base
{
    public function index()
    {
        $data = $this->app->params();

        $this->run(function () use ($data) {
            return $this->action('Service\User\Index')->run($data);
        });
    }

    public function show($id)
    {
        $data = $this->app->params();
        $data['Id'] = $id;

        $this->run(function () use ($data) {
            return $this->action('Service\User\Show')->run($data);
        });
    }

    public function create()
    {
        $data = $this->app->params();

        $this->run(function () use ($data) {
            return $this->action('Service\User\Create')->run($data);
        });
    }

    public function update($id)
    {
        $data = $this->app->params();
        $data['Id'] = $id;

        $this->checkModifyPermissions($id);

        $this->run(function () use ($data) {
            $result = $this->action('Service\User\Update')->run($data);

            if ($result['User']['id'] === $_SESSION['UserId']) {
                $_SESSION['UserRole'] = $result['User']['role'];
                $_SESSION['UserName'] = $result['User']['name'];
                $_SESSION['UserEmail'] = $result['User']['email'];
            }

            return $result;
        });
    }

    public function delete($id)
    {
        $data['Id'] = $id;

        $this->run(function () use ($data) {
            return $this->action('Service\User\Delete')->run($data);
        });
    }

    private function checkModifyPermissions($userId)
    {
        if ($userId === $_SESSION['UserId']
            || $_SESSION['UserRole'] === 'admin'
            || $_SESSION['UserRole'] === 'superadmin') {
            return true;
        } else {
            $this->renderJSON([
                'Error' => ['Type' => 'ACCESS_DENIED'],
            ]);
        }
    }

    public function getShow($id)
    {
        $data = [
            'AuthorId'  => $id,
            'SortField' => 'created_at',
            'SortOrder' => 'desc',
            'Limit'     => 3,
        ];

        $res = $this->run(function () use ($data) {
            return $this->action(\Service\Article\Index::class)->run($data);
        }, true);

        $this->app->render('index.php', [
            'page'                  => 'users',
            'title'                 => 'Articles',
            'articles'              => $res['Status'] == 1 ? $res['Articles'] : [],
            'totalCountArticles'    => $res['Status'] == 1 ? $res['Total'] : 0,
            'countArticles'         => $res['Status'] == 1 ? $res['FilteredRecords'] : 0,
        ]);
    }
}
