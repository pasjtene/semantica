<?php

namespace Web\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/footer")
 */
class FooterController extends Controller
{
    /**
     * @Route("/contact", name="main_contact")
     */
    public function contactAction()
    {
        return $this->render('MainBundle:footer:contact.html.twig');
    }


}
