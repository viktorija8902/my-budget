<?php
/**
 * Created by PhpStorm.
 * User: Viktorija
 * Date: 7/7/2015
 * Time: 10:43 AM
 */

namespace Viktorija\VikaBudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShowUserIncomeController extends Controller{

    public function usersIncomeAction()
    {
        if (! $this->get('security.authorization_checker' ) ->isGranted('IS_AUTHENTICATED_FULLY' )) {
            throw $this->createAccessDeniedException();
        }
        /** @var $user \Viktorija\VikaBudgetBundle\Entity\BudgetUser */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render('ViktorijaVikaBudgetBundle:Income:usersIncome.html.twig',
            array(
                "firstname"=>$user->getFirstname()
            ));
    }
}