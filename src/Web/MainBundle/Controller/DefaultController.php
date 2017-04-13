<?php

namespace Web\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="main_homepage")
     */
    public function indexAction()
    {
        return $this->render('MainBundle:Default:index.html.twig');
    }

    /**
     * @Route("/", name="main_signup")
     */
    public function signupAction()
    {
        return $this->render('MainBundle:Default:signup.html.twig');
    }
}
