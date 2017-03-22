<?php

namespace Appcoachs\Bundle\MaterialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AppcoachsMaterialBundle:Default:index.html.twig', array('name' => $name));
    }
}
