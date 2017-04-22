<?php

namespace Web\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Web\EntityBundle\Entity\Contact;
use Web\EntityBundle\Entity\Customer;

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
     * @Route("/singup", name="main_signup")
     */
    public function signupAction(Request $request)
    {
        if($request->isMethod("POST"))
        {
            $translator = $this->get('translator');

            $val = $request->request;
            $email = $val->get('email');

            $em = $this->getDoctrine()->getManager();

            $customer = $em->getRepository('EntityBundle:Customer')->findByemailadress($email);
            if($customer!=null)
            {
                $array["error"] = $email;
                return $this->render('MainBundle:Default:index.html.twig',$array);
            }
            $locale = $this->get('session')->get('_locale');
            $link  =$this->generateUrl('main_confirm',[md5('email') =>$email], UrlGeneratorInterface::ABSOLUTE_URL);
            $message =  $translator->trans('sendmail.content',[] ,'home', $locale);
            $array['body'] = $message;
            $array['link'] = $link;
            $code =$this->sentMail($email,$this->getParameter('mailer_user'),'MainBundle:Inc:confirm.html.twig',$array,"Confirmation");
            $tab = explode('@',$email);
            $array["message"] = "...@".$tab[count($tab)-1];
            return $this->render('MainBundle:Default:index.html.twig',$array);
        }
    }



    /**
     * @Route("/confirm", name="main_confirm")
     */
    public function confirlAction(Request $request)
    {
        $val = $request->query;

        $email = $val->get(md5('email'));
        if($email!=null )
        {
            //$email = str_replace("%40","@",$email)==null?$email:str_replace("%40","@",$email);
            $em = $this->getDoctrine()->getManager();
            $costomer = new Customer();
            $costomer->setDate(new \DateTime())->setEmailadress($email);
            $em->persist($costomer);
            $em->flush();
        }
        return $this->render('MainBundle:Default:confirm.html.twig');
    }

    /**
     * @Route("/contact", name="main_contact")
     */
    public function  contactAction(Request $request)
    {
        $array =[];
        if($request->isMethod("POST")) {
            $val = $request->request;
            $email = $val->get('c_email');
            $name = $val->get('name');
            $message = $val->get('message');

            $em = $this->getDoctrine()->getManager();
            $contact = new Contact();
            $contact->setDate(new \DateTime())->setEmail($email)->setMessage($message)->setName($name);
            $em->persist($contact);
            $em->flush();
            $code = $this->sendMail($email, $this->getParameter('mailer_user'), $message, "Contact : " . $name);
            $array['confirm'] ="";
        }

        return $this->render('MainBundle:Default:index.html.twig',$array);
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
