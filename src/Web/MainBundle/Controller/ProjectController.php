<?php

namespace Web\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Tests\Util\Validator;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Web\EntityBundle\Entity\Files;
use Web\EntityBundle\Entity\Projet;
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
            $objet->setTime(new \DateTime());
            $file = new Files();
            if ($objet->getFile() != null) {
                $file->file = $objet->getFile();
                $tab = explode('.',$objet->getFile()->getClientOriginalName());
                $objet->setFiles($objet->getFile()->getClientOriginalName());
                $objet->setExtfiles($tab[count($tab)-1]);
                $objet->setHashfiles(uniqid().'.'.$objet->getExtfiles());
                $file->add($file->initialpath."projet",  $objet->getHashfiles());
            }

            /** @var Validator $validator */
            $validator = $this->get('validator');
            $error = $validator->validate($objet);
            if(count($error) == 0)
            {
                $em->persist($objet);
                $em->flush();
                $objet = new Projet();
                /** @var Form $form */
                $form = $this->get("form.factory")->create(ProjetType::class,$objet);
                $array['message'] ="";
            }
            else{
                $array['error'] = $error;
                //var_dump($error);
            }

        }
        $array['form'] = $form->createView();
        $array['objet'] = $objet;
        return $this->render('MainBundle:Project:index.html.twig',$array);
    }

}
