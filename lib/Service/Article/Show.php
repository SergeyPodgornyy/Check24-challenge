<?php

namespace Service\Article;

use Model\Article;
use Model\User;
use Service\Base;
use Service\Validator;
use Service\X;

class Show extends Base
{
    public function validate(array $params)
    {
        $rules = [
            'Id'    => ['required', 'positive_integer'],
        ];

        return Validator::validate($params, $rules);
    }

    public function execute(array $params)
    {
        $article = Article::findById($params['Id']);

        if (!$article) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Article does not exists'
            ]);
        }

        return [
            'Status'    => 1,
            'Article'   => array_merge($article, [
                'created_at'    => $article['created_at']
                    ? date('d.m.Y H:i', strtotime($article['created_at']))
                    : null,
                'updated_at'    => $article['updated_at']
                    ? date('d.m.Y H:i', strtotime($article['updated_at']))
                    : null,
                'author_name'   => User::findById($article['author_id'])['name'],
            ]),
        ];
    }
}
