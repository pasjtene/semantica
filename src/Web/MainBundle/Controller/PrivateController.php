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
use Web\EntityBundle\Entity\Contact;
use Web\EntityBundle\Entity\Customer;
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
        $list = $em->getRepository("EntityBundle:Projet")->findBy(['user'=>$user],['id'=>'DESC','date'=>'DESC']);
        $array['list'] = $list;
        $array['index'] = 1;
        return $this->render('MainBundle:Private:index.html.twig',$array);
    }
    /**
     * @Route("/commit", name="main_private_commit")
     */
    public function commitAction(Request $request)
    {
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
        $list = $em->getRepository("EntityBundle:Projet")->findBy(['user'=>$user],['id'=>'DESC','date'=>'DESC']);
        $array['list'] = $list;
        $array['index'] =3;
        return $this->render('MainBundle:Private:commit.html.twig',$array);
    }
    /**
     * @Route("/comment", name="main_private_comment")
     */
    public function commentAction(Request $request)
    {
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
        $list = $em->getRepository("EntityBundle:Projet")->findBy(['user'=>$user],['id'=>'DESC','date'=>'DESC']);
        $array['list'] = $list;
        $array['index'] = 4;
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
        $array['index'] = 2;
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
}