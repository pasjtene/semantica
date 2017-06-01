<?php
/**
 * Created by PhpStorm.
 * User: TERICCABREL
 * Date: 26/09/2016
 * Time: 17:12
 */

namespace Web\AdminBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\UserBundle\Controller\SecurityController as BaseSecurityController;

class SecurityController extends BaseSecurityController
{
    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderLogin(array $data)
    {
        return $this->container->get('templating')->renderResponse('AdminBundle:Security:login.html.twig', $data);
    }
}