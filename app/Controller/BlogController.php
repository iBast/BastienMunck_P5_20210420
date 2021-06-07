<?php

namespace App\Controller;

use App\App;
use Core\Form\Form;
use App\Action\CommentCheck;
use App\Action\DeleteComCheck;
use App\Controller\AppController;

class BlogController extends AppController
{

    public function __construct($session, $flash, $request, $dbAuth)
    {
        parent::__construct($session, $flash, $request, $dbAuth);
        $this->loadModel('post');
        $this->loadModel('category');
        $this->loadModel('comment');
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
        $session = $this->session;

        $comments = $this->comment->listValidated($this->request->getGetValue('id'));
        $form = new Form();
        $this->render('blog.show', compact('post', 'date', 'heure', 'comments', 'session', 'form'));
    }

    public function addcomment()
    {
        if ($this->request->hasPost()) {
            $commentCheck = new CommentCheck($this->request, $this->session);
            $errorMessage = $commentCheck->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                $comment = [
                    'author' => $this->session->get('auth'),
                    'post' => $this->request->getPostValue('post'),
                    'content' => $this->request->getPostValue('content'),
                ];
                $this->comment->create($comment);
                $this->flash->success('Le commentaire a été enregistré, un administrateur le validera bientôt');

                return $this->redirect('?p=blog.show&id=' . $this->request->getPostValue('post') . '');
            }
        }
    }

    public function deleteComment()
    {

        if ($this->request->hasPost()) {
            $comment = $this->comment->find($this->request->getPostValue('id'));
            $user = $this->session->get('auth');
            $deleteComCheck = new DeleteComCheck($this->request, $this->session, $comment, $user);
            $errorMessage = $deleteComCheck->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                $this->comment->delete($this->request->getPostValue('id'));
                $this->flash->success('Le commentaire a été supprimé');
            }
        }
        return $this->redirect('?p=users.account');
    }
}
