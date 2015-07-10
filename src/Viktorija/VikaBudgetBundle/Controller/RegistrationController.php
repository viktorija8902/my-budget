<?php
/**
 * Created by PhpStorm.
 * User: Viktorija
 * Date: 6/16/2015
 * Time: 12:06 PM
 */


namespace Viktorija\VikaBudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Viktorija\VikaBudgetBundle\Entity\BudgetUser;
use Viktorija\VikaBudgetBundle\Entity\Expenses;
use Symfony\Component\HttpFoundation\Request;
use Viktorija\VikaBudgetBundle\Form\Type\RegistrationForm;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registrationAction(Request $request)
    {
        //useris tuščias
        $user = new BudgetUser();
        $form = $this->createForm(new RegistrationForm(), $user);

        //duomenys atsiranda tik čia:
        $form->handleRequest($request);

        //ar forma validi:
        if ($form->isValid()) {
            //perform some action, such as saving the task to the database

            //slaptažodžio užkodavimas
            $plainPassword = $user->getPassword();
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);
            //slaptažodžio užkodavimo pabaiga

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);

            $dinner = new Expenses();
            $dinner -> setExpenseType('DINNER USD');
            $dinner -> setPicture('dinner.jpg');
            $dinner -> setTotalThisWeek(0);
            $dinner -> setTotalThisMonth(0);
            $dinner -> setWeekday(2015/07/07);
            $dinner -> setBudgetUser($user);

            $em->persist($dinner);

            $snacks = new Expenses();
            $snacks -> setExpenseType('SNACKS USD');
            $snacks -> setPicture('snacks.jpg');
            $snacks -> setTotalThisWeek(0);
            $snacks -> setTotalThisMonth(0);
            $snacks -> setWeekday(2015/07/07);
            $snacks -> setBudgetUser($user);

            $em->persist($snacks);

            $fruits_and_vegetables = new Expenses();
            $fruits_and_vegetables -> setExpenseType('FRUITS AND VEGETABLES USD');
            $fruits_and_vegetables -> setPicture('fruits.jpg');
            $fruits_and_vegetables -> setTotalThisWeek(0);
            $fruits_and_vegetables -> setTotalThisMonth(0);
            $fruits_and_vegetables -> setWeekday(2015/07/07);
            $fruits_and_vegetables -> setBudgetUser($user);

            $em->persist( $fruits_and_vegetables);

            $toys = new Expenses();
            $toys -> setExpenseType('TOYS USD');
            $toys -> setPicture('toys.jpg');
            $toys -> setTotalThisWeek(0);
            $toys -> setTotalThisMonth(0);
            $toys -> setWeekday(2015/07/07);
            $toys -> setBudgetUser($user);

            $em->persist($toys);

            $school_stuff = new Expenses();
            $school_stuff -> setExpenseType('SCHOOL STUFF USD');
            $school_stuff -> setPicture('pens.jpg');
            $school_stuff -> setTotalThisWeek(0);
            $school_stuff -> setTotalThisMonth(0);
            $school_stuff -> setWeekday(2015/07/07);
            $school_stuff -> setBudgetUser($user);

            $em->persist($school_stuff);

            $gifts = new Expenses();
            $gifts -> setExpenseType('GIFTS USD');
            $gifts -> setPicture('gifts.jpg');
            $gifts -> setTotalThisWeek(0);
            $gifts -> setTotalThisMonth(0);
            $gifts -> setWeekday(2015/07/07);
            $gifts -> setBudgetUser($user);

            $em->persist($gifts);

            $fun = new Expenses();
            $fun -> setExpenseType('CINEMA, PARKS, TRIPS USD');
            $fun -> setPicture('entertainment.jpg');
            $fun -> setTotalThisWeek(0);
            $fun -> setTotalThisMonth(0);
            $fun -> setWeekday(2015/07/07);
            $fun -> setBudgetUser($user);

            $em->persist($fun);

            $transport = new Expenses();
            $transport -> setExpenseType('TRANSPORT USD');
            $transport -> setPicture('transport.png');
            $transport -> setTotalThisWeek(0);
            $transport -> setTotalThisMonth(0);
            $transport -> setWeekday(2015/07/07);
            $transport -> setBudgetUser($user);

            $em->persist($transport);

            $em->flush();

            return $this->redirectToRoute('_registration_completed');
        }

        //formos vaizdo sukūrimas:
        return $this->render('ViktorijaVikaBudgetBundle:Default:registration.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function registrationCompletedAction(Request $request)
    {
        return $this->render('ViktorijaVikaBudgetBundle:Default:registrationCompleted.html.twig');
    }

//    updates data. pay attention to routing.yml file
//    public function updateAction($id)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $user = $em->getRepository('ViktorijaVikaBudgetBundle:BudgetUser')->find($id);
//
//        $user->setAge('10');
//        $em->flush();
//        return $this->redirectToRoute('login_route');
//    }

//    public function createExpenseAction()
//    {
//        $user = new BudgetUser();
//        $user->setFirstname("Aistija");
//        $user->setAge("10");
//        $user->setEmail("aiste@gmail.com");
//        $user->setUsername('aistija');
//        $user->setPassword("aiste");
//
////        $newExpense = new Expenses();
////        $newExpense->setExpenses("pancakes");
////        $newExpense->setPrice(10);
//
//        // relate this product to the category
//        $newExpense->setBudgetUser($user);
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($user);
//        $em->persist($newExpense);
//        $em->flush();
//
//        return new Response(
//            'Created expense id: '.$newExpense->getId()
//            .' and user id: '.$user->getId()
//        );
//    }

//    public function showExpenseAction($id)
//    {
//        $user = $this->getDoctrine()
//            ->getRepository('Viktorija\VikaBudgetBundle\Entity\BudgetUser')
//            ->find($id);
//
//        $expen = $user->getExpenses()->getExpenseType();
//        exit(\Doctrine\Common\Util\Debug::dump($expen));
//        //return $this->render('ViktorijaVikaBudgetBundle:Default:usersSpending.html.twig');
////        return new Response
////        ("expenses the user has are".$expense
////        );
//    }
//
//    public function showPeopleAction($id)
//    {
//        $expense = $this->getDoctrine()
//            ->getRepository('ViktorijaVikaBudgetBundle:Expenses')
//            ->find($id);
//
//        $user = $expense->getBudgetUser()->getFirstname();
//        exit(\Doctrine\Common\Util\Debug::dump($user));
//
////        return new Response
////        ("expenses the user has are".$expense
////        );
//    }

}