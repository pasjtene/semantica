<?php

namespace Web\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/service")
 */
class ServiceController extends Controller
{
    /**
     * @Route("/", name="main_service")
     */
    public function indexAction()
    {
        $array['index']=4;
        return $this->render('MainBundle:Service:index.html.twig',$array);
    }

    /**
     * @Route("/business", name="main_business")
     */
    public function businessAction()
    {
        $array['index']=4;
        return $this->render('MainBundle:Service:business.html.twig',$array);
    }

    /**
     * @Route("/application", name="main_application")
     */
    public function applicationAction()
    {
        $array['index']=4;
        return $this->render('MainBundle:Service:application.html.twig',$array);
    }

    /**
     * @Route("/inf", name="main_inf")
     */
    public function infAction()
    {
        $array['index']=4;
        return $this->render('MainBundle:Service:inf.html.twig',$array);
    }
    /**
     * @Route("/exploreservice", name="main_exploreservice")
     */
    public function exploreserviceAction()
    {
        $array['index']=4;
        return $this->render('MainBundle:Service:exploreservice.html.twig',$array);
    }

    /**
     * @Route("/exploreapp", name="main_exploreapp")
     */
    public function exploreappAction()
    {
        $array['index']=4;
        return $this->render('MainBundle:Service:exploreapp.html.twig',$array);
    }

    /**
     * @Route("/serviceconseil", name="main_serviceconseil")
     */
    public function serviceconseilAction()
    {
        $array['index']=4;
        return $this->render('MainBundle:Service:serviceconseil.html.twig',$array);
    }

    /**
     * @Route("/infras", name="main_infras")
     */
    public function infrasAction()
    {
        $array['index']=4;
        return $this->render('MainBundle:Service:infras.html.twig',$array);
    }
}
