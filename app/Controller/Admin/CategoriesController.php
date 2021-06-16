<?php

namespace App\Controller\Admin;

use App\App;
use Core\Form\Form;
use App\Action\CategoryCheck;
use App\Manager\Admin\CategoryManager;

/**
 * CategoriesController
 */
class CategoriesController extends AdminController
{
    protected $request;
    protected $session;
    protected $flash;
    protected $dbAuth;

    public function __construct($session, $flash, $request, $dbAuth)
    {
        parent::__construct($session, $flash, $request, $dbAuth);
        $this->loadModel('category');
        $this->manager = new CategoryManager($request);
    }

    public function index()
    {
        App::getInstance()->setTitle("Gestion des catégories");
        $categories = $this->category->all();
        $form = new Form();
        $this->render('admin.categories.index', compact('categories', 'form'));
    }

    public function add()
    {
        App::getInstance()->setTitle("Ajout d'une catégorie");
        if ($this->request->hasPost()) {
            $categoryCheck = new CategoryCheck($this->request, $this->session);
            $errorMessage = $categoryCheck->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                if ($this->manager->save()) {
                    $this->flash->success("L'article a été enregistré");
                    return $this->redirect('?p=admin.categories.index');
                }
            }
        }
        $form = new Form($this->request->getPost());
        $this->render('admin.categories.edit', compact('form'));
    }

    public function edit()
    {
        App::getInstance()->setTitle("Edition d'une catégorie");
        if ($this->request->hasPost()) {
            $categoryCheck = new CategoryCheck($this->request, $this->session);
            $errorMessage = $categoryCheck->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                if ($this->manager->update($this->request->getGetvalue('id'))) {
                    $this->flash->success("La catégorie a été enregistré");
                    return $this->redirect('?p=admin.categories.index');
                }
            }
        }
        $category = $this->category->find($this->request->getGetvalue('id'));
        $form = new Form($category);
        $this->render('admin.categories.edit', compact('form', 'category'));
    }

    public function delete()
    {
        if ($this->request->hasPost()) {
            $this->category->delete($this->request->getPostvalue('id'));
            $this->flash->success("La catégorie a été supprimé");
            return $this->redirect('?p=admin.categories.index');
        }
    }
}
