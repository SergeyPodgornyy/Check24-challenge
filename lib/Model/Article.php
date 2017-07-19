<?php

namespace Model;

use Model\Driver\Engine;

class Article implements ModelInterface
{
    use Traits\BaseFunctions;

    const CONNECTION_NAME = 'framework';
    const TABLE_NAME = 'articles';

    /**
     * Create connection
     *
     * @return bool|mixed
     */
    public static function getConnection()
    {
        return Engine::getConnection(self::CONNECTION_NAME);
    }

    /**
     * Insert new article
     *
     * @param   array $data
     * @return  bool
     */
    public static function create($data = array())
    {
        $connection = self::getConnection();

        $title = $data['Title'] ?? '';
        $text = $data['Text'] ?? '';
        $userId = $data['UserId'] ?? null;
        $createdAt = date('Y-m-d H:i:s');
        $updatedAt = date('Y-m-d H:i:s');

        $statement = $connection->prepare(
            " INSERT INTO ".self::TABLE_NAME."(
                title,
                text,
                author_id,
                created_at,
                updated_at
            ) VALUES (
                :title,
                :text,
                :user_id,
                :created_at,
                :updated_at
            )"
        );

        $statement->bindValue(':title', $title);
        $statement->bindValue(':text', $text);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':created_at', $createdAt);
        $statement->bindValue(':updated_at', $updatedAt);

        $inserted = $statement->execute();

        if ($inserted) {
            return $connection->lastInsertId(self::TABLE_NAME);
        }

        return false;
    }

    /**
     * Update article by Id
     *
     * @param   int     $id
     * @param   array   $data
     * @return  mixed
     */
    public static function update($id, array $data)
    {
        $connection = self::getConnection();

        $title = $data['Title'] ?? '';
        $text = $data['Text'] ?? '';
        $updatedAt = date('Y-m-d H:i:s');

        $statement = $connection->prepare(
            "UPDATE ".self::TABLE_NAME."
             SET
                title = :title,
                text = :text,
                updated_at = :updated_at
             WHERE id = :id"
        );

        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':text', $text);
        $statement->bindValue(':updated_at', $updatedAt);

        return $statement->execute();
    }

    /**
     * Return article comments by $articleId
     *
     * @param   int         $articleId
     * @return  bool|array
     */
    public static function getArticleComments($articleId = 0)
    {
        $connection = self::getConnection();

        $query = "SELECT * FROM article_comments WHERE article_id = :article_id";

        $statement = $connection->prepare($query);
        $statement->bindValue(':article_id', $articleId, \PDO::PARAM_INT);
        $success = $statement->execute();

        if ($success) {
            return $statement->fetchAll();
        }

        return false;
    }

    /**
     * Return list of articles
     *
     * @param   array   $params
     * @return  bool
     */
    public static function index($params = array())
    {
        $connection = self::getConnection();

        $limit = isset($params['Limit']) ? " LIMIT $params[Limit] " : '';
        $offset = isset($params['Offset']) ? " OFFSET $params[Offset] " : '';
        $order = isset($params['SortField']) && isset($params['SortOrder']) ?
            " ORDER BY $params[SortField] $params[SortOrder] " : '';

        $query = "SELECT * FROM ".self::TABLE_NAME.$order.$limit.$offset;

        $statement = $connection->prepare($query);
        $success = $statement->execute();

        if ($success) {
            return $statement->fetchAll();
        }

        return false;
    }

    /**
     * Search articles by title
     *
     * @param   array   $params
     * @return  bool
     */
    public static function search($params = array())
    {
        $connection = self::getConnection();

        $whereTitle = isset($params['Search']) && $params['Search']
            ? self::TABLE_NAME.'.title LIKE "%:title%" '
            : '';
        $whereUserId = isset($params['AuthorId']) && $params['AuthorId']
            ? self::TABLE_NAME.'.author_id = :author_id '
            : null;
        $limit = isset($params['Limit']) ? " LIMIT $params[Limit] " : '';
        $offset = isset($params['Offset']) ? " OFFSET $params[Offset] " : '';
        $order = isset($params['SortField']) && isset($params['SortOrder']) ?
            " ORDER BY $params[SortField] $params[SortOrder] " : '';

        $where = ($whereTitle || $whereUserId)
            ? ' WHERE ' . implode(' AND ', array_filter([$whereTitle, $whereUserId], function ($clause) {
                    return $clause;
                }))
            : '';

        $query = "SELECT ".self::TABLE_NAME.".* FROM ".self::TABLE_NAME.$where.$order.$limit.$offset;

        $statement = $connection->prepare($query);
        if (isset($params['Search']) && $params['Search']) {
            $statement->bindValue(':title', $params['Search'], \PDO::PARAM_STR);
        }
        if (isset($params['AuthorId']) && $params['AuthorId']) {
            $statement->bindValue(':author_id', $params['AuthorId'], \PDO::PARAM_INT);
        }

        $success = $statement->execute();

        if ($success) {
            return $statement->fetchAll();
        }

        return false;
    }

    /**
     * Count all articles
     *
     * @return bool|int
     */
    public static function count()
    {
        $connection = self::getConnection();

        $query = "SELECT count(*) as sum FROM ".self::TABLE_NAME;

        $statement = $connection->prepare($query);
        $success = $statement->execute();

        if ($success) {
            return $statement->fetch()['sum'];
        }

        return false;
    }

    /**
     * Count filtered rows
     *
     * @param   array   $params
     * @return  bool
     */
    public static function countFiltered($params)
    {
        $connection = self::getConnection();

        $whereTitle = isset($params['Search']) && $params['Search']
            ? $params['Search']
            : null;
        $where = $whereTitle
            ? ' WHERE '.self::TABLE_NAME.'.title LIKE "%:title%" '
            : '';

        $query = "SELECT count(*) as sum FROM ".self::TABLE_NAME.$where;

        $statement = $connection->prepare($query);
        $statement->bindValue(':title', $whereTitle, \PDO::PARAM_STR);
        $success = $statement->execute();

        if ($success) {
            return $statement->fetch()['sum'];
        }

        return false;
    }

    /**
     * Delete article
     *
     * @param   array   $data
     * @return  bool
     */
    public static function delete($data = array())
    {
        $connection = self::getConnection();

        $ids = isset($data['Id']) && is_array($data['Id'])
            ? $data['Id']
            : [];

        $whereInds = '';

        foreach ($ids as $n => $id) {
            $whereInds .= $n ? ',' : '';
            $whereInds .= ":id_$n";
        }

        $whereInds = $whereInds ? " id IN ($whereInds) " : '';
        if (!$whereInds) {
            return false;
        }

        $statement = $connection->prepare(
            "DELETE FROM ".self::TABLE_NAME." WHERE $whereInds"
        );

        foreach ($ids as $n => $id) {
            $statement->bindValue(":id_$n", $id);
        }

        return $statement->execute();
    }

    /**
     * Select one article by Id
     *
     * @param   array   $data
     * @return  mixed
     */
    public static function selectOne($data = array())
    {
        $connection = self::getConnection();
        $id = $data['Id'] ?? 0;

        $statement = $connection->prepare("SELECT ".self::TABLE_NAME.".* FROM ".self::TABLE_NAME);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $row = $statement->fetch();

        return $row;
    }

    /**
     * Transform database columns to Camel Case
     *
     * @param   array   $article
     * @return  array
     */
    public static function toCamelCase($article)
    {
        return [
            'Id'        => $article['id'],
            'Title'     => $article['title'],
            'Text'      => $article['text'],
            'UserId'    => $article['user_id'],
            'CreatedAt' => $article['created_at'],
            'UpdatedAt' => $article['updated_at'],
        ];
    }
}
