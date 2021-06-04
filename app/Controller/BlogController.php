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
        $posts = $this->post->lastPublished();
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

    public function show()
    {
        $post = $this->post->findWithCategory($this->request->getGetValue('id'));
        if ($post === false) {
            $this->notFound();
        }
        if ($post->published != 1 & $this->session->get('role') < 2) {
            $this->flash->danger('Cet article n\'est pas publié');
            return $this->redirect('index.php?p=blog.index');
        }
        $time = strtotime($post->lastUpdate);
        $date = date("d/m/y", $time);
        $heure = date("H:i", $time);
        $this->render('blog.show', compact('post', 'date', 'heure'));
    }
}
