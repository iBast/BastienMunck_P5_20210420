<?php

namespace App\Manager;

use App\App;

class BlogManager
{

    private $request;
    private $session;


    public function __construct($request, $session)
    {
        $this->request = $request;
        $this->session = $session;
        $this->post = App::getInstance()->getTable('post');
        $this->comment = App::getInstance()->getTable('comment');
    }

    public function createComment()
    {
        $comment = [
            'author' => $this->session->get('auth'),
            'post' => $this->request->getPostValue('post'),
            'content' => $this->request->getPostValue('content'),
        ];
        $this->comment->create($comment);
    }
}
