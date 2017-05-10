<?php

namespace Web\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/serviceappli")
 */
class serviceappliController extends Controller
{
    /**
     * @Route("/", name="main_serviceappli")
     */
    public function indexAction()
    {
        return $this->render('MainBundle:serviceappli:index.html.twig');
    }
}
