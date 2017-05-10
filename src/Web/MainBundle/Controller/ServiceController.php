<?php

namespace Web\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/service")
 */
class serviceController extends Controller
{
    /**
     * @Route("/", name="main_service")
     */
    public function indexAction()
    {
        return $this->render('MainBundle:services:index.html.twig');
    }
}
