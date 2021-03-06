<?php

namespace App\Controller\Admin;

use App\App;
use Core\Form\Form;

/**
 * CommentsController
 */
class CommentsController extends AdminController
{
    public function __construct($session, $flash, $request, $dbAuth)
    {
        parent::__construct($session, $flash, $request, $dbAuth);
        $this->loadModel('comment');
    }

    public function index()
    {
        App::getInstance()->setTitle("Gestion des commentaires");
        $comments = $this->comment->listPending();
        $form = new Form;
        $this->render('admin.comments.index', compact('comments', 'form'));
    }

    public function validate()
    {
        if ($this->request->hasGetValue('id')) {
            $this->comment->update($this->request->getGetValue('id'), ['status' => COMMENT_VALIDATED]);
            $this->flash->success('Le commentaire a été approuvé');
            $this->redirect('?p=admin.comments.index');
        }
    }

    public function reject()
    {
        if ($this->request->hasGetValue('id')) {
            $this->comment->update($this->request->getGetValue('id'), ['status' => COMMENT_REJECTED]);
            $this->flash->success('Le commentaire a été rejeté');
            $this->redirect('?p=admin.comments.index');
        }
    }

    public function show()
    {
        App::getInstance()->setTitle("Gestion  des commentaires");
        if ($this->request->hasGetValue('cat') != null) {
            if ($this->request->getGetValue('cat') == 'validated') {
                $comments = $this->comment->AllValidated();
                $title = 'Validés';
            }
            if ($this->request->getGetValue('cat') == 'rejected') {
                $comments = $this->comment->listRejected();
                $title = 'Rejetés';
            }
        } else {
            $comments = $this->comment->allWithJoin();
            $title = 'Tous les commentaires';
        }
        $form = new Form();
        $this->render('admin.comments.show', compact('comments', 'form', 'title'));
    }

    public function delete()
    {
        if ($this->request->hasPost()) {
            $this->comment->delete($this->request->getPostValue('id'));
            $this->flash->success('Le commentaire a été supprimé');
        }
        return $this->redirect('?p=admin.comments.index');
    }
}
