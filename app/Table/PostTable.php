<?php

namespace App\Table;

use Core\Table\Table;

class PostTable extends Table
{
    protected $table = "posts";

    public function last()
    {
        return $this->query(
            "SELECT posts.id, posts.title, posts.chapo, posts.content, posts.lastUpdate, posts.published, categories.title as category, users.username as author
        FROM posts
        Left JOIN categories ON category = categories.id
        Left JOIN users ON posts.author = users.id
        ORDER BY posts.lastUpdate DESC"
        );
    }

    public function lastPublished($perPage, $offset)
    {
        return $this->query(
            "SELECT posts.id, posts.title, posts.chapo, posts.content, posts.lastUpdate, posts.published, categories.title as category, users.username as author
        FROM posts
        Left JOIN categories ON category = categories.id
        Left JOIN users ON posts.author = users.id
        WHERE posts.published = 1
        ORDER BY posts.lastUpdate DESC 
        LIMIT $perPage OFFSET $offset"
        );
    }

    public function lastByCategory($category_id, $perPage, $offset)
    {
        return $this->query(
            "        SELECT posts.id, posts.title, posts.content, posts.chapo, posts.lastUpdate, categories.title as category, users.username as author
        FROM posts
        Left JOIN categories ON category = categories.id
        Left JOIN users ON posts.author = users.id
        WHERE posts.category = ? AND posts.published = 1
        ORDER BY posts.lastUpdate DESC
        LIMIT $perPage OFFSET $offset",
            [$category_id]
        );
    }

    public function findWithCategory($post_id)
    {
        return $this->query(
            "SELECT posts.id, posts.title, posts.content, posts.chapo, posts.published, posts.lastUpdate, categories.title as category, users.username as author
        FROM posts
        Left JOIN categories ON category = categories.id
        Left JOIN users ON posts.author = users.id
        WHERE posts.id = ?",
            [$post_id],
            true
        );
    }
}
