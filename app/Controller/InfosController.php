<?php

namespace App\Controller;

use App\Manager\InfosManager;
use App\Action\ContactCheckAction;

/**
 * InfosController generic pages controller
 */
class InfosController extends AppController
{
    private $manager;
    public function __construct($session, $flash, $request, $dbAuth)
    {
        parent::__construct($session, $flash, $request, $dbAuth);
        $this->manager = new InfosManager($this->request);
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
