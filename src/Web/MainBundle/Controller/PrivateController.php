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
use Web\EntityBundle\Entity\Commit;
use Web\EntityBundle\Entity\CommitHistoric;
use Web\EntityBundle\Entity\FileProjet;
use Web\EntityBundle\Entity\Files;
use Web\EntityBundle\Entity\Historic;
use Web\EntityBundle\Entity\Task;
use Web\EntityBundle\Entity\Planning;
use Web\EntityBundle\Entity\Projet;
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
                $projet =  $em->getRepository("EntityBundle:Projet")->find($code);

                /** @var User $user */
                $user = $this->getUser();
                $em = $this->getDoctrine()->getManager();
                $query =$em->getRepository("EntityBundle:CommitHistoric");
                $data = ['title'=>'', "status"=>"" , "libelle"=>"", "project_id"=>$projet->getId(), "user_id"=>$user->getId(), "task_id"=>null];
                $list = $query->getByparamUserAndProject($data);


                //$list = $em->getRepository("EntityBundle:CommitHistoric")->findBy(['project'=>$projet],['id'=>'DESC']);
            }
            else{
                /** @var User $user */
                $user = $this->getUser();
                $em = $this->getDoctrine()->getManager();
                $query =$em->getRepository("EntityBundle:CommitHistoric");
                $data = ['title'=>'', "status"=>"" , "libelle"=>"", "project_id"=>null, "user_id"=>$user->getId(), "task_id"=>null];
                $list = $query->getByparamUser($data);
                //$list = $em->getRepository("EntityBundle:CommitHistoric")->findBy([],['id'=>'DESC']);
            }
        }
        else
        {
            /** @var User $user */
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            $query =$em->getRepository("EntityBundle:CommitHistoric");
            $data = ['title'=>'', "status"=>"" , "libelle"=>"", "project_id"=>null, "user_id"=>$user->getId(), "task_id"=>null];
            $list = $query->getByparamUser($data);

            //$list = $em->getRepository("EntityBundle:CommitHistoric")->findBy([],['id'=>'DESC']);
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
            $commit =$val->get('commit');

            /** @var User $user */
            $user= $em->getRepository("EntityBundle:User")->find($user->getId());

            /** @var Commit $commits */
            $commits= $em->getRepository("EntityBundle:Commit")->find($id);

            /** @var CommitHistoric $commitHis */
            $commitHis= $em->getRepository("EntityBundle:CommitHistoric")->findOneByCommit($id);


            /** @var Projet $projet */
            $projet= $commitHis->getTask()->getPlanning()->getProject();

            $comment = new Comment();
            $comment->setDate(new \DateTime())->setDescription($message);
            $comment->setUser($user)->setCommit($commits);

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
                $list = $em->getRepository("EntityBundle:Comment")->findBy(['projet'=>$projet],['id'=>'ASC','date'=>'DESC']);
            }
            else{
                $list = $em->getRepository("EntityBundle:Comment")->findBy([],['id'=>'ASC','date'=>'DESC']);
            }
        }
        else
        {
            $list = $em->getRepository("EntityBundle:Comment")->findBy([],['id'=>'ASC','date'=>'DESC']);
        }

        $listhelp = $list;
        $list =null;
        /** @var Projet $projet */
        foreach ($items as $projet)
        {
            if($projet->getUser()->getId()==$user->getId())
            {
                $collections = null;
                /** @var Comment $item */
                foreach($listhelp as $item)
                {
                    if($item->getProjet()->getId()==$projet->getId())
                    {
                        $collections[] =$item;

                    }
                }
                $list[] =['comments'=>$collections, 'project'=>$projet];
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
     * @Route("/project/comment/{id}", name="main_projet_comment", requirements={"id": "\d+"})
     */
    public function project_commentAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository("EntityBundle:Comment")->findByprojet($id);
        $array['items'] =$items;
        $array['id'] =$id;
        return $this->render('MainBundle:Tabs:comment.html.twig', $array);
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
        $collections = $em->getRepository("EntityBundle:Planning")->findByproject($id);
        $items=null;
        if($collections!=null)
        {
            /** @var Planning $item */
            foreach($collections as $item)
            {
                $tasks = $em->getRepository("EntityBundle:Task")->findByplanning($item->getId());
                $items[] =["planning"=>$item, "tasks"=>$tasks];
            }
        }
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
        /** @var User $user */
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $query =$em->getRepository("EntityBundle:CommitHistoric");
        $data = ['title'=>'', "status"=>"" , "libelle"=>"", "project_id"=>$id, "user_id"=>$user->getId(), "task_id"=>null];
        $items = $query->getByparamUserAndProject($data);

        $array['items'] =$items;
        $array['id'] =$id;
        return $this->render('MainBundle:Tabs:commit.html.twig', $array);
    }

    /**
     * @Route("/{id2}/project/task/{id}", name="main_projet_task", requirements={"id": "\d+","id2": "\d+"},defaults={"id2":0})
     */
    public function taskAction(Request $request,$id,$id2)
    {
        /** @var User $user */
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $query =$em->getRepository("EntityBundle:Task");
        $data = ['title'=>'', "status"=>"" , "libelle"=>"", "planning_id"=>$id, "user_id"=>$user->getId()];
        $items = $query->getByparam($data);
        $array['items'] =$items;
        $array['id'] =$id;
        $array['id2'] =$id2;
        return $this->render('MainBundle:Private:task.html.twig', $array);
    }


    /**
     * @Route("/project/send/{id}", name="main_private_project_send", requirements={"id": "\d+"})
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
                    $email =$item->getParticipator()->getUser()->getEmail();
                    $name = $item->getParticipator()->getUser()->getFirstname(). " ". $item->getParticipator()->getUser()->getLastname();
                    $body =  '<p> Code du projet : '.$projet->getCode().
                        '<br/> Suggestion : '.$message.'</p>';
                    //$code = $this->sendMail($item->getParticipator()->getUser()->getEmail(), $this->getParameter('mailer_user'), $message, "COMMENT STC(SEMANTICA TECHNOLOGIES CORPORATION)");
                    $routeview = 'MainBundle:Mail:subscribe.html.twig';
                    $param = ['email'=>'http://'.$email,'name'=>$name, 'semail'=>$email, "project"=>$projet->getTitle(), "message"=>$message];
                    $code = $this->sentMail($email, $this->getParameter('mailer_user'), $routeview,$param, "COMMENT TO STC(SEMANTICA TECHNOLOGIES CORPORATION)");

                }
            }


        }
        return  $this->detailAction($id);
       // return $this->redirect($this->generateUrl('main_private_commit',["message"=>"test"]));
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
