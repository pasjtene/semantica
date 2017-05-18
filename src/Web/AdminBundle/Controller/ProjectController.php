<?php

namespace Web\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Web\EntityBundle\Entity\FileProjet;
use Web\EntityBundle\Entity\Files;
use Web\EntityBundle\Entity\Projet;
use Web\EntityBundle\Form\FileProjetType;
use Web\EntityBundle\Form\ProjetType;

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
            $files->delete('',$project->path());
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
        $em = $this->getDoctrine()->getManager();
        /** @var Projet $project */
        $project = $em->getRepository("EntityBundle:Projet")->find($id);
        $array['project'] =$project;
        return $this->render('AdminBundle:Default:detail.html.twig', $array);
    }


    /**
     * @Route("/update/{id}", name="admin_projet_update", requirements={"id": "\d+"})
     */
    public function updateAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();

        /** @var Projet $objet */
        $objet = $em->getRepository('EntityBundle:Projet')->find($id);
        /** @var Form $form */
        $form = $this->get("form.factory")->create(FileProjetType::class,$objet);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            $objet->setDate(new \DateTime());
            $file = new Files();
            if ($objet->getFiles() != null) {

                /** @var FileProjet $item */
                foreach ($objet->getFiles() as $item){
                    $file->file = $item->getFile();

                    $tab = explode('.',$item->getFile()->getClientOriginalName());
                    $item->setName($item->getFile()->getClientOriginalName());
                    $item->setExtfile($tab[count($tab)-1]);
                    $item->setHashname(uniqid().'.'.$item->getExtfile());
                    $item->setProject($objet);
                    $file->add($file->initialpath."projet",  $item->getHashname());
                }


            }


            /** @var Validator $validator */
            $validator = $this->get('validator');
            $error = $validator->validate($objet);
            if(count($error) == 0)
            {

                $email =$objet->getUser()==null ? $objet->getVisitor()->getEmail(): $objet->getUser()->getEmail();

                $em->persist($objet);
                $em->flush();

                $em->detach($objet);

                $translator = $this->get('translator');
                $locale = $this->get('session')->get('_locale');
                $message = $translator->trans('form.project.notification',[] ,'forms', $locale);
                $code = $this->sendMail($email, $this->getParameter('mailer_user'), $message, "SOMMIT PROJET STC(SEMANTICA TECHNOLOGIES CORPORATION)");

                $objet = new Projet();
                /** @var Form $form */
                $form = $this->get("form.factory")->create(ProjetType::class,$objet);
                $array['message'] ="";
            }
            else{
                $array['error'] = $error;
                // var_dump($error);
            }

        }

        $array["index"] =3;
        $array['form'] = $form->createView();
        $array['objet'] = $objet;
        return $this->render('MainBundle:Projet:index.html.twig',$array);
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
