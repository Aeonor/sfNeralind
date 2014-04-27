<?php

namespace Neralind\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NeralindUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
