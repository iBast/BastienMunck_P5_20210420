<?php

namespace App\Table;

use Core\Table\Table;

class CommentTable extends Table
{
    protected $table = "comments";

    /**
     * listValidated form a post
     *
     * @param  int $post_id
     * @return void
     */
    public function listValidated($post_id)
    {
        return $this->query(
            "SELECT comments.id, comments.content, comments.date, users.username as author, users.profilePic as authorpic
        FROM comments
        Left JOIN users ON comments.author = users.id
        WHERE comments.post = ? AND comments.status = 1",
            [$post_id]
        );
    }

    public function AllValidated()
    {
        return $this->query(
            "SELECT comments.id, comments.content, comments.date, users.username as author, posts.title as post, comments.post as postid
        FROM comments
        Left JOIN users ON comments.author = users.id
        Left JOIN posts ON comments.post = posts.id
        WHERE comments.status = 1"
        );
    }

    public function listPending()
    {
        return $this->query(
            "SELECT comments.id, comments.content, comments.date, users.username as author, posts.title as post, comments.post as postid
        FROM comments
        Left JOIN users ON comments.author = users.id
        Left JOIN posts ON comments.post = posts.id
        WHERE comments.status = 0"
        );
    }

    /**
     * allWithJoin find all comments with author and post title
     *
     * @return void
     */
    public function allWithJoin()
    {
        return $this->query(
            "SELECT comments.id, comments.content, comments.date, users.username as author, posts.title as post, comments.post as postid
        FROM comments
        Left JOIN users ON comments.author = users.id
        Left JOIN posts ON comments.post = posts.id"
        );
    }

    public function listRejected()
    {
        return $this->query(
            "SELECT comments.id, comments.content, comments.date, users.username as author, posts.title as post, comments.post as postid
        FROM comments
        Left JOIN users ON comments.author = users.id
        Left JOIN posts ON comments.post = posts.id
        WHERE comments.status = 2"
        );
    }

    public function commentFromUser($userId)
    {
        return $this->query(
            "SELECT comments.id, comments.content, comments.status, comments.date, users.username as author, posts.title as post
        FROM comments
        Left JOIN users ON comments.author = users.id
        Left JOIN posts ON comments.post = posts.id
        WHERE comments.author = ?",
            [$userId]
        );
    }
}
