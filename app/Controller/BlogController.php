<?php

namespace App\Controller;

use App\App;
use Core\Form\Form;
use Core\Http\Paginator;
use App\Action\CommentCheck;
use App\Action\DeleteComCheck;
use App\Controller\AppController;
use App\Manager\BlogManager;

/**
 * BlogController
 */
class BlogController extends AppController
{

    private $paginator;

    public function __construct($session, $flash, $request, $dbAuth)
    {
        parent::__construct($session, $flash, $request, $dbAuth);
        $this->loadModel('post');
        $this->loadModel('category');
        $this->loadModel('comment');
        $this->paginator = new Paginator($request, $flash);
        $this->manager = new BlogManager($request, $session);
    }

    /**
     * index show blog index
     */
    public function index()
    {
        App::getInstance()->setTitle("Blog");
        $this->paginator->setPerPage(6);
        $perPage = $this->paginator->getPerPage();
        $count = $this->post->countTable();
        $posts = $this->post->lastPublished($perPage, $this->paginator->setOffset($perPage, $count[0]->id));
        if ($this->paginator->isError()) {
            $this->notFound();
        }
        $categories = App::getInstance()->getTable('Category')->all();
        $printCommands = $this->paginator->printCommands('?p=blog.index');
        $this->render('blog.index', compact('posts', 'categories', 'printCommands'));
    }

    /**
     * category : show blog by a given category
     */
    public function category()
    {
        App::getInstance()->setTitle("Blog");
        $this->paginator->setPerPage(6);
        $perPage = $this->paginator->getPerPage();
        $count = $this->post->count('category', $this->request->getGetValue('id'));
        $category = $this->category->find($this->request->getGetValue('id'));
        if ($category === false) {
            $this->notFound();
        }
        $posts = $this->post->lastByCategory($this->request->getGetValue('id'), $perPage, $this->paginator->setOffset($perPage, $count->category));
        $categories = $this->category->all();
        $printCommands = $this->paginator->printCommands('?p=blog.category&id=' . $this->request->getGetValue('id') . '');
        $this->render('blog.category', compact('posts', 'categories', 'category', 'printCommands'));
    }

    /**
     * show : show a blog post
     */
    public function show()
    {
        App::getInstance()->setTitle("Blog - Article");
        $post = $this->post->findWithCategory($this->request->getGetValue('id'));
        if ($post === false) {
            $this->notFound();
        }
        if ($post->published != POST_PUBLISHED & $this->session->get('role') < ROLE_ADMIN) {
            $this->flash->danger('Cet article n\'est pas publié');
            return $this->redirect('index.php?p=blog.index');
        }
        $session = $this->session;
        $comments = $this->comment->listValidated($this->request->getGetValue('id'));
        $form = new Form();
        $this->render('blog.show', compact('post', 'comments', 'session', 'form'));
    }

    /**
     * addcomment to a blog post
     */
    public function addcomment()
    {
        App::getInstance()->setTitle("Ajouter un  commentaire");
        if ($this->request->hasPost()) {
            $commentCheck = new CommentCheck($this->request, $this->session);
            $errorMessage = $commentCheck->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                $this->manager->createComment();
                $this->flash->success('Le commentaire a été enregistré, un administrateur le validera bientôt');

                return $this->redirect('?p=blog.show&id=' . $this->request->getPostValue('post') . '');
            }
        }
    }

    /**
     * deleteComment from a blog post 
     */
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
