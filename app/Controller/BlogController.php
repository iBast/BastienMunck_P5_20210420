<?php

namespace App\Controller;

use App\App;
use App\Controller\AppController;

class BlogController extends AppController
{

    public function __construct($session, $flash, $request, $dbAuth)
    {
        parent::__construct($session, $flash, $request, $dbAuth);
        $this->loadModel('post');
        $this->loadModel('category');
    }

    public function index()
    {
        $posts = $this->post->last();
        $categories = App::getInstance()->getTable('Category')->all();
        $this->render('blog.index', compact('posts', 'categories'));
    }

    public function category()
    {
        $category = $this->category->find($this->request->getGetValue('id'));
        if ($category === false) {
            $this->notFound();
        }
        $posts = $this->post->lastByCategory($this->request->getGetValue('id'));
        $categories = $this->category->all();

        $this->render('blog.category', compact('posts', 'categories', 'category'));
    }
}
