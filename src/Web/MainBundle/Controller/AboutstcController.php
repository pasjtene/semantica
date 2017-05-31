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
     * @Route("/aboutstcc", name="main_aboutstcc")
     */
    public function aboutstccAction()
    {
        $array['index']=5;
        return $this->render('MainBundle:aboutstc:aboutstcc.html.twig',$array);
    }

    /**
     * @Route("/events", name="main_events")
     */
    public function eventsAction()
    {
        $array['index']=5;
        return $this->render('MainBundle:aboutstc:events.html.twig',$array);
    }

    /**
     * @Route("/eventss", name="main_eventss")
     */
    public function eventssAction()
    {
        $array['index']=5;
        return $this->render('MainBundle:aboutstc:eventss.html.twig',$array);
    }

    /**
     * @Route("/newsroom", name="main_newsroom")
     */
    public function newsroomAction()
    {
        $array['index']=5;
        return $this->render('MainBundle:aboutstc:newsroom.html.twig',$array);
    }
    /**
     * @Route("/newssroom", name="main_newssroom")
     */
    public function newssroomAction()
    {
        $array['index']=5;
        return $this->render('MainBundle:aboutstc:newssroom.html.twig',$array);
    }
    /**
 * @Route("/exploreservice", name="main_exploreservice")
 */
    public function exploreserviceAction()
    {
        $array['index']=5;
        return $this->render('MainBundle:Service:exploreservice.html.twig',$array);
    }

    /**
     * @Route("/careers", name="main_careers")
     */
    public function careersAction()
    {
        $array['index']=5;
        return $this->render('MainBundle:aboutstc:careers.html.twig',$array);
    }

    /**
     * @Route("/explorecareers", name="main_explorecareers")
     */
    public function explorecareersAction()
    {
        $array['index']=5;
        return $this->render('MainBundle:aboutstc:explorecareers.html.twig',$array);
    }

}
