<?php

namespace Viktorija\VikaBudgetBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return new Response('Admin page!' );
    }

    /**
     * @Route("/login")
     */
    public function afterLoginAction(Request $request)
    {
//        return new Response('You are logged in!' );
        return $this->render('ViktorijaVikaBudgetBundle:Default:usersSpending.html.twig');
    }
}


//
//namespace Viktorija\VikaBudgetBundle\Controller;
//
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//
//class DefaultController extends Controller
//{
//    /**
//     * @Route("/app/example", name="homepage")
//     */
//    public function indexAction()
//    {
//        return $this->render('default/index.html.twig');
//    }
//}
