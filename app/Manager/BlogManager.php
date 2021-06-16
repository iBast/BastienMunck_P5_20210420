<?php

namespace App\Manager;

use App\App;

class BlogManager
{

    private $request;
    private $session;
    private $flash;

    public function __construct($request, $session, $flash)
    {
        $this->request = $request;
        $this->session = $session;
        $this->flash = $flash;
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
