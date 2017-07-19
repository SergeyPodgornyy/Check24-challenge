<?php

namespace Service\Article;

use Model\Article;
use Service\Base;
use Service\Validator;

class Create extends Base
{
    public function validate(array $params)
    {
        $rules = [
            'Title' => ['required', ['max_length' => 255]],
            'Text'  => ['required'],
        ];

        return Validator::validate($params, $rules);
    }
    public function execute(array $params)
    {
        $params += [
            'Title'     => '',
            'Text'      => '',
            'UserId'    => $this->getUserId(),
        ];

        $bookId = Article::create($params);

        return [
            'Status'    => 1,
            'ArticleId' => $bookId,
        ];
    }
}
