<?php

namespace App\Controller\Admin;

class DashboardController extends AdminController
{
    protected $request;
    protected $session;
    protected $flash;
    protected $dbAuth;
    public function __construct($session, $flash, $request, $dbAuth)
    {
        parent::__construct($session, $flash, $request, $dbAuth);
        $this->loadModel('user');
        $this->loadModel('post');
        $this->loadModel('category');
        $this->loadModel('comment');
    }

    public function index()
    {
        $count = [
            'usertable' => $this->user->countTable(),
            'usermail' => $this->user->count('role', 0),
            'articlesPublished' => $this->post->count('published', 1),
            'articlesPending' => $this->post->count('published', 0),
            'categories' => $this->category->countTable(),
            'comments' => $this->comment->count('status', 0)
        ];
        $this->render('admin.dashboard.index', compact('count'));
    }
}
