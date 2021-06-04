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

    public function lastByCategory($category_id)
    {
        return $this->query(
            "        SELECT posts.id, posts.title, posts.content, posts.chapo, posts.lastUpdate, categories.title as category, users.username as author
        FROM posts
        Left JOIN categories ON category = categories.id
        Left JOIN users ON posts.author = users.id
        WHERE posts.category = ?
        ORDER BY posts.lastUpdate DESC",
            [$category_id]
        );
    }
}
