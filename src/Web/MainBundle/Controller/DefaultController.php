<?php

namespace Web\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="main_homepage")
     */
    public function indexAction()
    {
        return $this->render('MainBundle:Default:index.html.twig');
    }

    /**
     * @Route("/", name="main_signup")
     */
    public function signupAction()
    {
        return $this->render('MainBundle:Default:signup.html.twig');
    }

    /**
     * @Route("/", name="main_contact")
     */
    public function  contactAction(Request $request)
    {
        $val = $request->request;
        $email = $val->get('c_email');
        $name = $val->get('name');
        $message = $val->get('message');
        $code =$this->sendMail($email,$this->getParameter('mailer_user'),$message,"Contact : ".$name);
        return $this->redirect($this->generateUrl('main_homepage'));
    }

    public  function sendMail($to, $from, $body,$subjet)
    {
        // ->setReplyTo('xxx@xxx.xxx')

        $message = \Swift_Message::newInstance()
            ->setSubject($subjet)
            ->setFrom($from) // 'info@achgroupe.com' => 'Achgroupe : Course en ligne '
            ->setTo($to)
            ->setBody($body)
            //'MyBundle:Default:mail.html.twig'
            ->setContentType('text/html');
        return $this->get('mailer')->send($message);

    }
}
