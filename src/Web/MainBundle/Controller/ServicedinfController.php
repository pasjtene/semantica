<?php

namespace Web\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/servicedinf")
 */
class servicedinfController extends Controller
{
    /**
     * @Route("/", name="main_servicedinf")
     */
    public function indexAction()
    {
        return $this->render('MainBundle:servicedinf:index.html.twig');
    }
}
