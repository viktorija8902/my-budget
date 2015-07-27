<?php

namespace Viktorija\VikaBudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
//    /**
//     * @Route("/admin")
//     */
//    public function adminAction()
//    {
//        return new Response('Admin page!' );
//    }

    /**
     * @Route("/login")
     */
    public function afterLoginAction(Request $request)
    {
        return $this->render('ViktorijaVikaBudgetBundle:Default:usersSpending.html.twig');
    }
}

