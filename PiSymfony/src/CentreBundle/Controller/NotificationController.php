<?php

namespace CentreBundle\Controller;

use CentreBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NotificationController extends Controller
{
    public function displayAction()
    { $notifications=$this->getDoctrine()->getRepository('CentreBundle:Notification')->findBy(array('seen'=>'0'));
        return $this->render('CentreBundle:Notification:display.html.twig', array(
            'notifications'=>$notifications
        ));
    }
    public function updateAction($notification)
    {
        $notifications=$this->getDoctrine()->getRepository('CentreBundle:Notification')->findAll();
        return $this->render('CentreBundle:Notification:display.html.twig', array(
            'notifications'=>$notifications
        ));
    }

}
