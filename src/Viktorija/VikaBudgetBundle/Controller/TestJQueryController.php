<?php
/**
 * Created by PhpStorm.
 * User: Viktorija
 * Date: 7/3/2015
 * Time: 10:06 AM
 */

namespace Viktorija\VikaBudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TestJQueryController extends Controller {

    public function testAction(Request $request)
    {
//        return $this->render('ViktorijaVikaBudgetBundle:Tests:testJQuery.html.twig');

//        string date ( string $format [, int $timestamp = time() ]
//        $todayIs = date('l jS \of F Y h:i:s A');
//        $todayIs = date("j, n, Y");
        $todayIs = date("Ymd");
        $weeknumber = date("oW", strtotime($todayIs));
        //if $weeknumber in database == $weeknumber pridėti, jei ne - nunulinti week išlaidas ir pridėti
        return new Response($todayIs . "week:" . $weeknumber);
//        echo date('l jS \of F Y h:i:s A');
    }

    public function ajaxResponseAction(Request $blablabla) {
//        return $this->render($_POST);
        $em = $this->getDoctrine()->getManager();
        //cia galėtų būti flush į duomenų bazę:
        return $this->render('ViktorijaVikaBudgetBundle:Tests:ajaxResponse.html.twig');
    }
}
