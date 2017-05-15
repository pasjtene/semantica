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
        $user->setEmail('pasjtene@yahoo.co.uk')->setUsername('00447515975500')->setCountry('United Kingdom')->setFirstname('Tene')->setLastname('Pascal')->setPassword($password)->setRoles(['ROLE_SUPER_ADMIN'])->setEnabled(true)->setPleasantries('Male');

        $user2 = new User();
        $password = $this->encodePassword(new User(), "sadmin", $user2->getSalt());
        $user2->setEmail('Sdanicktakam@yahoo.fr')->setUsername('00237695868544')->setCountry('Cameroon')->setFirstname('Stratège')->setLastname('Takam')->setPassword($password)->setRoles(['ROLE_SUPER_ADMIN'])->setEnabled(true)->setPleasantries('Male');

        $user3 = new User();
        $password = $this->encodePassword(new User(), "sadmin", $user3->getSalt());
        $user3->setEmail('jouanirenatot@yahoo.com')->setUsername('00675914612')->setCountry('Cameroon')->setFirstname('Jonathan')->setLastname('Jouani')->setPassword($password)->setRoles(['ROLE_SUPER_ADMIN'])->setEnabled(true)->setPleasantries("Male");

        $user4 = new User();
        $password = $this->encodePassword(new User(), "sadmin", $user4->getSalt());
        $user4->setEmail('tericcabrel@yahoo.com')->setUsername('00237693642889')->setCountry('Cameroon')->setFirstname('Eric Cabrel')->setLastname('TIOGO')->setPassword($password)->setRoles(['ROLE_SUPER_ADMIN'])->setEnabled(true)->setPleasantries("Male");

        $em = $this->getDoctrine()->getManager();

        $exist = $em->getRepository('EntityBundle:User')->findOneByemail($user->getEmail());
        if($exist==null)
        {
            $em->persist($user);
        }

        $exist = $em->getRepository('EntityBundle:User')->findOneByemail($user2->getEmail());
        if($exist==null)
        {
            $em->persist($user2);
        }

        $exist = $em->getRepository('EntityBundle:User')->findOneByemail($user3->getEmail());
        if($exist==null)
        {
            $em->persist($user3);
        }

        $exist = $em->getRepository('EntityBundle:User')->findOneByemail($user4->getEmail());
        if($exist==null)
        {
            $em->persist($user4);
        }

        $em->flush();

        return $this->redirect($this->generateUrl('main_homepage'));
    }
}