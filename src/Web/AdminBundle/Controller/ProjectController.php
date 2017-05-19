<?php

namespace Web\AdminBundle\Controller;

use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Web\EntityBundle\Entity\Files;
use Web\EntityBundle\Entity\Historic;
use Web\EntityBundle\Entity\Participator;
use Web\EntityBundle\Entity\Projet;
use Web\EntityBundle\Entity\User;
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
     * @Route("/view/{id}", name="admin_projet_view", requirements={"id": "\d+"})
     */
    public function viewProjetAction(Request $request, $id)
    {
        $datas = [];
        $em = $this->getDoctrine()->getManager();

        /** @var Projet $project */
        $project = $em->getRepository("EntityBundle:Projet")->find($id);

        if(!is_object($project)){
            throw new NotFoundHttpException();
        }

        $participants = $em->getRepository('EntityBundle:Historic')->findBy(['project' => $id]);
        $users = $em->getRepository('EntityBundle:User')->findStaff();

        $users = $this->exludeUser($users, $participants);

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
            } else {

            }

            return $this->redirect($this->generateUrl('admin_projet_view', ['id' => $id]));
        }

        $datas = ['project' => $project, 'participants' => $participants, 'users' => $users, 'id' => $id];

        return $this->render('AdminBundle:Project:view.html.twig', $datas);
    }

    /**
     * @Route("/{id}/participants/{pid}", name="admin_projet_get_participant", options={"expose"=true}, requirements={"id": "\d+", "pid": "\d+"})
     */
    public function getParticipantAction($id, $pid)
    {
        $em = $this->getDoctrine()->getManager();

        $participant = $em->getRepository('EntityBundle:Historic')->find($pid);

        $serializer = SerializerBuilder::create()->build();

        $jsonContent = $serializer->serialize($participant, 'json');

        return new Response($jsonContent);
    }
}
