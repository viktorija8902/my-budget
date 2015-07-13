<?php
/**
 * Created by PhpStorm.
 * User: Viktorija
 * Date: 7/7/2015
 * Time: 10:43 AM
 */

namespace Viktorija\VikaBudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Viktorija\VikaBudgetBundle\Entity\BudgetUser;
use Viktorija\VikaBudgetBundle\Entity\Income;

class ShowUserIncomeController extends Controller{

    public function usersIncomeAction(Request $request)
    {
        if (! $this->get('security.authorization_checker' ) ->isGranted('IS_AUTHENTICATED_FULLY' )) {
            throw $this->createAccessDeniedException();
        }
        /** @var $user BudgetUser */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render('ViktorijaVikaBudgetBundle:Default:usersIncome.html.twig',
            array(
                "income" => $user->getIncome(),
                "firstname"=>$user->getFirstname()
            ));
    }
}