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
use Web\EntityBundle\Entity\Comment;
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
 * @Route("/comment")
 */
class CommentController extends Controller
{

    /**
     * @Route("/{projectid}/delete/{id}", name="admin_comment_delete", options={"expose"=true}, requirements={"id": "\d+", "projetid": "\d+"})
     */
    public function deleteAction($id,$projectid)
    {
       
		$em = $this->getDoctrine()->getManager();


        $em = $this->getDoctrine()->getManager();
        /** @var Comment $comment */
        $comment= $em->getRepository("EntityBundle:Comment")->find($id);
        if(is_object($comment)){
            $em->remove($comment);
            $em->flush();
        }

        $array = ['id'=>$projectid];

        $array = ['id'=>$projectid];
        return $this->redirect($this->generateUrl('admin_projet_detail',$array)."#comment");
    }

    /**
     * @Route("/add/{id}", name="admin_comment_add", requirements={"id": "\d+"})
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
