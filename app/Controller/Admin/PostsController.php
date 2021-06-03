<?php

namespace App\Controller\Admin;

use Core\Form\Form;

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
    }

    public function index()
    {
        $this->render('admin.posts.index');
    }

    public function add()
    {
        $form = new Form();
        $this->render('admin.posts.edit', compact('form'));
    }
}
