<?php

namespace Web\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/industries")
 */
class IndustriesController extends Controller
{
    /**
     * @Route("/", name="main_industries")
     */
    public function indexAction()
    {
        $array["index"] =2;
        return $this->render('MainBundle:Industries:index.html.twig',$array);
    }
}
