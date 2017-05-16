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
        return $this->render('MainBundle:Service:index.html.twig');
    }

    /**
     * @Route("/business", name="main_business")
     */
    public function businessAction()
    {
        return $this->render('MainBundle:Service:business.html.twig');
    }

    /**
     * @Route("/application", name="main_application")
     */
    public function applicationAction()
    {
        return $this->render('MainBundle:Service:application.html.twig');
    }

    /**
     * @Route("/inf", name="main_inf")
     */
    public function infAction()
    {
        return $this->render('MainBundle:Service:inf.html.twig');
    }
    /**
     * @Route("/exploreservice", name="main_exploreservice")
     */
    public function exploreserviceAction()
    {
        return $this->render('MainBundle:Service:exploreservice.html.twig');
    }

    /**
     * @Route("/exploreapp", name="main_exploreapp")
     */
    public function exploreappAction()
    {
        return $this->render('MainBundle:Service:exploreapp.html.twig');
    }

    /**
     * @Route("/serviceconseil", name="main_serviceconseil")
     */
    public function serviceconseilAction()
    {
        return $this->render('MainBundle:Service:serviceconseil.html.twig');
    }

    /**
     * @Route("/infras", name="main_infras")
     */
    public function infrasAction()
    {
        return $this->render('MainBundle:Service:infras.html.twig');
    }
}
