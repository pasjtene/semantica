<?php

namespace Web\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Web\EntityBundle\Entity\Contact;
use Web\EntityBundle\Entity\Customer;
use Web\EntityBundle\Entity\Projet;
use Web\EntityBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="admin_homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository("EntityBundle:Projet")->findBy([],['id'=>'DESC','date'=>'DESC']);
        $array['list'] = $list;
        return $this->render('AdminBundle:Default:index.html.twig',$array);
    }


    /**
     * @Route("/test", name="admin_test")
     */
    public function testAction()
    {
        return $this->render('AdminBundle:Default:test.html.twig');
    }

    /**
     * @Route("/contact", name="admin_contact")
     */
    public function contactAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository("EntityBundle:Suggestion")->findBy([],['id'=>'DESC']);
        if($request->isMethod("POST"))
        {
            $val = $request->request;
            $important = $val->get('important');
            if($important !="")
            {
                $list = $em->getRepository("EntityBundle:Contact")->findBy(["important"=>$important],['id'=>'DESC']);
            }
        }
        if($request->query->get("message")!=null){
            $array['message'] = "test";
        }
        $array['list']=$list;
        return $this->render('AdminBundle:Default:contact.html.twig',$array);
    }

    /**
     * @Route("/contact/send/{id}", name="admin_sendcontact", requirements={"id": "\d+"})
     */
    public function sendMailcontactAction(Request $request,$id)
    {


        if($request->isMethod("POST"))
        {
            $val = $request->request;
            $message = $val->get('message');
            $objet = $val->get('objet');
            $em = $this->getDoctrine()->getManager();
            /** @var Contact $contact */
            $contact = $em->getRepository("EntityBundle:Contact")->find($id);
            $to =$contact->getEmail();
            $from =$this->getParameter('mailer_user');
            $subjet = $objet;
            $routeview ="AdminBundle:Inc:email.html.twig";
            $param =['message'=>$message, 'objet'=>$objet];
            $code = $this->sentMail($to, $from, $routeview, $param,$subjet);
        }

        return $this->redirect($this->generateUrl('admin_contact',["message"=>"test"]));
    }

    /**
     * @Route("/customer/send/{id}", name="admin_sendcustomer", requirements={"id": "\d+"})
     */
    public function sendMailcustomerAction(Request $request,$id)
    {

        if($request->isMethod("POST"))
        {
            $val = $request->request;
            $message = $val->get('message');
            $objet = $val->get('objet');
            $em = $this->getDoctrine()->getManager();
            /** @var Customer $customer */
            $customer = $em->getRepository("EntityBundle:Customer")->find($id);
            $to =$customer->getEmailadress();
            $from =$this->getParameter('mailer_user');
            $subjet = $objet;
            $routeview ="AdminBundle:Inc:email.html.twig";
            $param =['message'=>$message, 'objet'=>$objet];
            $code = $this->sentMail($to, $from, $routeview, $param,$subjet);
           // return $this->testcustomerAction($param);
        }

        return $this->redirect($this->generateUrl('admin_customer',["message"=>"test"]));
    }

    public  function sentMail($to, $from, $routeview, $param,$subjet)
    {
        // ->setReplyTo('xxx@xxx.xxx')

        $message = \Swift_Message::newInstance()
            ->setSubject($subjet)
            ->setFrom($from) // 'info@achgroupe.com' => 'Achgroupe : Course en ligne '
            ->setTo($to)
            ->setBody($this->renderView($routeview, $param))
            //'MyBundle:Default:mail.html.twig'
            ->setContentType('text/html');
        return $this->get('mailer')->send($message);

    }

    /**
     * @Route("/login", name="admin_login")
     */
    public function loginAction()
    {
        return $this->render('AdminBundle:Security:login.html.twig');
    }

    /**
     * @Route("/download/{id}", name="admin_download", requirements={"id": "\d+"})
     */
    public function downloadchatAction($id, Request $request){

        $em = $this->getDoctrine()
            ->getManager();
        /** @var Projet $objet */
        $objet = $em->getRepository("EntityBundle:Projet")
            ->find($id);
        // var_dump($objet);
        $response = new Response();
        /// $path = __DIR__.'/../../../../web/data/media/presentation/'.$objet->photo;
        // var_dump(__DIR__.'/../../../../web/'.$objet->photo);
       // $filename = $request->getSchemeAndHttpHost().'/hgdcam/web/'. $objet->path();
         $filename = $request->getSchemeAndHttpHost().'/'. $objet->path();
        $response->setContent(file_get_contents($filename));
        if(preg_match("#.*jpg.*#",strtolower($objet->getHashFiles())))
        {
            $response->headers->set('Content-Type', 'application/JPG');
        }else  if(preg_match("#.*png.*#",strtolower($objet->getHashFiles())))
        {
            $response->headers->set('Content-Type', 'application/PNG');
        }else  if(preg_match("#.*gif.*#",strtolower($objet->getHashFiles())))
        {
            $response->headers->set('Content-Type', 'application/GIF');
        }else if(preg_match("#.*pdf.*#",strtolower($objet->getHashFiles())))
        {
            $response->headers->set('Content-Type', 'application/PDF');
        }else{
            $response->headers->set('Content-Type', 'application/force-download');
        }
        //$response->headers->set('Content-Type', 'application/force-download'); // modification du content-type pour forcer le téléchargement (sinon le navigateur internet essaie d'afficher le document)
        // $filename ="localhost/hgdcam/web/data/media/presentation/Motdg.pdf"; //$request->getBaseUrl()."web/".$objet->path();
        $response->headers->set('Content-disposition', 'filename='. $filename);

        return $response;
    }


}
