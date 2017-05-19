<?php

namespace Web\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/aboutstc")
 */
class AboutstcController extends Controller
{
    /**
     * @Route("/", name="main_aboutstc")
     */
    public function indexAction()
    {
        $array['index']=5;
        return $this->render('MainBundle:aboutstc:index.html.twig',$array);
    }

    /**
     * @Route("/business", name="main_business")
     */
    public function businessAction()
    {
        $array['index']=5;
        return $this->render('MainBundle:Service:business.html.twig',$array);
    }

    /**
     * @Route("/application", name="main_application")
     */
    public function applicationAction()
    {
        $array['index']=5;
        return $this->render('MainBundle:Service:application.html.twig',$array);
    }

    /**
     * @Route("/inf", name="main_inf")
     */
    public function infAction()
    {
        $array['index']=5;
        return $this->render('MainBundle:Service:inf.html.twig',$array);
    }
    /**
     * @Route("/exploreservice", name="main_exploreservice")
     */
    public function exploreserviceAction()
    {
        $array['index']=5;
        return $this->render('MainBundle:Service:exploreservice.html.twig',$array);
    }

}
