<?php
/**
 * Created by PhpStorm.
 * User: Viktorija
 * Date: 7/27/2015
 * Time: 8:38 AM
 */

namespace Viktorija\VikaBudgetBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Viktorija\VikaBudgetBundle\Entity\BudgetUser;

class ExpensesStatisticsController extends Controller{

    /**
     * @return mixed
     * @internal param Request $request
     */
    public function showExpensesChartAction(Request $request) {

        if (!$this->get('security.authorization_checker')->isGranted("IS_AUTHENTICATED_FULLY")) {
            throw $this->createAccessDeniedException();
        }

        /** @var $user BudgetUser */
        $user = $this->get('security.token_storage')->getToken()->getUser();



        return $this->render('ViktorijaVikaBudgetBundle:Default:statisticsExpenses.html.twig', array(
            "firstname"=>$user->getFirstname()
        ));
    }
}