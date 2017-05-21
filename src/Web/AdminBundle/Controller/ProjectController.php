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
            $files->delete('',$project->path());
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
     * @Route("/view/{id}", name="admin_projet_edit", requirements={"id": "\d+"})
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
                }

                $em->persist($historic);
                $em->flush();
            }
            else
            {

            }
        }

        return $this->redirect($this->generateUrl('admin_projet_detail', ['id' => $id]));
    }

    /**
     * @Route("participators/{id}", name="admin_projet_participator", requirements={"id": "\d+"})
     */
    public function getParticipatorAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $participant = $em->getRepository('EntityBundle:Historic')->find($id);

        $serializer = SerializerBuilder::create()->build();

        $jsonContent = $serializer->serialize($participant, 'json');

        return new Response($jsonContent);
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

        $users = $em->getRepository('EntityBundle:User')->findStaff();
        $users = $this->exludeUser($users, $items);

        $array['items'] =$items;
        $array['users'] =$users;
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
                'enddate' => new \DateTime($request->request->get("end-date"))
            ];

            /** @var Projet $project */
            $project = $em->getRepository("EntityBundle:Projet")->find($id);

            if(!is_object($project)){
                throw new NotFoundHttpException();
            }

            $planning = new Planning();
            $planning->setStartdate($params['startdate'])->setEnddate($params['enddate'])->setProject($project);

            $em->persist($planning);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_projet_detail', ['id' => $id]));
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

        return $this->redirect($this->generateUrl('admin_projet_detail', ['id' => $id]));
    }
}
