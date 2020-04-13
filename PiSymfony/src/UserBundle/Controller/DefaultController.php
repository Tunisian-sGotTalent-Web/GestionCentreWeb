<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        return $this->render('UserBundle:Default:index.html.twig');
    }
    public function voirMonCompteAction()
    {

        return $this->render('centre/moncompte.html.twig');
    }
}
