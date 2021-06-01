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
    }

    public function index()
    {
        $this->render('admin.dashboard.index');
    }
}
