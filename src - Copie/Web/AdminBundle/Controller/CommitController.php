<?php

namespace Web\AdminBundle\Controller;

use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Tests\Util\Validator;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Web\EntityBundle\Entity\Commit;
use Web\EntityBundle\Entity\CommitHistoric;
use Web\EntityBundle\Entity\Files;
use Web\EntityBundle\Entity\Historic;
use Web\EntityBundle\Entity\Participator;
use Web\EntityBundle\Entity\Planning;
use Web\EntityBundle\Entity\Projet;
use Web\EntityBundle\Entity\Task;
use Web\EntityBundle\Entity\User;
use Web\EntityBundle\Entity\Visitor;
use Web\EntityBundle\Form\CommitType;
use Web\EntityBundle\Form\ProjetUpdateType;
use Web\EntityBundle\Repository\UserRepository;

/**
 * @Route("/commit")
 */
class CommitController extends Controller
{

    /**
     * @Route("/{projectid}/delete/{id}", name="admin_comit_delete", requirements={"id": "\d+", "projetid": "\d+"})
     */
    public function deleteAction($id,$projectid)
    {
       
		$em = $this->getDoctrine()->getManager();
        /** @var Commit $commit */
        $commit = $em->getRepository("EntityBundle:Commit")->find($id);

        /** @var User $user */
        $user = $this->getUser();

        /** @var Participator $participator */
        $participator = $em->getRepository('EntityBundle:Participator')->findOneByUser($user->getId());

        /** @var Historic $exit */
        $exit = $em->getRepository('EntityBundle:Historic')->findOneByParticipator($participator->getId());

        /** @var Projet $projet */
        $projet = $em->getRepository('EntityBundle:Projet')->find($projectid);

        if($exit==null)
        {
            $array = ['id'=>$projet->getId(), "badUser_commit"=>""];
            return $this->redirect($this->generateUrl('admin_projet_detail',$array));
        }

        $em->remove($commit);
        $em->flush();

        $array = ['id'=>$projet->getId(), "deletesuccess_commit"=>""];
        return $this->redirect($this->generateUrl('admin_projet_detail',$array));
    }

    /**
     * @Route("/{projectid}/form/{id}", name="admin_commit_form", requirements={"id": "\d+", "projectid": "\d+"}, defaults={"id":0})
     */
    public function formAction(Request $request,$id,$projectid)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $this->getUser();
        /** @var Historic $exit */
        $exit = $em->getRepository('EntityBundle:Historic')->findOneByparticipator($user->getId());

        /** @var Projet $projet */
        $projet = $em->getRepository('EntityBundle:Projet')->find($projectid);


        if($exit==null){
            $array = ['id'=>$projet->getId(), "badInfo_commit"=>""];
            return $this->redirect($this->generateUrl('admin_projet_detail',$array));
        }

        $objet = $id==0? new Commit() : $em->getRepository('EntityBundle:Commit')->find($id);

        /** @var Form $form */
        $form = $this->get("form.factory")->create(CommitType::class,$objet);
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            $objet->setDate(new \DateTime());

            /** @var Participator $participant */
            $participant = $exit->getParticipator();

            $objet->setParticipator($participant);
            $objet->setCode(uniqid());
            /** @var Validator $validator */
            $validator = $this->get('validator');
            $error = $validator->validate($objet);
            if(count($error) == 0)
            {
                if($id==0)
                {
                    $em->persist($objet);
                    $em->flush();
                    $em->detach($objet);
                    $objet =new Commit();
                    $array['message'] = "";
                    /** @var Form $form */
                    $form = $this->get("form.factory")->create(CommitType::class,$objet);
                }
                else
                {
                    $em->flush();
                    $em->detach($objet);
                    $array = ['id'=>$projet->getId(), "success_commit"=>$objet->getCode()];
                    return $this->redirect($this->generateUrl('admin_projet_detail',$array));
                }

            }
            else{
                $array['error'] = $error;
               // var_dump($error);
            }
        }
        $array['form'] = $form->createView();
        $array['objet'] = $objet;
        return $this->render('AdminBundle:Commit:form.html.twig',$array);
    }




    /**
     * @Route("/{projectid}/add/", name="admin_commit_add", requirements={"projectid": "\d+"})
     */
    public function addAction(Request $request,$projectid)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $this->getUser();

        /** @var Projet $projet */
        $projet = $em->getRepository('EntityBundle:Projet')->find($projectid);


        if($request->isMethod('POST'))
        {

            $commit  =new Commit();
            /** @var Participator $participant */
            $participant = $em->getRepository('EntityBundle:Participator')->findOneByuser($user->getId());
            $message = $request->request->get('description');
            $task_id = $request->request->get('task_id');

            /** @var Task $task */
            $task = $em->getRepository('EntityBundle:Task')->find($task_id);

            $commit->setParticipator($participant);
            $commit->setCode(uniqid());

            $commit->setDescription($message);
            $commit->setDate(new \DateTime());
            $historic = new CommitHistoric();
            $historic->setCommit($commit);
            $historic->setTask($task);

            $em->persist($historic);
            $em->flush();
            $em->detach($historic);
        }

        return $this->redirect($this->generateUrl('admin_projet_detail',['id'=>$projectid]));
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
