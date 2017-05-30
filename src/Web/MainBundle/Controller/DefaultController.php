<?php

namespace Web\MainBundle\Controller;

use Doctrine\DBAL\Schema\Visitor\Visitor;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Tests\Util\Validator;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Web\EntityBundle\Entity\Contact;
use Web\EntityBundle\Entity\Customer;
use Web\EntityBundle\Entity\Suggestion;
use Web\EntityBundle\Entity\User;
use Web\EntityBundle\Form\SuggestionType;
use Web\EntityBundle\Form\UserType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="main_homepage")
     */
    public function indexAction(Request $request)
    {
        //$link  =$this->generateUrl('main_confirm',[md5('email') =>'test@gmail.com'], UrlGeneratorInterface::ABSOLUTE_URL);
        //$html = '<a href="'.$link.'">'.$link.'</a>';
        //var_dump($html);

        $suggestion = new Suggestion();
        /** @var Form $form */
        $form = $this->get("form.factory")->create(SuggestionType::class,$suggestion);

        $array['form'] = $form->createView();
        $array["suggestion"] =$suggestion;
        $array["index"] =1;
        return $this->render('MainBundle:Default:index.html.twig',$array);
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


            $suggestion = new Suggestion();
            /** @var Form $form */
            $form = $this->get("form.factory")->create(SuggestionType::class,$suggestion);

            $array['form'] = $form->createView();
            $array["suggestion"] =$suggestion;


            $customer = $em->getRepository('EntityBundle:User')->findOneByemail($email);
            if($customer!=null)
            {
                $array["error"] = $email;
                return $this->render('MainBundle:Default:index.html.twig',$array);
            }
            $locale = $this->get('session')->get('_locale');
            $link  =$this->generateUrl('main_confirm',[md5('email') =>$email], UrlGeneratorInterface::ABSOLUTE_URL);
            $linkunscribe  =$this->generateUrl('main_homepage',[md5('email') =>$email], UrlGeneratorInterface::ABSOLUTE_URL);
            $message =  $translator->trans('sendmail.content',[] ,'home', $locale);
            $array['body'] = $message;
            $array['link'] = $link;
            //$link  =$this->generateUrl('main_confirm',[md5('email') =>$email], UrlGeneratorInterface::ABSOLUTE_URL);
            //$html = $message.' <a href="'.$link.'">'.$link.'</a>';
            $routeview = 'MainBundle:Mail:subscribe.html.twig';
            $param = ['email'=>$email,'link'=>$link, 'linkunsubscribe'=>$linkunscribe];
            $code = $this->sentMail($email, $this->getParameter('mailer_user'), $routeview,$param, "SIGN UP TO STC(SEMANTICA TECHNOLOGIES CORPORATION)");
            //$code = $this->sendMail($email, $this->getParameter('mailer_user'), $html, "SIGN UP TO STC(SEMANTICA TECHNOLOGIES CORPORATION)");
            //$code =$this->sentMail($email,$this->getParameter('mailer_user'),'MainBundle:Inc:confirm.html.twig',$array,"Confirmation");
            $tab = explode('@',$email);
            $array["message"] = "...@".$tab[count($tab)-1];

            // index

            return $this->render('MainBundle:Default:index.html.twig',$array);
           // return $this->redirect($this->generateUrl('main_homepage',["message"=>"test"]));
        }
    }



    /**
     * @Route("/confirm", name="main_confirm")
     */
    public function confirmAction(Request $request)
    {
        $val = $request->query;
        $email = $val->get(md5('email'));
        $objet = new User();

        /** @var Form $form */
        $form = $this->get("form.factory")->create(UserType::class,$objet);

        if($request->isMethod("POST"))
        {

            $form->handleRequest($request);
            $email = $request->request->get("email");
            $em = $this->getDoctrine()->getManager();
            $objet->setEnabled(true);
            $objet->setEmail($email);
            //$objet->setStatus("Actif");
            $objet->setRoles(['ROLE_USER']);

            /** @var Validator $validator */
            $validator = $this->get('validator');
            $error = $validator->validate($objet);
            if(count($error) == 0)
            {
                $password = $this->encodePassword(new User(), $objet->getPassword(), $objet->getSalt());

                $objet->setPassword($password);

                $em->persist($objet);
                $em->flush();
                $em->detach($objet);
                $this->authenticateUser($objet);

                return $this->redirect($this->generateUrl('main_private'));
            }
            else{
                $array['error'] = $error;
                //var_dump($error);
            }

        }
        if($email==null )
        {
            return $this->redirect($this->generateUrl("error_page"));
        }
        $array['form'] = $form->createView();
        $array['objet'] = $objet;
        $array['email'] = $email;
        return $this->render('MainBundle:Default:confirm.html.twig',$array);
    }

    /**
     * @Route("/contact", name="main_contact")
     */
    public function  contactAction(Request $request)
    {
        $array =[];


        $suggestion = new Suggestion();
        /** @var Form $form */
        $form = $this->get("form.factory")->create(SuggestionType::class,$suggestion);

        if($request->isMethod("POST"))
        {
            $form->handleRequest($request);
            $ip = $_SERVER['REMOTE_ADDR'];
            $suggestion->setDate(new \DateTime());
            $suggestion->setStatus(false);
            $suggestion->getVisitor()->setPhone(uniqid());
            $suggestion->getVisitor()->setPleasantries("//");
            $suggestion->getVisitor()->setIp($ip);
            $em =$this->getDoctrine()->getManager();

            /** @var Visitor $visitor */
            $visitor = $em->getRepository('EntityBundle:Visitor')->findOneByemail($suggestion->getVisitor()->getEmail());

            if($visitor!=null)
            {
                $suggestion->setVisitor($visitor);
            }
           // var_dump($suggestion->getVisitor()->getEmail());

            /** @var Validator $validator */
            $validator = $this->get('validator');
            $error = $validator->validate($suggestion);

            if(count($error)==0)
            {

                $em->persist($suggestion);
                $em->flush();
                $em->detach($suggestion);

                $email  = $suggestion->getVisitor()->getEmail();
                $name = $suggestion->getVisitor()->getFirstname();
                $translator = $this->get('translator');
                $locale = $this->get('session')->get('_locale');
                $message =  $suggestion->getVisitor()->getFirstname().', '.$translator->trans('contact.message',[] ,'home', $locale);

                $routeview = 'MainBundle:Mail:subscribe.html.twig';
                $param = ['email'=>'http://'.$email,'name'=>$name, 'semail'=>$email];
                $code = $this->sentMail($email, $this->getParameter('mailer_user'), $routeview,$param, "CONTACT UP TO STC(SEMANTICA TECHNOLOGIES CORPORATION)");

                //$code = $this->sendMail($suggestion->getVisitor()->getEmail(), $this->getParameter('mailer_user'), $message, "Contact STC(SEMANTICA TECHNOLOGIES CORPORATION)");
                $array['confirm'] ="";
                $suggestion =new Suggestion();
                /** @var Form $form */
                $form = $this->get("form.factory")->create(SuggestionType::class,$suggestion);
            }
            else
            {
                $array['error'] = "";
                //var_dump($error);
            }
        }
        $array['form'] = $form->createView();
        $array["suggestion"] =$suggestion;
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




    public function encodePassword($object, $password, $salt)
    {
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($object);
        $password = $encoder->encodePassword($password, $salt);

        return $password;
    }


    public function authenticateUser(UserInterface $user)
    {
        try {

            $tocken = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($tocken);
            $this->get('session')->set('_security_main',serialize($tocken));

        } catch (AccountStatusException $ex) {
            //var_dump($ex->getMessage());
        }
    }


    /**
     * @Route("/login", name="main_login")
     */
    public function loginAction()
    {
        return $this->render('MainBundle:Security:login.html.twig');
    }




    /**
     * @Route("/editpassword", name="main_editpassword")
     */
    public function editpasswordAction(Request $request)
    {
        if($request->isMethod('POST'))
        {

            $email = $request->query->get('email');
            $em = $this->getDoctrine()->getManager();
            /** @var User $user */
            $user = $em->getRepository("EntityBundle:User")->findOneByemail($email);
            if($user!=null)
            {
                $translator = $this->get('translator');

                $em = $this->getDoctrine()->getManager();

                $password = $request->request->get('password');
                $password = $this->encodePassword(new User(), $password, $user->getSalt());

                $user->setPassword($password);

                $em->persist($user);
                $em->flush();
                $em->detach($user);
                $this->authenticateUser($user);

                return $this->redirect($this->generateUrl('main_private'));

            }

        }
        return $this->render('MainBundle:Default:editpassword.html.twig');
    }


    /**
     * @Route("/resetpassword", name="main_resetpassword")
     */
    public function resetpasswordAction(Request $request)
    {


        $array=[];
        if($request->isMethod('POST'))
        {



            $email = $request->request->get('email');
            $em = $this->getDoctrine()->getManager();
            /** @var User $user */
            $user = $em->getRepository("EntityBundle:User")->findOneByemail($email);
            if($user!=null)
            {
                $translator = $this->get('translator');

                $em = $this->getDoctrine()->getManager();

                $locale = $this->get('session')->get('_locale');
                $message = $translator->trans('login.reset',[] ,'nav', $locale);
                $link  =$this->generateUrl('main_editpassword',[md5('email') =>$user->getEmail()], UrlGeneratorInterface::ABSOLUTE_URL);
                $html = $message.' <a href="'.$link.'">'.$link.'</a>';
                $unlink  =$this->generateUrl('main_homepage',[md5('email') =>$email], UrlGeneratorInterface::ABSOLUTE_URL);
                $routeview = 'MainBundle:Mail:subscribe.html.twig';
                $param = ['link'=>$link,'unlink'=>$unlink,'email'=>'http://'.$email,'name'=>$user->getFirstname() .' '. $user->getLastname(), 'semail'=>$email];
                $code = $this->sentMail($email, $this->getParameter('mailer_user'), $routeview,$param, "RESET PASSWORD  TO STC(SEMANTICA TECHNOLOGIES CORPORATION)");

                //$code = $this->sendMail($user->getEmail(), $this->getParameter('mailer_user'), $html, "SIGN UP TO STC(SEMANTICA TECHNOLOGIES CORPORATION)");
                //$code =$this->sentMail($email,$this->getParameter('mailer_user'),'MainBundle:Inc:confirm.html.twig',$array,"Confirmation");
                $tab = explode('@',$user->getEmail());
                $array["message"] = "...@".$tab[count($tab)-1];
                return $this->render('MainBundle:Default:index.html.twig',$array);
            }
            $array['error'] = "I am";
        }


        return $this->render('MainBundle:Default:resetpassword.html.twig',$array);
    }




}
