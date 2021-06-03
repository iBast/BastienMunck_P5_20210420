<?php

namespace App\Table;

use Core\Table\Table;

class PostTable extends Table
{
    protected $table = "posts";

    public function last()
    {
        return $this->query(
            "SELECT posts.id, posts.title, posts.lastUpdate, posts.published, categories.title as category, users.username as author
        FROM posts
        Left JOIN categories ON category = categories.id
        Left JOIN users ON posts.author = users.id
        ORDER BY posts.lastUpdate DESC"
        );
    }
}
