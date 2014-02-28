<?php

namespace Neralind\ResourceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NeralindResourceBundle:Default:index.html.twig', array('name' => $name));
    }
}
