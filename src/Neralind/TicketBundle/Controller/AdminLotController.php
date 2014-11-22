<?php

namespace Neralind\TicketBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Neralind\TicketBundle\Entity\Lot;
use Neralind\TicketBundle\Form\LotType;

/**
 * Lot controller.
 *
 * @Route("/admin/ticket/lot")
 */
class AdminLotController extends Controller
{
    /**
     * Creates a new Lot entity.
     *
     * @Route("/", name="admin_ticket_lot_create")
     * @Method("POST")
     * @Template("NeralindTicketBundle:AdminLot:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Lot();
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
    * Creates a form to create a Lot entity.
    *
    * @param Lot $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Lot $entity)
    {
        $form = $this->createForm(new LotType(), $entity, array(
            'action' => $this->generateUrl('admin_ticket_lot_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'créer un lot'));

        return $form;
    }

    /**
     * Displays a form to create a new Lot entity.
     *
     * @Route("/new", name="admin_ticket_lot_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Lot();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

   

    /**
     * Displays a form to edit an existing Lot entity.
     *
     * @Route("/{id}/edit", name="admin_ticket_lot_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NeralindTicketBundle:Lot')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lot entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        );
    }

    /**
    * Creates a form to edit a Lot entity.
    *
    * @param Lot $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Lot $entity)
    {
        $form = $this->createForm(new LotType(), $entity, array(
            'action' => $this->generateUrl('admin_ticket_lot_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'mettre à jour le lot'));

        return $form;
    }
    /**
     * Edits an existing Lot entity.
     *
     * @Route("/{id}", name="admin_ticket_lot_update")
     * @Method("PUT")
     * @Template("NeralindTicketBundle:AdminLot:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NeralindTicketBundle:Lot')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lot entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('admin_ticket'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        );
    }

   /**
     * Displays a form to delete an existing Lot entity.
     *
     * @Route("/{id}/delete", name="admin_ticket_lot_erase")
     * @Method("GET")
     * @Template()
     */
    public function eraseAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NeralindTicketBundle:Lot')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lot entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView()
            );
    }

    /**
     * Deletes a Lot entity.
     *
     * @Route("/{id}", name="admin_ticket_lot_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NeralindTicketBundle:Lot')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Lot entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_ticket'));
    }

    /**
     * Creates a form to delete a Lot entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_ticket_lot_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr'=> array('class' => 'icon-delete icon-big admin-actions-icon')))
            ->getForm()
        ;
    }
}
