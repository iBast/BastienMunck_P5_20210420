<?php

namespace App\Table;

use Core\Table\Table;

class CommentTable extends Table
{
    protected $table = "comments";

    public function list($post_id)
    {
        return $this->query(
            "SELECT comments.id, comments.content, comments.date, users.username as author, users.profilePic as authorpic
        FROM comments
        Left JOIN users ON comments.author = users.id
        WHERE comments.post = ? ",
            [$post_id]
        );
    }
}
//AND comments.status = 1