<?php
/**
 * Created by PhpStorm.
 * User: Viktorija
 * Date: 7/7/2015
 * Time: 5:18 PM
 */

namespace Viktorija\VikaBudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class SummingController extends Controller
{
    /**
     * Return a ajax response
     */
    public function sumAction(Request $request)
    {

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $request = $this->get('request');
        $price=$request->request->get('PriceOfItem');
        $expenseId=$request->request->get('IdOfExpense');



        if($price!=0){//if the user has written his name
//            $this->forward('ViktorijaVikaBudgetBundle:ShowUserExpenses:detailedExpenses', array(
//                'price'  => $price,
//                'expenseGroupId' => $expenseId,
//            ));

            $em = $this->getDoctrine()->getManager();
            $expense = $em->getRepository('ViktorijaVikaBudgetBundle:Expenses')->find($expenseId);
            $expensesInDatabase = $expense->getTotalThisWeek();
            $expensesInDatabase  = $expensesInDatabase + $price;


//            exit(\Doctrine\Common\Util\Debug::dump($expensesInDatabase));

            $expense->setTotalThisWeek($expensesInDatabase);
            $em->flush();
            $return = array($expensesInDatabase);
//            $return=array("responseCode"=>200,  "new price"=>$price, "expenseId"=>$expenseId,"expenses in database"=>$expensesInDatabase);
        }
        else {
            $return = array("responseCode" => 400, "error" => "Please enter the price");
        }
        $return=json_encode($return);//jscon encode the array
        return new Response($return,200,array('Content-Type'=>'application/json'));//make sure it has the correct content type

    }

}


