<?php

namespace Neralind\TicketBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Neralind\TicketBundle\Entity\Talk;
use Neralind\TicketBundle\Form\TalkType;

/**
 * Talk controller.
 *
 * @Route("/ticket/talk")
 */
class TalkController extends Controller
{
     /**
     * Displays talks
     *
     * @Route("/{id}", name="ticket_talk")
     * @Method("GET")
     * @Template()
     */
     public function indexAction($id)
     {
        $em = $this->getDoctrine()->getManager();

        $ticket = $em->getRepository('NeralindTicketBundle:Ticket')->find($id);

        if (!$ticket) {
            throw $this->createNotFoundException('Unable to find Ticket ent}
                ity.');
        }
        
        $talks = $em->getRepository('NeralindTicketBundle:Talk')->findByTicket($ticket);
        return array(
            'entity' => $ticket,
            'entities' => $talks
            );
    }

    /**
     * Creates a new Talk entity.
     *
     * @Route("/{id}/new", name="ticket_talk_create")
     * @Method("POST")
     * @Template("NeralindTicketBundle:Talk:new.html.twig")     
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function createAction($id, Request $request)
    {
         $em = $this->getDoctrine()->getManager();

         $ticket = $em->getRepository('NeralindTicketBundle:Ticket')->find($id);

         if (!$ticket) {
            throw $this->createNotFoundException('Unable to find Ticket entity.');
         }


        $entity = new Talk();    
        $entity->setTicket($ticket);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = $this->get('security.context')->getToken()->getUser();
            $entity->setCreator($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ticket'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            );
}

    /**
     * Creates a form to create a Talk entity.
     *
     * @param Talk $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Talk $entity)
    {
        $form = $this->createForm(new TalkType(), $entity, array(
            'action' => $this->generateUrl('ticket_talk_create', array('id' => $entity->getTicket()->getId())),
            'method' => 'POST',
            ));

        $form->add('submit', 'submit', array('label' => 'répondre', 'attr' => array('class' => 'forum-contents-answer-button')));

        return $form;
    }

    /**
     * Displays a form to create a new Talk entity.
     *
     * @Route("/{id}/new", name="ticket_talk_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $ticket = $em->getRepository('NeralindTicketBundle:Ticket')->find($id);

        if (!$ticket) {
            throw $this->createNotFoundException('Unable to find Ticket entity.');
        }


        $entity = new Talk();
        $entity->setTicket($ticket);
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            );
    }



    /**
     * Displays a form to edit an existing Talk entity.
     *
     * @Route("/{id}/edit", name="ticket_talk_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NeralindTicketBundle:Talk')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Talk entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            );
    }

    /**
    * Creates a form to edit a Talk entity.
    *
    * @param Talk $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Talk $entity)
    {
        $form = $this->createForm(new TalkType(), $entity, array(
            'action' => $this->generateUrl('ticket_talk_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Talk entity.
     *
     * @Route("/{id}", name="ticket_talk_update")
     * @Method("PUT")
     * @Template("NeralindTicketBundle:Talk:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NeralindTicketBundle:Talk')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Talk entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ticket_talk_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            );
    }
    /**
     * Deletes a Talk entity.
     *
     * @Route("/{id}", name="ticket_talk_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NeralindTicketBundle:Talk')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Talk entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ticket_talk'));
    }

    /**
     * Creates a form to delete a Talk entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('ticket_talk_delete', array('id' => $id)))
        ->setMethod('DELETE')
        ->add('submit', 'submit', array('label' => 'Delete'))
        ->getForm()
        ;
    }
}
