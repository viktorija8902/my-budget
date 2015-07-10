<?php
/**
 * Created by PhpStorm.
 * User: Viktorija
 * Date: 6/17/2015
 * Time: 10:57 AM
 */

namespace Viktorija\VikaBudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class SecurityController extends Controller {
    /**
     * @Route("/login", name="login_route")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        //$form = $this->createFormBuilder();

        return $this->render(
            'ViktorijaVikaBudgetBundle:Default:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
                //'form' => $form->createView()
            )
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }
}