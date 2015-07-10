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

    public function usersSpendingAction(Request $request)
    {

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        // $user = $this->getUser();
        // the above is a shortcut for this
        /** @var $user BudgetUser */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render('ViktorijaVikaBudgetBundle:Default:usersSpending.html.twig',
            array(
                "expenses" => $user->getExpenses(),
                "firstname" => $user->getFirstname()
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
        $detailedExpense = new ExpensesInDetail();
        $detailedExpense->setItemPrice($price);
        $detailedExpense->setDateAdded("1");

        $detailedExpense->setExpenses($expense);

//        exit(\Doctrine\Common\Util\Debug::dump($expenseGroupId));
        $em->persist($detailedExpense);
        $em->flush();
        return new Response("Ok");
//        $return=json_encode($return);//jscon encode the array
//        return new Response($return,200,array('Content-Type'=>'application/json'));//make sure it has the correct content type

    }


//        $user = $this->get('security.token_storage')->getToken()->getUser();
//        $expenses = $this->get('security.token_storage')->getToken()->getUser();


}