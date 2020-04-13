<?php

namespace CentreBundle\Controller;
use CentreBundle\Entity\Mail;
use CentreBundle\Entity\Centre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MailController extends Controller
{
    public function sendMailAction(Request $request,Centre $centre)
    {
        $mail=new Mail();
        $form=$this->createForm('CentreBundle\Form\MailType',$mail);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $subject=$mail->getSubject();
            $mail=$mail->getMail();
            $object=$request->get('form')['object'];
            $username='hanebhar@gmail.com';
            $message=\Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($username)
            ->setTo($centre->getMailCentre())
            ->setBody($object);
            $this->get('mailer')->send($message);
            $this->get('session')->getFlashBag()->add('notice','Messge Envoyé avec Success');

        }
        return $this->render('centre/send_mail.html.twig', array('f'=> $form->createView(),'centre'=>$centre));

    }

}
