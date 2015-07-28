<?php
/**
 * Created by PhpStorm.
 * User: Viktorija
 * Date: 6/23/2015
 * Time: 9:23 AM
 */

namespace Viktorija\VikaBudgetBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viktorija\VikaBudgetBundle\Entity\BudgetUser;
use Viktorija\VikaBudgetBundle\Entity\Expenses;
use Viktorija\VikaBudgetBundle\Entity\InDetail\ExpensesInDetail;

class ShowUserExpensesController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    //calculates user his weekly and monthly expenses:
    public function calculateExpensesAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        /** @var $user BudgetUser */
        $user = $this->get('security.token_storage')->getToken()->getUser();
        //calculates user his weekly expenses:
        $weeklySums = array();
        foreach($user->getExpenses() as $expense) {
            $groupExpenseId = $expense->getId();
            /** @var EntityRepository $repository */
            $repository = $this->getDoctrine()
                ->getRepository('Viktorija\VikaBudgetBundle\Entity\InDetail\ExpensesInDetail' );
            $weekOfYear = date("YW");
            $query = $repository->createQueryBuilder('p' )
                ->select('sum(p.itemPrice)')
                ->where('p.weekOfYear = :weekOfYear AND p.expenses = :expenses' )
                ->setParameters(array(
                    'weekOfYear' => $weekOfYear,
                    'expenses' => $groupExpenseId,
                ))
                ->getQuery();
            $weeklySum = $query->getResult()[0][1];
            $weeklySums[$groupExpenseId] = $weeklySum;
        }

        //calculates user his monthly expenses:
        $monthlySums = array();
        foreach($user->getExpenses() as $expense) {
            $groupExpenseId = $expense->getId();
            /** @var EntityRepository $repository */
            $repository = $this->getDoctrine()
                ->getRepository('Viktorija\VikaBudgetBundle\Entity\InDetail\ExpensesInDetail' );
            $monthOfYear = date("Ym");
            $query2 = $repository->createQueryBuilder('p' )
                ->select('sum(p.itemPrice)')
                ->where('p.monthOfYear = :monthOfYear AND p.expenses = :expenses' )
                ->setParameters(array(
                    'monthOfYear' => $monthOfYear,
                    'expenses' => $groupExpenseId,
                ))
                ->getQuery();
            $monthlySum = $query2->getResult()[0][1];
            $monthlySums[$groupExpenseId] = $monthlySum;
        }
//        $todayIs = date("Ymd");

        //gets Id of expense that was entered in expense group, f.e. 103:
//        $request = $this->get('request');
//        $price=$request->request->get('PriceOfItem');
//        $groupExpenseId=$request->request->get($IdOfExpense);

        //exit(\Doctrine\Common\Util\Debug::dump($monthlySums));


        return $this->render('ViktorijaVikaBudgetBundle:Default:usersSpending.html.twig',
            array(
                "expenses" => $user->getExpenses(),
                "firstname" => $user->getFirstname(),
                "weeklySums" => $weeklySums,
                "monthlySums" => $monthlySums
//                "current_date" => $todayIs
            ));
        //exit(\Doctrine\Common\Util\Debug::dump($expense));
    }

    //flushes new price in database according it's category and renews weekly and monthly sums:
    public function renewExpensesAction(Request $request)
    {

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        };

        //finds out information about request: price, expense type, user id, etc:
        /** @var $user BudgetUser */
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $request = $this->get('request');
        $price = $request->request->get('PriceOfItem');
        $expenseGroupId = $request->request->get('IdOfExpense');

        $em = $this->getDoctrine()->getManager();

        //checks security:
        /** @var Expenses $expense */
        $expense = $em->getRepository('ViktorijaVikaBudgetBundle:Expenses')->find($expenseGroupId);
        if ($expense->getBudgetUser()->getId() != $user->getId()) {
            return new Response("", 403);
        }

        $todayIs = date("Ymd");
        $weekOfYear = date("YW");
        $monthOfYear = date("Ym");

        //creates new expense and flushes all given data in database:
        $detailedExpense = new ExpensesInDetail();
        $detailedExpense->setItemPrice($price);
        $detailedExpense->setDateAdded($todayIs);
        $detailedExpense->setWeekOfYear($weekOfYear);
        $detailedExpense->setMonthOfYear($monthOfYear);
        $detailedExpense->setExpenses($expense);

        $em->persist($detailedExpense);
        $em->flush();


        /** @var $user BudgetUser */
        $expenseGroupId = $request->request->get('IdOfExpense');
        /** @var EntityRepository $repository */
        $repository = $this->getDoctrine()->getRepository('Viktorija\VikaBudgetBundle\Entity\InDetail\ExpensesInDetail');

        //sums weekly expenses after new expense was added:
        $query1 = $repository->createQueryBuilder('p')
            ->select('sum(p.itemPrice)')
            ->where('p.weekOfYear = :weekOfYear AND p.expenses = :expenses')
            ->setParameters(array(
                'weekOfYear' => $weekOfYear,
                'expenses' => $expenseGroupId,
            ))
            ->getQuery();
        $weeklySum = $query1->getResult()[0][1];

        //sums monthly expenses after new expense was added:
        $query2 = $repository->createQueryBuilder('z')
            ->select('sum(z.itemPrice)')
            ->where('z.monthOfYear = :monthOfYear AND z.expenses = :expenses')
            ->setParameters(array(
                'monthOfYear' => $monthOfYear,
                'expenses' => $expenseGroupId,
            ))
            ->getQuery();
        $monthlySum = $query2->getResult()[0][1];
        $response = new JsonResponse();
        $response->setData(array(
            'weeklySum' =>$weeklySum,
            'monthlySum'=>$monthlySum
        ));
        return $response;
    }
}