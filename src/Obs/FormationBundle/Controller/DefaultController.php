<?php

namespace Obs\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($page)
    {
    	$tab = array(
    		0 => "test1",
    		1 => "test2",
    		2 => "test3",
    	);
    	
    	$date = new \DateTime();
    	
        return $this->render('ObsFormationBundle:Default:index.html.twig', array(
        		'tableau' => $tab,
        		'date' => $date,
        		'page' => $page
        ));
    }
    
    public function helloAction()
    {
    	return new Response("hello world !");
    }
}
