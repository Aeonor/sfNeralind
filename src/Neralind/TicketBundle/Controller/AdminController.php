<?php

namespace Neralind\TicketBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Neralind\TicketBundle\Entity\Ticket;
use Neralind\TicketBundle\Form\TicketType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Ticket controller.
 *
 * @Route("/admin/ticket")
 * @Security("has_role('ROLE_ADMIN_TICKET')")
 */
class AdminController extends Controller
{
    /**
     * Admin tickets.
     *
     * @Route("/", name="admin_ticket")
     * @Method("GET")
     * @Template()
     */
	public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $lots   = $em->getRepository('NeralindTicketBundle:Lot')->findAll();
        $status = $em->getRepository('NeralindTicketBundle:Status')->findAll();
        $types = $em->getRepository('NeralindTicketBundle:Type')->findAll();


        return array(
            'lots' => $lots,
            'status' => $status,
            'types' => $types,
        );
	}
}