<?php

namespace Service\Article;

use Model\Article;
use Model\User;
use Service\Base;
use Service\Validator;

class Index extends Base
{
    public function validate($params = array())
    {
        $rules = [
            'Search'    => ['trim', ['max_length' => 100]],
            'AuthorId'  => ['positive_integer'],
            'Limit'     => ['integer', ['min_number' => 0]],
            'Offset'    => ['integer', ['min_number' => 0]],
            'SortField' => ['one_of' => ['id', 'title', 'created_at']],
            'SortOrder' => ['one_of' => ['asc', 'desc']],
        ];

        return Validator::validate($params, $rules);
    }

    public function execute(array $params)
    {
        $params += [
            'Limit'     => 10,
            'Offset'    => 0,
            'SortField' => 'id',
            'SortOrder' => 'asc',
        ];

        $total = $filteredRecords = Article::count();

        if (isset($params['Search']) || isset($params['AuthorId'])) {
            $filteredRecords = Article::countFiltered($params);
            $articles = Article::search($params);
        } else {
            $articles = Article::index($params);
        }

        return [
            'Status'   => 1,
            'Articles' => array_map(function ($article) {
                return array_merge($article, [
                    'created_at'    => $article['created_at']
                        ? date('d.m.Y H:i', strtotime($article['created_at']))
                        : null,
                    'updated_at'    => $article['updated_at']
                        ? date('d.m.Y H:i', strtotime($article['updated_at']))
                        : null,
                    'author_name'   => User::findById($article['author_id'])['name'],
                ]);
            }, $articles),
            'Total'             => $total,
            'FilteredRecords'   => $filteredRecords,
        ];
    }
}
