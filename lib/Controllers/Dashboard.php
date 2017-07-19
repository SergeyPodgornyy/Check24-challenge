<?php

namespace Controller;

class Dashboard extends Base
{
    public function getIndex()
    {
        $data = [
            'SortField' => 'created_at',
            'SortOrder' => 'desc',
            'Limit'     => 3,
        ];

        $res = $this->run(function () use ($data) {
            return $this->action(\Service\Article\Index::class)->run($data);
        }, true);

        $this->app->render('index.php', [
            'title'                 => 'Home',
            'articles'              => $res['Status'] == 1 ? $res['Articles'] : [],
            'totalCountArticles'    => $res['Status'] == 1 ? $res['Total'] : 0,
            'countArticles'         => $res['Status'] == 1 ? $res['FilteredRecords'] : 0,
        ]);
    }
}
