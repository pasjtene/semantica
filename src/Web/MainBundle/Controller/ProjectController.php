<?php

namespace Web\MainBundle\Controller;

use Symfony\Bridge\Doctrine\Tests\Fixtures\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Tests\Util\Validator;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Web\EntityBundle\Entity\Files;
use Web\EntityBundle\Entity\Projet;
use Web\EntityBundle\Entity\Visitor;
use Web\EntityBundle\Form\ProjetType;

/**
 * @Route("/project")
 */
class ProjectController extends Controller
{
    /**
     * @Route("/", name="main_newproject")
     */
    public function indexAction(Request $request)
    {


        $objet = new Projet();
        /** @var Form $form */
        $form = $this->get("form.factory")->create(ProjetType::class,$objet);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            $em = $this->getDoctrine()->getManager();
            $objet->setDate(new \DateTime());
            $file = new Files();
            if ($objet->getFile() != null) {
                $file->file = $objet->getFile();
                $tab = explode('.',$objet->getFile()->getClientOriginalName());
                $objet->setFiles($objet->getFile()->getClientOriginalName());
                $objet->setExtfiles($tab[count($tab)-1]);
                $objet->setHashfiles(uniqid().'.'.$objet->getExtfiles());
                $file->add($file->initialpath."projet",  $objet->getHashfiles());
            }

            $objet->setCode(uniqid())->setState(true)->setStatus("En cours")->getUser()->setRoles(['ROLE_USER'])->setEnabled(true)->setPassword("test")->setPleasantries("M.");

            /** @var Validator $validator */
            $validator = $this->get('validator');
            $error = $validator->validate($objet);
            if(count($error) == 0)
            {
                //$ip = $request->getClientIp();
                $ip = $_SERVER['REMOTE_ADDR'];
                $email = $objet->getUser()->getEmail();
                $user =$em->getRepository('EntityBundle:User')->findOneByemail($objet->getUser()->getEmail());
               if($user !=null)
               {
                   $objet->setUser($user);
               }
                else{
                    $vistor = new Visitor();
                    $vistor->setPleasantries("M.");
                    $vistor->setCity($objet->getUser()->getCity());
                    $vistor->setCountry($objet->getUser()->getCountry());
                    $vistor->setPhone($objet->getUser()->getUsername());
                    $vistor->setEmail($objet->getUser()->getEmail());
                    $vistor->setFirstname($objet->getUser()->getFirstname());
                    $vistor->setIp($ip);
                    $visitorcurrent =$em->getRepository('EntityBundle:Visitor')->findOneByemail($objet->getUser()->getEmail());
                    if($visitorcurrent !=null)
                    {
                        $vistor = $visitorcurrent;
                    }
                    $objet->setUser(null);
                    $objet->setVisitor($vistor);
                }
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
                var_dump($error);
            }

        }
        /** @var \Web\EntityBundle\Entity\User $user */
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
       /* if($user!=null)
        {
            $em = $this->getDoctrine()->getManager();
            $user =$em->getRepository('EntityBundle:User')->find($user->getId());
            $objet->setUser($user);
        }*/
        $array['form'] = $form->createView();
        $array['objet'] = $objet;
        return $this->render('MainBundle:Project:index.html.twig',$array);
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
