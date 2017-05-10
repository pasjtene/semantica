<?php

namespace Web\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/businessconsul")
 */
class businessconsulController extends Controller
{
    /**
     * @Route("/", name="main_businessconsul")
     */
    public function indexAction()
    {
        return $this->render('MainBundle:businessconsul:index.html.twig');
    }
}
