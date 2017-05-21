<?php

namespace Web\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Web\EntityBundle\Entity\FileProjet;
use Web\EntityBundle\Entity\Files;
use Web\EntityBundle\Entity\Projet;
use Web\EntityBundle\Entity\User;
use Web\EntityBundle\Entity\Visitor;
use Web\EntityBundle\Form\FileProjetType;
use Web\EntityBundle\Form\ProjetType;
use Web\EntityBundle\Form\ProjetUpdateType;

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
        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository("EntityBundle:Projet")->findBy([],['id'=>'DESC']);
        $array['list'] = $list;
        return $this->render('AdminBundle:Project:index.html.twig',$array);
    }

    /**
     * @Route("/delete/{id}", name="admin_projet_delete", requirements={"id": "\d+"})
     */
    public function deleteAction($id)
    {
       
		$em = $this->getDoctrine()->getManager();
        /** @var Projet $project */
        $project = $em->getRepository("EntityBundle:Projet")->find($id);
        $files = new Files();
        if($project->getFiles()!=null)
        {
            /** @var FileProjet $file */
            foreach($project->getFiles()  as $file)
            {
                $files->delete('',$file->path());
                $em->remove($file);
                $em->flush();
                $em->detach($file);
            }

        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($project);
        $em->flush();
		

        return $this->redirect($this->generateUrl('admin_homepage'));
    }

    /**
     * @Route("/detail/{id}", name="admin_projet_detail", requirements={"id": "\d+"})
     */
    public function detailAction($id)
    {

        $array['id'] =$id;
        return $this->render('AdminBundle:Project:detail.html.twig',$array);
    }


    /**
     * @Route("/information/{id}", name="admin_projet_information", requirements={"id": "\d+"})
     */
    public function informationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Projet $items */
        $items = $em->getRepository("EntityBundle:Projet")->find($id);
        $array['items'] =$items;
        $array['id'] =$id;
        return $this->render('AdminBundle:Project:information.html.twig', $array);
    }


    /**
     * @Route("/participator/{id}", name="admin_projet_participator", requirements={"id": "\d+"})
     */
    public function participatorAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository("EntityBundle:Historic")->findByproject($id);
        $array['items'] =$items;
        $array['id'] =$id;
        return $this->render('AdminBundle:Project:participator.html.twig', $array);
    }


    /**
     * @Route("/planning/{id}", name="admin_projet_planning", requirements={"id": "\d+"})
     */
    public function planningAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository("EntityBundle:Planning")->findByproject($id);
        $array['items'] =$items;
        $array['id'] =$id;
        return $this->render('AdminBundle:Project:planning.html.twig', $array);
    }


    /**
     * @Route("/commit/{id}", name="admin_projet_commit", requirements={"id": "\d+"})
     */
    public function commitAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository("EntityBundle:CommitHistoric")->findByproject($id);
        $array['items'] =$items;
        $array['id'] =$id;
        return $this->render('AdminBundle:Project:commit.html.twig', $array);
    }




    /**
     * @Route("/update/{id}", name="admin_projet_update", requirements={"id": "\d+"})
     */
    public function updateAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();

        /** @var Projet $objet */
        $objet = $em->getRepository('EntityBundle:Projet')->find($id);

        $this->get('session')->set('user_session',$objet->getUser());
        $this->get('session')->set('visitor_session',$objet->getVisitor());

        /** @var Form $form */
        $form = $this->get("form.factory")->create(ProjetUpdateType::class,$objet);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            $objet->setDate(new \DateTime());
            $file = new Files();


            if($objet->getUser()!=null)
            {
                /** @var User $user */
                $user =$em->getRepository('EntityBundle:User')->find($objet->getUser()->getId());
                $objet->setUser($user);
                var_dump($user);
                $email =$objet->getUser()->getEmail();
            }
            if($objet->getVisitor()!=null)
            {
                /** @var Visitor $visitor */
                $visitor =$em->getRepository('EntityBundle:Visitor')->find($objet->getVisitor()->getId());
                $objet->setVisitor($visitor);
                $email =$objet->getVisitor()->getEmail();
            }

            $objet->setStatus($request->request->get('code'));
            if($objet->getStatus()!="0")
            {
                //$objet->setState(true);
            }


            /** @var Validator $validator */
            $validator = $this->get('validator');
            $error = $validator->validate($objet);
            if(count($error) == 0)
            {

                $em->persist($objet);
                $em->flush();

                $em->detach($objet);

                $translator = $this->get('translator');
                $locale = $this->get('session')->get('_locale');
                $message = $translator->trans('form.project.notification',[] ,'forms', $locale);
                $code = $this->sendMail($email, $this->getParameter('mailer_user'), $message, "UPDATE PROJET STC(SEMANTICA TECHNOLOGIES CORPORATION)");
                return $this->redirect($this->generateUrl('admin_homepage'));
            }
            else{
                $array['error'] = $error;
                 var_dump($error);
            }

        }

        $array["index"] =3;
        $array['form'] = $form->createView();
        $array['objet'] = $objet;
        return $this->render('AdminBundle:Project:index.html.twig',$array);
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
