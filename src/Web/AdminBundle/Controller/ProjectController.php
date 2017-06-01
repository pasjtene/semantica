<?php

namespace Web\AdminBundle\Controller;

use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Tests\Util\Validator;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Web\EntityBundle\Entity\Comment;
use Web\EntityBundle\Entity\FileProjet;
use Web\EntityBundle\Entity\Files;
use Web\EntityBundle\Entity\Historic;
use Web\EntityBundle\Entity\Participator;
use Web\EntityBundle\Entity\Planning;
use Web\EntityBundle\Entity\Projet;
use Web\EntityBundle\Entity\Task;
use Web\EntityBundle\Entity\User;
use Web\EntityBundle\Entity\Visitor;
use Web\EntityBundle\Form\ProjetUpdateType;
use Web\EntityBundle\Repository\UserRepository;

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

    public function exludeUser($allUsers, $participants)
    {
        $result = [];

        /** @var User $user */
        foreach ($allUsers as $user)
        {
            $exist = false;
            /** @var Historic $participant */
            foreach ($participants as $participant)
            {
                if($user->getId() == $participant->getParticipator()->getUser()->getId()){
                    $exist = true;
                    break;
                }
            }

            if(!$exist){
                $result[] = $user;
            }
        }

        return $result;
    }

    /**
     * @Route("/view/{id}", name="admin_projet_new_participator", requirements={"id": "\d+"})
     */
    public function viewProjetAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Projet $project */
        $project = $em->getRepository("EntityBundle:Projet")->find($id);

        if(!is_object($project)){
            throw new NotFoundHttpException();
        }

        if($request->isMethod("POST"))
        {
            $params = [
                'hid' => intval($request->request->get('historic-id')),
                'userid' => $request->request->get("user-choice"),
                'roles' => $request->request->get("roles"),
                'startdate' => new \DateTime($request->request->get("start-date")),
                'enddate' => $request->request->get("end-date"),
                'input-action' => intval($request->request->get('input-action'))
            ];

            /** @var User $user */
            $user = $em->getRepository('EntityBundle:User')->find($params['userid']);

            if ($params['input-action'] == 0) {
                $participator = new Participator();
                $participator->setUser($user)->generateCode();

                $em->persist($participator);
                $em->flush();

                $historic = new Historic();
                $historic->setParticipator($participator)->setProject($project)->setRoles($params['roles'])->setStartdate($params['startdate']);
                if (strlen($params['enddate']) > 0) {
                    $historic->setEnddate(new \DateTime($params['enddate']));
                    $participator->setIsActive(false);
                }

                $em->persist($historic);
                $em->flush();
            }
            else
            {

            }
        }

        return $this->redirect($this->generateUrl('admin_projet_detail', ['id' => $id])."#participator");
    }

    /**
     * @Route("participators/{id}", name="admin_projet_participator", requirements={"id": "\d+"})
     */
    public function getParticipatorAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $participants = $em->getRepository('EntityBundle:Historic')->findByParticipator($id);

        $serializer = SerializerBuilder::create()->build();

        $jsonContent = $serializer->serialize($participants, 'json');

        return new Response($jsonContent);
    }

    /**
     * @Route("/detail/{id}", name="admin_projet_detail", requirements={"id": "\d+"})
     */
    public function detailAction($id)
    {
        $array['id'] =$id;
        $em = $this->getDoctrine()->getManager();

       $items = $em->getRepository("EntityBundle:Task")->findAll();

        $tasks = null;
        /** @var Task $item */
        foreach($items as $item )
        {
            if($item->getPlanning()->getProject()->getId()==$id)
            {
                $tasks[]=$item;
            }
        }
        $array['tasks'] = $tasks;
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
        $data['project_id']=$id;
        $array['participants'] =$em->getRepository("EntityBundle:Historic")->getByParticipant($data);
        $array['id'] =$id;
        $array['tabs'] = 1;
        return $this->render('AdminBundle:Project:information.html.twig', $array);
    }

    /**
     * @Route("/comment/{id}", name="admin_projet_comment", requirements={"id": "\d+"})
     */
    public function commentAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository("EntityBundle:Comment")->findByprojet($id);

        $data['project_id']=$id;
        $array['participants'] =$em->getRepository("EntityBundle:Historic")->findAll();
        $array['items'] =$items;
        $array['id'] =$id;
        $array['tabs'] = 5;

        return $this->render('AdminBundle:Project:comment.html.twig', $array);
    }

    /**
     * @Route("/participator/{id}", name="admin_projet_participator", requirements={"id": "\d+"})
     */
    public function participatorAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository("EntityBundle:Historic")->findCurrentParticipators($id);

        $users = $em->getRepository('EntityBundle:User')->findStaff();
        $users = $this->exludeUser($users, $items);

        $array['items'] =$items;
        $array['users'] =$users;
        $array['id'] =$id;
        $array['tabs'] = 2;
        return $this->render('AdminBundle:Project:participator.html.twig', $array);
    }

    /**
     * @Route("/{pid}/delete-participator/{id}", name="admin_projet_delete_participator", options={"expose"=true}, requirements={"id": "\d+"})
     */
    public function deleteParticipatorAction($pid, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Participator $participator */
        $participator = $em->getRepository("EntityBundle:Participator")->find($id);

        /** @var Historic $currentHistoric */
        $currentHistoric = $em->getRepository("EntityBundle:Historic")->findCurrentHistoric($id);

        if(is_object($participator))
        {
            $currentHistoric->setEnddate(new \DateTime());
            $participator->setIsActive(false);

            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_projet_detail', ['id' => $pid])."#participator");
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
        $array['tabs'] = 4;
        return $this->render('AdminBundle:Project:planning.html.twig', $array);
    }

    /**
     * @Route("/commit/{id}", name="admin_projet_commit", requirements={"id": "\d+"})
     */
    public function commitAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $em = $this->getDoctrine()->getManager();
        $query =$em->getRepository("EntityBundle:CommitHistoric");
        $data = ['title'=>'', "status"=>"" , "libelle"=>"", "project_id"=>$id, "user_id"=>null, "task_id"=>null];
        $items = $query->getByparamProject($data);


        $collections = $em->getRepository("EntityBundle:Task")->findAll();

        $tasks = null;
        /** @var Task $item */
        foreach($collections as $item )
        {
            if($item->getPlanning()->getProject()->getId()==$id)
            {
                $tasks[]=$item;
            }
        }


        $istask = $tasks==null? 0: 1;
        $array['istask'] = $istask;

        $array['items'] =$items;
        $array['id'] =$id;
        $array['tabs'] = 3;
        $array['historics'] =$em->getRepository("EntityBundle:Historic")->findAll();
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
                //var_dump($error);
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

    /**
     * @Route("/{id}/planning", name="admin_projet_new_planning", requirements={"id": "\d+"})
     */
    public function newPlanningAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        if($request->isMethod("POST"))
        {
            $params = [
                'startdate' => new \DateTime($request->request->get("start-date")),
                'enddate' => new \DateTime($request->request->get("end-date")),
                'pid' => $request->request->get("planning-id")
            ];

            /** @var Projet $project */
            $project = $em->getRepository("EntityBundle:Projet")->find($id);

            if(!is_object($project)){
                throw new NotFoundHttpException();
            }

            if(intval($params['pid']) == 0)
            {
                $planning = new Planning();
                $planning->setStartdate($params['startdate'])->setEnddate($params['enddate'])->setProject($project);

                $em->persist($planning);
            }
            else{
                /** @var Planning $planning */
                $planning = $em->getRepository('EntityBundle:Planning')->find($params['pid']);
                $planning->setStartdate($params['startdate'])->setEnddate($params['enddate']);
            }

            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_projet_detail', ['id' => $id])."#planning");
    }

    /**
     * @Route("/{id}/planning-new-task", name="admin_projet_new_planning_task", requirements={"id": "\d+"})
     */
    public function newPlanningTaskAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        if($request->isMethod("POST"))
        {
            $params = [
                'label' => $request->request->get("label"),
                'description' => $request->request->get("description"),
                'status' => $request->request->get("task-status"),
                'rate' => $request->request->get("rate"),
                'pid' => $request->request->get('planning-id')
            ];

            /** @var Planning $planning */
            $planning = $em->getRepository("EntityBundle:Planning")->find($params['pid']);

            if(!is_object($planning)){
                throw new NotFoundHttpException();
            }

            $task = new Task();
            $task->setLibelle($params['label'])->setDescription($params['description'])->setStatus($params['status'])
                 ->setIdentity(uniqid('tsk_'))->setRate($params['rate'])->setPlanning($planning)
                 ->setDate(new \DateTime());

            $em->persist($task);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_projet_detail', ['id' => $id])."#planning");
    }

    /**
     * @Route("/{projectid}/planning/{id}", name="admin_projet_delete_planning", requirements={"projectid": "\d+", "id": "\d+"})
     */
    public function deletePlanningAction($projectid, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Projet $project */
        $project = $em->getRepository("EntityBundle:Projet")->find($projectid);

        if(!is_object($project)){
            throw new NotFoundHttpException();
        }

        /** @var Planning $planning */
        $planning = $em->getRepository('EntityBundle:Planning')->find($id);

        if(is_object($planning)){
            $em->remove($planning);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_projet_detail', ['id' => $projectid])."#planning");
    }

    /**
     * @Route("/{projectid}/planning/{id}/get", name="admin_projet_get_planning", requirements={"projectid": "\d+", "id": "\d+"})
     */
    public function getPlanningTaskAction($projectid, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Projet $project */
        $project = $em->getRepository("EntityBundle:Projet")->find($projectid);

        if(!is_object($project)){
            throw new NotFoundHttpException();
        }

        /** @var Planning $planning */
        $planning = $em->getRepository('EntityBundle:Planning')->find($id);

        if(is_object($planning))
        {
            $serializer = SerializerBuilder::create()->build();

            $jsonContent = $serializer->serialize($planning, 'json');

            return new Response($jsonContent);
        }

        return new JsonResponse(null);
    }

    /**
     * @Route("/{projectid}/delete-task/{id}", name="admin_projet_delete_task", options={"expose"=true}, requirements={"projectid": "\d+", "id": "\d+"})
     */
    public function deletePlanningTaskAction($projectid, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Projet $project */
        $project = $em->getRepository("EntityBundle:Projet")->find($projectid);

        if(!is_object($project)){
            throw new NotFoundHttpException();
        }

        /** @var Task $task */
        $task = $em->getRepository('EntityBundle:Task')->find($id);

        if(is_object($task)){
            $em->remove($task);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_projet_detail', ['id' => $projectid])."#planning");
    }

    /**
     * @Route("/comment/add/{id}", name="admin_comment_add", requirements={"id": "\d+"})
     */
    public function send_projectAction(Request $request,$id)
    {
        $code="";
        /** @var User $user */
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();


        if($request->isMethod("POST"))
        {
            $val = $request->request;


            /** @var User $user */
            $user= $em->getRepository("EntityBundle:User")->find($user->getId());


            /** @var Projet $projet */
            $projet= $em->getRepository("EntityBundle:Projet")->find($id);

            $message = $request->request->get('description');
            $comment = new Comment();
            $comment->setDate(new \DateTime());
            $comment->setUser($user);
            $comment->setProjet($projet);
            $comment->setDescription($message);
            $em->persist($comment);
            $em->flush();
            $em->detach($comment);

            $list= $em->getRepository("EntityBundle:Historic")->findAll();

            /** @var Historic $item */
            foreach($list as $item)
            {
                if($item->getProject()->getId()==$id)
                {
                    $body =  '<p> Code du projet : '.$projet->getCode().
                        '<br/> Suggestion : '.$message.'</p>';
                    $code = $this->sendMail($item->getParticipator()->getUser()->getEmail(), $this->getParameter('mailer_user'), $message, "COMMENT STC(SEMANTICA TECHNOLOGIES CORPORATION)");
                }
            }


        }
        return  $this->detailAction($id);
        // return $this->redirect($this->generateUrl('main_private_commit',["message"=>"test"]));
    }
}
