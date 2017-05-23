<?php

namespace Web\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/careers")
 */
class CareersController extends Controller
{
    /**
     * @Route("/", name="main_careers")
     */
    public function indexAction()
    {
        return $this->render('MainBundle:Careers:index.html.twig');
    }

}
