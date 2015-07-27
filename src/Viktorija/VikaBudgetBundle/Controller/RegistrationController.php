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
use Viktorija\VikaBudgetBundle\Entity\Income;
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

            $food = new Expenses();
            $food -> setExpenseType('HEALTHY FOOD USD');
            $food -> setPicture('dinner.jpg');
           // $food -> setWeekday(2015/07/07);
            $food -> setBudgetUser($user);

            $em->persist($food);

            $snacks = new Expenses();
            $snacks -> setExpenseType('SNACKS USD');
            $snacks -> setPicture('snacks.jpg');
            //$snacks -> setWeekday(2015/07/07);
            $snacks -> setBudgetUser($user);

            $em->persist($snacks);

            $rent = new Expenses();
            $rent -> setExpenseType('RENT USD');
            $rent -> setPicture('rent.jpg');
            //$rent -> setWeekday(2015/07/07);
            $rent -> setBudgetUser($user);

            $em->persist($rent);

            $outfit = new Expenses();
            $outfit -> setExpenseType('OUTFIT USD');
            $outfit -> setPicture('outfit.jpg');
            //$outfit -> setWeekday(2015/07/07);
            $outfit -> setBudgetUser($user);

            $em->persist( $outfit);

            $work = new Expenses();
            $work -> setExpenseType('WORK STUFF USD');
            $work -> setPicture('work.jpg');
            //$work -> setWeekday(2015/07/07);
            $work -> setBudgetUser($user);

            $em->persist($work);

            $sport = new Expenses();
            $sport -> setExpenseType('SPORT USD');
            $sport -> setPicture('sport.jpg');
            //$sport -> setWeekday(2015/07/07);
            $sport -> setBudgetUser($user);

            $em->persist($sport);

            $vacation = new Expenses();
            $vacation -> setExpenseType('VACATION USD');
            $vacation -> setPicture('vacation.jpg');
            //$fun -> setWeekday(2015/07/07);
            $vacation -> setBudgetUser($user);

            $em->persist($vacation);

            $transport = new Expenses();
            $transport -> setExpenseType('TRANSPORT USD');
            $transport -> setPicture('transport.jpg');
            //$transport -> setWeekday(2015/07/07);
            $transport -> setBudgetUser($user);

            $em->persist($transport);

            $job1 = new Income();
            $job1 -> setIncomeType('JOB1 USD');
            $job1 -> setPicture('job1.jpg');
            //$parents -> setWeekday(2015/07/07);
            $job1 -> setBudgetUser($user);

            $em->persist($job1);

            $job2 = new Income();
            $job2 -> setIncomeType('JOB2 USD');
            $job2 -> setPicture('job2.jpeg');
            //$grandparents -> setWeekday(2015/07/07);
            $job2 -> setBudgetUser($user);

            $em->persist($job2);

            $investment = new Income();
            $investment -> setIncomeType('INVESTMENT USD');
            $investment -> setPicture('investment.jpg');
            //$work -> setWeekday(2015/07/07);
            $investment -> setBudgetUser($user);

            $em->persist($investment);

            $business = new Income();
            $business -> setIncomeType('BUSINESS USD');
            $business -> setPicture('business.jpg');
            //$gift -> setWeekday(2015/07/07);
            $business -> setBudgetUser($user);

            $em->persist($business);

            $gifts = new Income();
            $gifts -> setIncomeType('GIFTS USD');
            $gifts -> setPicture('gifts.jpg');
            //$foundOnStreet -> setWeekday(2015/07/07);
            $gifts -> setBudgetUser($user);

            $em->persist($gifts);

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
}