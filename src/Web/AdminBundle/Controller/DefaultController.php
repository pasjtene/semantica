<?php

namespace Web\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Web\EntityBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="admin_homepage")
     */
    public function indexAction(Request $request)
    {
        if($request->isMethod("POST"))
        {
            $val = $request->request;
            $email = $val->get('_username');
            $password = md5($val->get('_password'));
            $em = $this->getDoctrine()->getManager();
            /** @var User $user */
            $user = $em->getRepository('EntityBundle:User')->findBy(['email'=>$email, "password"=>$password],['id'=>'DESC']);
            if($user!=null)
            {
                $this->get("session")->set('user',$user);
                $this->redirect($this->generateUrl('admin_projet'));
            }
        }
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
