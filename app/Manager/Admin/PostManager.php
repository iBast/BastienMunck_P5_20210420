<?php

namespace App\Manager\Admin;

use App\App;


class PostManager
{

    private $request;
    private $session;


    public function __construct($request, $session)
    {
        $this->request = $request;
        $this->session = $session;
        $this->post = App::getInstance()->getTable('post');
    }

    public function save()
    {
        $post = [
            'title' => $this->request->getPostValue('title'),
            'chapo' => $this->request->getPostValue('chapo'),
            'content' => $this->request->getPostValue('content'),
            'published' => $this->request->getPostValue('published'),
            'author' => $this->session->get('auth'),
            'category' => $this->request->getPostValue('category'),
            'lastUpdate' => date("Y-m-d H:i:s"),

        ];
        return $this->post->create($post);
    }

    public function update($post_id)
    {
        $post = [
            'title' => $this->request->getPostValue('title'),
            'chapo' => $this->request->getPostValue('chapo'),
            'content' => $this->request->getPostValue('content'),
            'published' => $this->request->getPostValue('published'),
            'category' => $this->request->getPostValue('category'),
            'lastUpdate' => date("Y-m-d H:i:s"),

        ];
        return $this->post->update($post_id, $post);
    }
}
