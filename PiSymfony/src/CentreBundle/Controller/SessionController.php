<?php

namespace CentreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;


class SessionController extends Controller
{
    public function indexAction()
    {
        $session = new Session();
        $session->set('name', 'g');
        $user = $session->get('name');


        return $this->render('CentreBundle:Session:index.html.twig', ['user'=>$user]);
        // ...
    }

    public function adminAction()
    {
        return $this->render('CentreBundle:Session:admin.html.twig', array(
            // ...
        ));
    }

}
