<?php

namespace App\Controller;

use App\Manager\InfosManager;
use App\Action\ContactCheckAction;

/**
 * InfosController generic pages controller
 */
class InfosController extends AppController
{
    public function __construct($session, $flash, $request, $dbAuth)
    {
        parent::__construct($this->session, $this->flash, $this->request, $this->dbAuth);
        $this->session = $session;
        $this->flash = $flash;
        $this->request = $request;
        $this->dbAuth = $dbAuth;
        $this->manager = new InfosManager($this->request, $this->session, $this->flash);
    }
    public function notFound()
    {
        $this->render('infos.notfound');
    }
    public function forbidden()
    {
        $this->render('infos.forbidden');
    }
    /**
     * home : homepage 
     */
    public function home()
    {
        if ($this->request->hasPost()) {
            $contactCheckAction = new ContactCheckAction($this->request, $this->session);
            $errorMessage = $contactCheckAction->getErrorMessage();
            $this->flash->danger($errorMessage);
            if ($errorMessage == null) {
                $this->manager->send();
                $this->flash->success('Votre message a bien été envoyé');
            }
        }
        $form = new \Core\Form\Form();
        $this->render('infos.home', compact('form'));
    }

    public function about()
    {
        $this->render('infos.about');
    }
}
