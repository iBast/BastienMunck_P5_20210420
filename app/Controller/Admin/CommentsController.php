<?php

namespace App\Controller\Admin;

use Core\Form\Form;

class CommentsController extends AdminController
{
    public function __construct($session, $flash, $request, $dbAuth)
    {
        parent::__construct($session, $flash, $request, $dbAuth);
        $this->loadModel('comment');
    }

    public function index()
    {
        $comments = $this->comment->listPending();
        $form = new Form;
        $this->render('admin.comments.index', compact('comments', 'form'));
    }

    public function validate()
    {
        if ($this->request->hasGetValue('id')) {
            $this->comment->update($this->request->getGetValue('id'), ['status' => 1]);
            $this->flash->success('Le commentaire a été approuvé');
            $this->redirect('?p=admin.comments.index');
        }
    }

    public function reject()
    {
        if ($this->request->hasGetValue('id')) {
            $this->comment->update($this->request->getGetValue('id'), ['status' => 2]);
            $this->flash->success('Le commentaire a été rejeté');
            $this->redirect('?p=admin.comments.index');
        }
    }
}
