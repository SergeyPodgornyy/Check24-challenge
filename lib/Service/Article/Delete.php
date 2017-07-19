<?php

namespace Service\Article;

use Model\Article;
use Service\Base;
use Service\Validator;
use Service\X;

class Delete extends Base
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

        if ($article['author_id'] !== $this->getUserId()) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => [],
                'Message' => 'Access denied'
            ]);
        }

        if (!$article) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Article does not exists'
            ]);
        }

        if (!Article::delete(['Id' => [$params['Id']]])) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Cannot delete an Article'
            ]);
        }

        return [
            'Status'    => 1,
        ];
    }
}
