<?php

namespace App\Manager\Admin;

use App\App;


class CategoryManager
{

    private $request;
    private $session;
    private $flash;

    public function __construct($request, $session, $flash)
    {
        $this->request = $request;
        $this->session = $session;
        $this->flash = $flash;
        $this->post = App::getInstance()->getTable('category');
    }

    public function save()
    {
        $post = [
            'title' => $this->request->getPostValue('title'),
        ];
        return $this->post->create($post);
    }

    public function update($post_id)
    {
        $post = [
            'title' => $this->request->getPostValue('title'),

        ];
        return $this->post->update($post_id, $post);
    }
}
