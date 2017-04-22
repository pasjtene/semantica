<?php

namespace Web\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
/**
 * @Route("/projet")
 */
class ProjectController extends Controller
{
    /**
     * @Route("/",name="admin_projet")
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:Projet:index.html.twig');
    }
}
