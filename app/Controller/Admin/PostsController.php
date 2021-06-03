<?php

namespace App\Controller\Admin;

use App\App;
use Core\Form\Form;
use App\Action\PostCheck;
use App\Manager\Admin\PostManager;

class PostsController extends AdminController
{
    protected $request;
    protected $session;
    protected $flash;
    protected $dbAuth;

    public function __construct($session, $flash, $request, $dbAuth)
    {
        parent::__construct($session, $flash, $request, $dbAuth);
        $this->loadModel('post');
        $this->manager = new PostManager($request, $session, $flash);
    }

    public function index()
    {
        $posts = $this->post->last();
        $categories = App::getInstance()->getTable('Category')->all();
        $users = App::getInstance()->getTable('user')->all();
        $this->render('admin.posts.index', compact('posts', 'categories', 'users'));
    }

    public function add()
    {
        if ($this->request->hasPost()) {
            $postCheck = new PostCheck($this->request, $this->session);
            $errorMessage = $postCheck->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                if ($this->manager->save()) {
                    $this->flash->success("L'article a été enregistré");
                    return $this->redirect('?p=admin.posts.index');
                }
            }
        }
        $checked = null;
        $this->loadModel('category');
        $categories = $this->category->extract('id', 'title');
        $form = new Form($this->request->getPost());
        $this->render('admin.posts.edit', compact('form', 'checked', 'categories'));
    }

    public function edit()
    {
        if ($this->request->hasPost()) {
            $postCheck = new PostCheck($this->request, $this->session);
            $errorMessage = $postCheck->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                if ($this->manager->update($this->request->getGetvalue('id'))) {
                    $this->flash->success("L'article a été enregistré");
                    return $this->redirect('?p=admin.posts.index');
                }
            }
        }
        $post = $this->post->find($this->request->getGetvalue('id'));
        ($post->published == 1) ? $checked = 'checked' : $checked = null;
        $this->loadModel('category');
        $categories = $this->category->extract('id', 'title');
        $form = new Form($post);
        $this->render('admin.posts.edit', compact('form', 'post', 'checked', 'categories'));
    }
}
