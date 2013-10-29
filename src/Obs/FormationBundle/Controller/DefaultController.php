<?php

namespace Obs\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ObsFormationBundle:Default:index.html.twig', array('name' => $name));
    }
}
