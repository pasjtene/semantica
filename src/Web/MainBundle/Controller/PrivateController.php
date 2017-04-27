<?php

namespace Web\MainBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Web\EntityBundle\Entity\Contact;
use Web\EntityBundle\Entity\Customer;
use Web\EntityBundle\Entity\User;
use Web\EntityBundle\Form\UserType;

/**
 * @Route("/private")
 */
class PrivateController extends Controller
{



    /**
     * @Route("/", name="main_private")
     */
    public function compteAction()
    {
        /** @var User $user */
        $user = $this->container->get('security.token_storage')->getToken()->getUser();


        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository("EntityBundle:Projet")->findBy(['email'=>$user->getEmail()],['id'=>'DESC','time'=>'DESC']);
        $array['list'] = $list;

        return $this->render('MainBundle:Private:index.html.twig',$array);
    }



}
