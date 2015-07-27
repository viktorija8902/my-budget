<?php
/**
 * Created by PhpStorm.
 * User: Viktorija
 * Date: 7/27/2015
 * Time: 3:11 PM
 */

namespace Viktorija\VikaBudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Viktorija\VikaBudgetBundle\Entity\BudgetUser;

class SavingsController extends Controller {

    public function showSavingsAction() {

        if (!$this->get('security.authorization_checker')->isGranted("IS_AUTHENTICATED_FULLY")) {
            throw $this->createAccessDeniedException();
        }

        /** @var $user BudgetUser */
        $user = $this->get('security.token_storage')->getToken()->getUser();
        return $this->render('ViktorijaVikaBudgetBundle:Default:savings.html.twig', array(
            "firstname"=>$user->getFirstname()
        ));
    }
}