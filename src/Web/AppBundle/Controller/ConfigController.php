<?php
/**
 * Created by PhpStorm.
 * User: TERICCABREL
 * Date: 29/09/2016
 * Time: 23:11
 */

namespace Web\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Web\EntityBundle\Entity\User;

/**
 * @Route("/config")
 */
class ConfigController extends Controller
{
    public function encodePassword($object, $password, $salt)
    {
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($object);
        $password = $encoder->encodePassword($password, $salt);

        return $password;
    }


    /**
     * @Route("/first", name="main_config")
     */
    public function indexAction()
    {



        $user = new User();
        $password = $this->encodePassword(new User(), "sadmin", $user->getSalt());
        $user->setEmail('sadmin@semantica.com')->setUsername('000000000')->setCountry('United Kingdom');
        $user->setFirstname('Super Admin');
        $user->setPassword($password)->setRoles(['ROLE_SUPER_ADMIN'])->setEnabled(true);
        $user->setCity('Douala');
        $user->setCountry('Cameroun');
        $user->setPleasantries("Pr");


        $em = $this->getDoctrine()->getManager();

        $exist = $em->getRepository('EntityBundle:User')->findOneByemail($user->getEmail());
        if($exist==null)
        {
            $em->persist($user);
        }


        $em->flush();
        $em->detach($user);



        $user = new User();
        $password = $this->encodePassword(new User(), "sadmin", $user->getSalt());
        $user->setEmail('jtpascal@semantica.com')->setUsername('10000000')->setCountry('United Kingdom');
        $user->setFirstname('Pascal Tene');
        $user->setPassword($password)->setRoles(['ROLE_ADMIN'])->setEnabled(true);
        $user->setCity('Douala');
        $user->setCountry('Cameroun');
        $user->setPleasantries("Pr");


        $em = $this->getDoctrine()->getManager();

        $exist = $em->getRepository('EntityBundle:User')->findOneByemail($user->getEmail());
        if($exist==null)
        {
            $em->persist($user);
        }


        $em->flush();
        $em->detach($user);


        $user = new User();
        $password = $this->encodePassword(new User(), "sadmin", $user->getSalt());
        $user->setEmail('stratege@semantica.com')->setUsername('20000000')->setCountry('United Kingdom');
        $user->setFirstname('Ryan takam');
        $user->setPassword($password)->setRoles(['ROLE_STAFF'])->setEnabled(true);
        $user->setCity('Douala');
        $user->setCountry('Cameroun');
        $user->setPleasantries("Pr");


        $em = $this->getDoctrine()->getManager();

        $exist = $em->getRepository('EntityBundle:User')->findOneByemail($user->getEmail());
        if($exist==null)
        {
            $em->persist($user);
        }


        $em->flush();
        $em->detach($user);



        $user = new User();
        $password = $this->encodePassword(new User(), "sadmin", $user->getSalt());
        $user->setEmail('eric@semantica.com')->setUsername('30000000')->setCountry('United Kingdom');
        $user->setFirstname('Eric cabrel');
        $user->setPassword($password)->setRoles(['ROLE_USER'])->setEnabled(true);
        $user->setCity('Douala');
        $user->setCountry('Cameroun');
        $user->setPleasantries("Pr");


        $em = $this->getDoctrine()->getManager();

        $exist = $em->getRepository('EntityBundle:User')->findOneByemail($user->getEmail());
        if($exist==null)
        {
            $em->persist($user);
        }


        $em->flush();
        $em->detach($user);

        return $this->redirect($this->generateUrl('main_homepage'));
    }
}