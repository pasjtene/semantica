<?php

namespace Web\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Web\EntityBundle\Entity\Contact;
use Web\EntityBundle\Entity\Customer;
use Web\EntityBundle\Entity\FileProjet;
use Web\EntityBundle\Entity\Files;
use Web\EntityBundle\Entity\Projet;
use Web\EntityBundle\Entity\User;

/**
 * @Route("/users")
 */
class UserController extends Controller
{


    /**
     * @Route("/", name="admin_users")
     */
    public function indexAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository("EntityBundle:User")->findActifUser();

        $array = ['items' => $items];

        return $this->render('AdminBundle:User:index.html.twig', $array);
    }



    /**
     * @Route("/change-state/{id}/{status}", options={"expose"=true}, name="admin_change_status_users")
     */
    public function changeStatusAction(Request $request, $id,$status)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $em->getRepository("EntityBundle:User")->find($id);

        if(is_object($user)){
            $status= $status==1?0:1;
            $user->setEnabled($status);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_users'));
    }

    /**
     * @Route("/{id}/change-role", name="admin_users_change_role")
     */
    public function changeRoleAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $em->getRepository("EntityBundle:User")->find($id);
        $allRoles = User::getAppRole();

        if(!is_object($user)){
            throw new NotFoundHttpException();
        }

        if($request->isMethod("POST"))
        {
            $roleIndex = intval($request->request->get('cb-role'));

            $user->setRoles([$allRoles[$roleIndex-1]]);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_users'));
        }

        return $this->render('AdminBundle:User:change-role.html.twig', ['user' => $user, 'roles' => $allRoles]);
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
     * @Route("/{id}/remove", options={"expose"=true}, name="admin_remove_users")
     */
    public function removeUserAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $em->getRepository("EntityBundle:User")->find($id);

        if(is_object($user)){
            $commits = $em->getRepository("EntityBundle:Commit")->findUser($id);
            $historics = $em->getRepository("EntityBundle:Participator")->findByuser($id);
            $projets = $em->getRepository("EntityBundle:Projet")->findByuser($id);
            foreach ($commits as $commit)
            {
                $em->remove($commit);
                $em->flush();
                $em->detach($commit);
            }

            foreach ($historics as $his)
            {
                $em->remove($his);
                $em->flush();
                $em->detach($his);
            }

            /** @var Projet $projet */
            foreach ($projets as $projet)
            {
                $files = new Files();
                /** @var FileProjet $file */
                foreach($projet->getFiles()  as $file)
                {
                    $files->delete('',$file->path());
                    $em->remove($file);
                    $em->flush();
                    $em->detach($file);
                }
                $em->remove($projet);
                $em->flush();
                $em->detach($projet);
            }
            $em->remove($user);
            $em->flush();
            $em->detach($user);
        }

        return $this->redirect($this->generateUrl('admin_users'));
    }
}
