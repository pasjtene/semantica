<?php

namespace Web\MainBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Validator\Constraints\DateTime;
use Web\EntityBundle\Entity\Comment;
use Web\EntityBundle\Entity\CommitHistoric;
use Web\EntityBundle\Entity\FileProjet;
use Web\EntityBundle\Entity\Files;
use Web\EntityBundle\Entity\Historic;
use Web\EntityBundle\Entity\Projet;
use Web\EntityBundle\Entity\Task;
use Web\EntityBundle\Entity\User;
use Web\EntityBundle\Form\UserType;

/**
 * @Route("/private")
 */
class PrivateController extends Controller
{
    /**
     * @Route("/", name="main_private")
     */
    public function indexAction(Request $request)
    {
        $code="";
        /** @var User $user */
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $all= $em->getRepository("EntityBundle:Projet")->findAll();

        if($all !=null)
        {
            /** @var Projet $item */
            foreach($all as $item)
           {
               if($item->getVisitor()!=null && ($item->getVisitor()->getEmail()==$user->getEmail() || $item->getVisitor()->getPhone()== $user->getUsername()))
               {
                   $item->setUser($user);
                   $em->flush();
                   $em->detach($item);
               }
           }
        }

        if($request->isMethod("POST"))
        {
            $val = $request->request;
            $code = $val->get('code');
            if($code!="")
            {
                $list = $em->getRepository("EntityBundle:Projet")->findBy(['user'=>$user,'status'=>$code],['id'=>'DESC','date'=>'DESC']);
            }
            else{
                $list = $em->getRepository("EntityBundle:Projet")->findBy(['user'=>$user],['id'=>'DESC','date'=>'DESC']);
            }
        }
        else
        {
            $list = $em->getRepository("EntityBundle:Projet")->findBy(['user'=>$user],['id'=>'DESC','date'=>'DESC']);
        }

        $array['list'] = $list;
        $array['tabsindex'] = 1;
        $array['code'] = $code;

        return $this->render('MainBundle:Private:index.html.twig',$array);
    }


    /**
     * @Route("/commit", name="main_private_commit")
     */
    public function commitAction(Request $request)
    {
        $code="";
        /** @var User $user */
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $all= $em->getRepository("EntityBundle:Projet")->findAll();

        if($all !=null)
        {
            /** @var Projet $item */
            foreach($all as $item)
            {
                if($item->getVisitor()!=null && ($item->getVisitor()->getEmail()==$user->getEmail() || $item->getVisitor()->getPhone()== $user->getUsername()))
                {
                    $item->setUser($user);
                    $em->flush();
                    $em->detach($item);
                }
            }
        }

        $items = $em->getRepository("EntityBundle:Projet")->findBy(['user'=>$user],['id'=>'DESC','date'=>'DESC']);

        if($request->isMethod("POST"))
        {
            $val = $request->request;
            $code = $val->get('code');
            if($code!="")
            {
                /** @var Projet $projet */
                $projet =  $em->getRepository("EntityBundle:Projet")->findOneBycode($code);
                $list = $em->getRepository("EntityBundle:CommitHistoric")->findBy(['project'=>$projet],['id'=>'DESC']);
            }
            else{
                $list = $em->getRepository("EntityBundle:CommitHistoric")->findBy([],['id'=>'DESC']);
            }
        }
        else
        {
            $list = $em->getRepository("EntityBundle:CommitHistoric")->findBy([],['id'=>'DESC']);
        }

        $listhelp = $list;
        $list =null;
        /** @var CommitHistoric $item */
        foreach($listhelp as $item)
        {
            if($item->getProject()->getUser()->getId()==$user->getId())
            {
                $list[] =$item;
            }
        }
        $array['list'] = $list;
        $array['items'] = $items;
        $array['tabsindex'] = 3;
        $array['code'] = $code;
        return $this->render('MainBundle:Private:commit.html.twig',$array);
    }

    /**
     * @Route("/commit/send/{id}", name="main_private_commit_send", requirements={"id": "\d+"})
     */
    public function send_commitAction(Request $request,$id)
    {
        $code="";
        /** @var User $user */
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $all= $em->getRepository("EntityBundle:Projet")->findAll();

        if($request->isMethod("POST"))
        {
            $val = $request->request;
            $message =$val->get('message');
            $taskid =$val->get('task');
            $commit =$val->get('commit');

            /** @var User $user */
            $user= $em->getRepository("EntityBundle:User")->find($user->getId());

            /** @var Projet $project */
            $project= $em->getRepository("EntityBundle:Projet")->find($id);

            /** @var Task $task */
            $task= $em->getRepository("EntityBundle:Task")->find($taskid);

            $comment = new Comment();
            $comment->setDate(new \DateTime())->setDescription($message);
            $comment->setUser($user)->setProject($project)->setTask($task);

            $em->persist($comment);
            $em->flush();
            $em->detach($comment);

            $list= $em->getRepository("EntityBundle:Historic")->findAll();

            /** @var Historic $item */
            foreach($list as $item)
            {
                if($item->getProject()->getId()==$id)
                {
                    $body =  '<p> Code du projet : '.$project->getCode().
                        '<br/> Commit : '.$commit.
                        '<br/> Suggestion : '.$message.'</p>';
                    $code = $this->sendMail($item->getParticipator()->getUser()->getEmail(), $this->getParameter('mailer_user'), $message, "COMMENT STC(SEMANTICA TECHNOLOGIES CORPORATION)");
                }
            }


        }
        return $this->redirect($this->generateUrl('main_private_commit',["message"=>"test"]));
    }

    /**
     * @Route("/comment", name="main_private_comment")
     */
    public function commentAction(Request $request)
    {
        $code="";
        /** @var User $user */
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $all= $em->getRepository("EntityBundle:Projet")->findAll();

        if($all !=null)
        {
            /** @var Projet $item */
            foreach($all as $item)
            {
                if($item->getVisitor()!=null && ($item->getVisitor()->getEmail()==$user->getEmail() || $item->getVisitor()->getPhone()== $user->getUsername()))
                {
                    $item->setUser($user);
                    $em->flush();
                    $em->detach($item);
                }
            }
        }

        $items = $em->getRepository("EntityBundle:Projet")->findBy(['user'=>$user],['id'=>'DESC','date'=>'DESC']);

        if($request->isMethod("POST"))
        {
            $val = $request->request;
            $code = $val->get('code');
            if($code!="")
            {
                /** @var Projet $projet */
                $projet =  $em->getRepository("EntityBundle:Projet")->findOneBycode($code);
                $list = $em->getRepository("EntityBundle:Comment")->findBy(['project'=>$projet],['id'=>'DESC','date'=>'DESC']);
            }
            else{
                $list = $em->getRepository("EntityBundle:Comment")->findBy([],['id'=>'DESC','date'=>'DESC']);
            }
        }
        else
        {
            $list = $em->getRepository("EntityBundle:Comment")->findBy([],['id'=>'DESC','date'=>'DESC']);
        }

        $listhelp = $list;
        $list =null;
        /** @var Comment $item */
        foreach($listhelp as $item)
        {
            if($item->getProject()->getUser()->getId()==$user->getId())
            {
                $reply = $em->getRepository("EntityBundle:Reply")->findBy([],['id'=>'DESC','date'=>'DESC']);
                $list[] =['comment'=>$item, 'reply'=>$reply];

            }
        }
        $array['list'] = $list;
        $array['items'] = $items;
        $array['tabsindex'] = 4;
        $array['code'] = $code;

        return $this->render('MainBundle:Private:comment.html.twig',$array);
    }

    /**
     * @Route("/profile", name="main_private_profile")
     */
    public function profileAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();


        $em = $this->getDoctrine()->getManager();

        $objet = $em->getRepository("EntityBundle:User")->find($user->getId());

        /** @var Form $form */
        $form = $this->get("form.factory")->create(UserType::class,$objet);

        if($request->isMethod("POST"))
        {

            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $objet->setEnabled(true);
            $objet->setPassword($user->getPassword());
            $objet->setRoles(['ROLE_USER']);

            /** @var Validator $validator */
            $validator = $this->get('validator');
            $error = $validator->validate($objet);
            if(count($error) == 0)
            {
                $objet->setPassword($request->request->get('password'));
                $em->persist($objet);
                $em->flush();
                $em->detach($objet);
                $this->authenticateUser($objet);
            }
            else{
                $array['error'] = $error;
                //var_dump($error);
            }
        }

        $array['form'] = $form->createView();
        $array['objet'] = $objet;
        $array['tabsindex'] = 2;

        return $this->render('MainBundle:Private:profile.html.twig',$array);
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
     * @Route("/project/delete/{id}", name="main_projet_delete", requirements={"id": "\d+"})
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

        return $this->redirect($this->generateUrl('main_private'));
    }

    

    /**
     * @Route("/users", name="main_private_users")
     */
    public function usersAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository("EntityBundle:User")->findAll();

        $array = ['items' => $items, 'tabsindex' => 5];

        return $this->render('MainBundle:Private:users.html.twig', $array);
    }

    /**
     * @Route("/project/detail/{id}", name="main_projet_detail", requirements={"id": "\d+"})
     */
    public function detailAction($id)
    {

        $array['id'] =$id;
        return $this->render('MainBundle:Private:detail.html.twig',$array);
    }


    /**
     * @Route("/project/information/{id}", name="main_projet_information", requirements={"id": "\d+"})
     */
    public function project_informationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Projet $items */
        $items = $em->getRepository("EntityBundle:Projet")->find($id);
        $array['items'] =$items;
        $array['id'] =$id;
        return $this->render('MainBundle:Tabs:information.html.twig', $array);
    }


    /**
     * @Route("/project/participator/{id}", name="main_projet_participator", requirements={"id": "\d+"})
     */
    public function participatorAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository("EntityBundle:Historic")->findByproject($id);
        $array['items'] =$items;
        $array['id'] =$id;
        return $this->render('MainBundle:Tabs:participator.html.twig', $array);
    }


    /**
     * @Route("/project/planning/{id}", name="main_projet_planning", requirements={"id": "\d+"})
     */
    public function project_planningAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository("EntityBundle:Planning")->findByproject($id);
        $array['items'] =$items;
        $array['id'] =$id;
        return $this->render('MainBundle:Tabs:planning.html.twig', $array);
    }


    /**
     * @Route("/project/commit/{id}", name="main_projet_commit", requirements={"id": "\d+"})
     */
    public function project_commitAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository("EntityBundle:CommitHistoric")->findByproject($id);
        $array['items'] =$items;
        $array['id'] =$id;
        return $this->render('MainBundle:Tabs:commit.html.twig', $array);
    }

    /**
     * @Route("/project/task/{id}", name="main_projet_task", requirements={"id": "\d+"})
     */
    public function project_taskAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository("EntityBundle:Task")->findByplanning($id);
        $array['items'] =$items;
        $array['id'] =$id;
        return $this->render('MainBundle:Private:task.html.twig', $array);
    }

}
