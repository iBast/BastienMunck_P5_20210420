<?php

namespace App\Controller\Admin;

use App\App;
use Core\Form\Form;
use App\Action\UpdateAdminCheck;
use App\Manager\Admin\UserManager;

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
        $this->manager = new UserManager($request, $session, $flash);
    }

    public function index()
    {
        $users = $this->user->all();
        $this->render('admin.users.index', compact('users'));
    }

    public function edit()
    {
        App::getInstance()->setTitle("Modification du compte");
        $user = $this->user->find($this->request->getGetValue('id'));
        if ($this->request->hasPost()) {
            $updateAdminCheck = new UpdateAdminCheck($this->request, $this->session);
            $errorMessage = $updateAdminCheck->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                $this->manager->updateAccount();
                $this->redirect('?p=admin.users.index');
            }
        }
        $form = new Form($user);
        $this->render('admin.users.edit', compact('form', 'user'));
    }

    public function deleteAccount()
    {
        if ($this->request->hasPost()) {
            $this->manager->deleteAccount();
            $this->redirect('?p=admin.users.index');
        }
    }
}
