<?php

namespace App\Manager\Admin;

use App\App;


class CategoryManager
{

    private $request;


    public function __construct($request)
    {
        $this->request = $request;
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
