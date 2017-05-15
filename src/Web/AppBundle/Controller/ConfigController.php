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
        $user->setEmail('sadmin@semantica.com')->setUsername('000000000')
        ->setFirstname('Sadmin')->setPassword($password)
        ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setEnabled(true)->setStatus('Active')->setCity("Douala")
            ->setCountry('Cameroun');


        $em = $this->getDoctrine()->getManager();



        $exist = $em->getRepository('EntityBundle:User')->findOneByemail($user->getEmail());
        if($exist==null)
        {
            $em->persist($user);
        }

        $em->flush();

        return $this->redirect($this->generateUrl('main_homepage'));
    }
}