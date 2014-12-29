<?php

namespace Neralind\TicketBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Neralind\TicketBundle\Entity\Status;
use Neralind\TicketBundle\Form\StatusType;

/**
 * Status controller.
 *
 * @Route("/admin/ticket/status")
 */
class AdminStatusController extends Controller
{
  
    /**
     * Creates a new Status entity.
     *
     * @Route("/", name="admin_ticket_status_create")
     * @Method("POST")
     * @Template("NeralindTicketBundle:AdminStatus:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Status();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_ticket'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Status entity.
    *
    * @param Status $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Status $entity)
    {
        $form = $this->createForm(new StatusType(), $entity, array(
            'action' => $this->generateUrl('admin_ticket_status_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'créer un statut', 'attr'=> ['class' => 'btn']));

        return $form;
    }

    /**
     * Displays a form to create a new Status entity.
     *
     * @Route("/new", name="admin_ticket_status_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Status();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    /**
     * Displays a form to edit an existing Status entity.
     *
     * @Route("/{id}/edit", name="admin_ticket_status_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NeralindTicketBundle:Status')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Status entity.');
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
    * Creates a form to edit a Status entity.
    *
    * @param Status $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Status $entity)
    {
        $form = $this->createForm(new StatusType(), $entity, array(
            'action' => $this->generateUrl('admin_ticket_status_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'mettre à jour le statut', 'attr'=> ['class' => 'btn']));

        return $form;
    }
    /**
     * Edits an existing Status entity.
     *
     * @Route("/{id}", name="admin_ticket_status_update")
     * @Method("PUT")
     * @Template("NeralindTicketBundle:AdminStatus:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NeralindTicketBundle:Status')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Status entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_ticket_status_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

     /**
     * Displays a form to delete an existing Status entity.
     *
     * @Route("/{id}/delete", name="admin_ticket_status_erase")
     * @Method("GET")
     * @Template()
     */
    public function eraseAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NeralindTicketBundle:Status')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Status entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView()
            );
    }

    /**
     * Deletes a Status entity.
     *
     * @Route("/{id}", name="admin_ticket_status_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NeralindTicketBundle:Status')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Status entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_ticket'));
    }

    /**
     * Creates a form to delete a Status entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_ticket_status_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr'=> array('class' => 'icon-delete icon-big admin-actions-icon')))
            ->getForm()
        ;
    }
}
