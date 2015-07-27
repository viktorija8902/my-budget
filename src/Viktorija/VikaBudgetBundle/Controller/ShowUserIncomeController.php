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
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Viktorija\VikaBudgetBundle\Entity\Income;
use Viktorija\VikaBudgetBundle\Entity\InDetail\IncomeInDetail;

class ShowUserIncomeController extends Controller{

    public function calculateIncomeAction(Request $request)
    {
        if (! $this->get('security.authorization_checker' ) ->isGranted('IS_AUTHENTICATED_FULLY' )) {
            throw $this->createAccessDeniedException();
        }
        /** @var $user BudgetUser */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        //calculates user his weekly income:
        $weeklySums = array();
        foreach($user->getIncome() as $income) {
            $groupIncomeId = $income->getId();
            /** @var EntityRepository $repository */
            $repository = $this->getDoctrine()
                ->getRepository('Viktorija\VikaBudgetBundle\Entity\InDetail\IncomeInDetail' );
            $weekOfYear = date("YW");
            $query = $repository->createQueryBuilder('p' )
                ->select('sum(p.receivedAmount)')
                ->where('p.weekOfYear = :weekOfYear AND p.income = :income' )
                ->setParameters(array(
                    'weekOfYear' => $weekOfYear,
                    'income' => $groupIncomeId,
                ))
                ->getQuery();
            $weeklySum = $query->getResult()[0][1];
            $weeklySums[$groupIncomeId] = $weeklySum;
        }

        //calculates user his monthly income:
        $monthlySums = array();
        foreach($user->getIncome() as $income) {
            $groupIncomeId = $income->getId();
            /** @var EntityRepository $repository */
            $repository = $this->getDoctrine()
                ->getRepository('Viktorija\VikaBudgetBundle\Entity\InDetail\IncomeInDetail' );
            $monthOfYear = date("Ym");
            $query2 = $repository->createQueryBuilder('p' )
                ->select('sum(p.receivedAmount)')
                ->where('p.monthOfYear = :monthOfYear AND p.income = :income' )
                ->setParameters(array(
                    'monthOfYear' => $monthOfYear,
                    'income' => $groupIncomeId,
                ))
                ->getQuery();
            $monthlySum = $query2->getResult()[0][1];
            $monthlySums[$groupIncomeId] = $monthlySum;
        }

        return $this->render('ViktorijaVikaBudgetBundle:Default:usersIncome.html.twig',
            array(
                "income" => $user->getIncome(),
                "firstname" => $user->getFirstname(),
                "weeklySums" => $weeklySums,
                "monthlySums" => $monthlySums
            ));
    }

    //flushes new price in database according it's category and renews weekly and monthly sums:
    /**
     * @param Request $request
     * @return Response
     */
    public function renewIncomeAction(Request $request)
    {

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        };

        //finds out information about request: price, expense type, user id, etc:
        /** @var $user BudgetUser */
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $request = $this->get('request');
        $receivedAmount = $request->request->get('ReceivedAmount');
        $incomeGroupId = $request->request->get('IdOfIncome');

        $em = $this->getDoctrine()->getManager();

        //checks security:
        $income = $em->getRepository('ViktorijaVikaBudgetBundle:Income')->find($incomeGroupId);
        if ($income->getBudgetUser()->getId() != $user->getId()) {
            return new Response("", 403);
        }

        $todayIs = date("Ymd");
        $weekOfYear = date("YW");
        $monthOfYear = date("Ym");

        //creates new expense and flushes all given data in database:
        $detailedIncome = new IncomeInDetail();
        $detailedIncome ->setReceivedAmount($receivedAmount);
        $detailedIncome ->setDateAdded($todayIs);
        $detailedIncome ->setWeekOfYear($weekOfYear);
        $detailedIncome ->setMonthOfYear($monthOfYear);
        $detailedIncome ->setIncome($income);

        $em->persist($detailedIncome );
        $em->flush();


        /** @var $user BudgetUser */
        $incomeGroupId = $request->request->get('IdOfIncome');
        /** @var EntityRepository $repository */
        $repository = $this->getDoctrine()->getRepository('Viktorija\VikaBudgetBundle\Entity\InDetail\IncomeInDetail');

        //sums weekly income after new income was added:
        $query1 = $repository->createQueryBuilder('p')
            ->select('sum(p.receivedAmount)')
            ->where('p.weekOfYear = :weekOfYear AND p.income = :income')
            ->setParameters(array(
                'weekOfYear' => $weekOfYear,
                'income' => $incomeGroupId,
            ))
            ->getQuery();
        $weeklySum = $query1->getResult()[0][1];

        //sums monthly income after new income was added:
        $query2 = $repository->createQueryBuilder('z')
            ->select('sum(z.receivedAmount)')
            ->where('z.monthOfYear = :monthOfYear AND z.income = :income')
            ->setParameters(array(
                'monthOfYear' => $monthOfYear,
                'income' => $incomeGroupId,
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