<?php

namespace Neralind\TagBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NeralindTagBundle:Default:index.html.twig', array('name' => $name));
    }
}
