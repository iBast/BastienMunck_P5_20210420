<?php

namespace App\Controller\Admin;

use Core\Form\Form;

class UsersController extends AdminController
{
    protected $request;
    protected $session;
    protected $flash;
    protected $dbAuth;
    public function __construct($session, $flash, $request, $dbAuth)
    {
        parent::__construct($session, $flash, $request, $dbAuth);
        $this->loadModel('user');
    }

    public function index()
    {
        $users = $this->user->all();
        $this->render('admin.users.index', compact('users'));
    }

    public function edit()
    {
        $form = new Form();
        $this->render('admin.users.edit', compact('form'));
    }
}
