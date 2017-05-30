<?php

namespace Web\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/mail")
 */
class MailController extends Controller
{
    /**
     * @Route("/subscribe", name="main_mail_subscribe")
     */
    public function subscribeAction()
    {
        return $this->render('MainBundle:Mail:subscribe.html.twig');
    }


    /**
     * @Route("/project", name="main_mail_project")
     */
    public function projectAction()
    {
        return $this->render('MainBundle:Mail:project.html.twig',['email'=>'http://Sdanicktyakam@yahoo.fr','semail'=>'Sdanicktyakam@yahoo.fr']);
    }


    /**
     * @Route("/contact", name="main_mail_contact")
     */
    public function contactAction()
    {
        return $this->render('MainBundle:Mail:contact.html.twig',['email'=>'http://Sdanicktyakam@yahoo.fr','semail'=>'Sdanicktyakam@yahoo.fr','name'=>'Danick Takam']);
    }



    /**
     * @Route("/reset", name="main_mail_reset")
     */
    public function resetAction()
    {
        return $this->render('MainBundle:Mail:reset.html.twig',['link'=>'reset a password','unlink'=>'unscribre','email'=>'http://Sdanicktyakam@yahoo.fr','semail'=>'Sdanicktyakam@yahoo.fr','name'=>'Danick Takam']);
    }


}

