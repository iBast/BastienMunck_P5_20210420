<?php

namespace App\Controller\Admin;

/**
 * DashboardController
 */
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
            'usermail' => $this->user->count('role', ROLE_NEWBIE),
            'articlesPublished' => $this->post->count('published', POST_PUBLISHED),
            'articlesPending' => $this->post->count('published', POST_DRAFT),
            'categories' => $this->category->countTable(),
            'comments' => $this->comment->count('status', COMMENT_DRAFT)
        ];
        $this->render('admin.dashboard.index', compact('count'));
    }
}
