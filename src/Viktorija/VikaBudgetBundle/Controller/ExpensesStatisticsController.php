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

//        $typeOfExpense = $user->getExpenses();
//        $groupExpenseId = $typeOfExpense->getId();
//        /** @var EntityRepository $repository */
//        $repository = $this->getDoctrine()
//            ->getRepository('Viktorija\VikaBudgetBundle\Entity\InDetail\ExpensesInDetail' );
//
//        $query = $repository->createQueryBuilder('p' )
//            ->select('sum(p.itemPrice)')
//            ->where('p.weekOfYear = :weekOfYear AND p.expenses = :expenses' )
//            ->setParameters(array(
//                'weekOfYear' => $weekOfYear,
//                'expenses' => $groupExpenseId,
//            ))
//            ->getQuery();
//        $weeklySum = $query->getResult()[0][1];
//        $weeklySums[$groupExpenseId] = $weeklySum;


        return $this->render('ViktorijaVikaBudgetBundle:Default:statisticsExpenses.html.twig', array(
            "firstname"=>$user->getFirstname()
        ));
    }
}