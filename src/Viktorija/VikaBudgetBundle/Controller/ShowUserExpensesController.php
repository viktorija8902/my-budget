<?php
/**
 * Created by PhpStorm.
 * User: Viktorija
 * Date: 6/23/2015
 * Time: 9:23 AM
 */

namespace Viktorija\VikaBudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
    public function usersSpendingAction(Request $request)
    {

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        // $user = $this->getUser();
        // the above is a shortcut for this
        /** @var $user BudgetUser */
        $user = $this->get('security.token_storage')->getToken()->getUser();
//        $todayIs = date("Ymd");

        //gets Id of expense that was entered in expense group, f.e. 103:
//        $request = $this->get('request');
//        $price=$request->request->get('PriceOfItem');
//        $groupExpenseId=$request->request->get('IdOfExpense');

        // using the the id of expense group, finds the Id of expense group in Expenses entity
        //and gets all expenses of that group
//        $em = $this->getDoctrine()->getManager();
//        $expense = $em->getRepository('ViktorijaVikaBudgetBundle:Expenses')->find($groupExpenseId);
//        $detailedExpenses = $expense->getTotalThisWeek();


           // exit(\Doctrine\Common\Util\Debug::dump($detailedExpenses));
        return $this->render('ViktorijaVikaBudgetBundle:Default:usersSpending.html.twig',
            array(
                "expenses" => $user->getExpenses(),
                "firstname" => $user->getFirstname(),
//                "current_date" => $todayIs
            ));
        //exit(\Doctrine\Common\Util\Debug::dump($expense));
    }

    public function detailedExpensesAction(Request $request)
    {

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        };

        /** @var $user BudgetUser */
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $request = $this->get('request');
        $price = $request->request->get('PriceOfItem');
        $expenseGroupId = $request->request->get('IdOfExpense');


        $em = $this->getDoctrine()->getManager();

        /** @var Expenses $expense */
        $expense = $em->getRepository('ViktorijaVikaBudgetBundle:Expenses')->find($expenseGroupId);
        if ($expense->getBudgetUser()->getId() != $user->getId()) {
            return new Response("", 403);
        }
        $todayIs = date("Ymd");
        $detailedExpense = new ExpensesInDetail();
        $detailedExpense->setItemPrice($price);
        $detailedExpense->setDateAdded($todayIs);
        $detailedExpense->setExpenses($expense);

//        exit(\Doctrine\Common\Util\Debug::dump($expenseGroupId));
        $em->persist($detailedExpense);
        $em->flush();
        return new Response("Ok");
    }


//        $user = $this->get('security.token_storage')->getToken()->getUser();
//        $expenses = $this->get('security.token_storage')->getToken()->getUser();


}