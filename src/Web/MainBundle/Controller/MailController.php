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
        return $this->render('MainBundle:Mail:project.html.twig');
    }


}

