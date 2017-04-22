<?php

namespace Web\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="admin_homepage")
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:Default:index.html.twig');
    }

    /**
     * @Route("/contact", name="admin_contact")
     */
    public function contactAction()
    {
        return $this->render('AdminBundle:Default:contact.html.twig');
    }

    /**
     * @Route("/contact/send", name="admin_sendcontact/{id}", requirements={"id": "\d+"})
     */
    public function sendMailcontactAction($id)
    {
        return $this->render('AdminBundle:Default:contact.html.twig');
    }

    /**
     * @Route("/customer", name="admin_customer")
     */
    public function customerAction()
    {
        return $this->render('AdminBundle:Default:customer.html.twig');
    }


    /**
     * @Route("/logout", name="admin_logout")
     */
    public function logoutAction()
    {
        return $this->render('AdminBundle:Default:customer.html.twig');
    }


    public  function sentMail($to, $from, $routeview, $parm,$subjet)
    {
        // ->setReplyTo('xxx@xxx.xxx')

        $message = \Swift_Message::newInstance()
            ->setSubject($subjet)
            ->setFrom($from) // 'info@achgroupe.com' => 'Achgroupe : Course en ligne '
            ->setTo($to)
            ->setBody($this->renderView($routeview, $parm))
            //'MyBundle:Default:mail.html.twig'
            ->setContentType('text/html');
        return $this->get('mailer')->send($message);

    }
}
