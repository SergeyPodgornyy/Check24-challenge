<?php
namespace Service\Article;

use Model\Article;
use Model\Utils\Transaction;
use Service\Base;
use Service\Validator;
use Service\X;

class Update extends Base
{
    public function validate(array $params)
    {
        $rules = [
            'Id'        => ['required', 'positive_integer'],
            'Title'     => ['required', ['max_length' => 100]],
            'Text'      => ['required'],
        ];

        return Validator::validate($params, $rules);
    }

    public function execute(array $params)
    {
        $params += [
            'Title'     => '',
            'Text'      => '',
        ];

        $article = Article::findById($params['Id']);

        if (!$article) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Article does not exists'
            ]);
        }

        try {
            Transaction::beginTransaction();

            // ============= Update Article data ==========================
            $updatedArticle = array_merge(
                Article::toCamelCase($article),
                $params
            );
            Article::update($params['Id'], $updatedArticle);

            // =========== End Update Article data ========================
            Transaction::commitTransaction();
        } catch (\Exception $e) {
            Transaction::rollbackTransaction();
            throw $e;
        }

        return [
            'Status'    => 1,
            'Article'   => $updatedArticle,
        ];
    }
}
