<?php

namespace Web\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Web\EntityBundle\Entity\Task;
use Web\EntityBundle\Entity\User;

/**
 * @Route("/inc")
 */
class IncController extends Controller
{
    /**
     * @Route("/project/task/{task_id}", name="main_inc_commit", requirements={"task_id": "\d+"})
     */
    public function commitAction($task_id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Task $task */
        $task =$em->getRepository("EntityBundle:Task")->find($task_id);
        $project_id =$task->getPlanning()->getProject()->getId();
        $array['project_id'] = $project_id;
        $array['task_id'] = $task_id;
        $array['task'] = $task;

        /** @var User $user */
        $user = $this->getUser();

        $query =$em->getRepository("EntityBundle:CommitHistoric");
        $data = ['title'=>'', "status"=>"" ,  "project_id"=>$project_id, "task_id"=>$task_id, "user_id"=>$user->getId()];
        $items = $query->getByparam($data);
        $array['items'] =$items;
        return $this->render('MainBundle:Inc:block-commit.html.twig',$array);
    }

}
