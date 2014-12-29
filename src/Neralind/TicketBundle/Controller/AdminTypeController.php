<?php

namespace Neralind\TicketBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Neralind\TicketBundle\Entity\Type;
use Neralind\TicketBundle\Form\TypeType;

/**
 * Type controller.
 *
 * @Route("/admin/ticket/type")
 */
class AdminTypeController extends Controller
{

    /**
     * Creates a new Type entity.
     *
     * @Route("/", name="admin_ticket_type_create")
     * @Method("POST")
     * @Template("NeralindTicketBundle:AdminType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Type();
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
    * Creates a form to create a Type entity.
    *
    * @param Type $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Type $entity)
    {
        $form = $this->createForm(new TypeType(), $entity, array(
            'action' => $this->generateUrl('admin_ticket_type_create'),
            'method' => 'POST',
            ));

        $form->add('submit', 'submit', array('label' => 'créer un type', 'attr'=> ['class' => 'btn']));

        return $form;
    }

    /**
     * Displays a form to create a new Type entity.
     *
     * @Route("/new", name="admin_ticket_type_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Type();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            );
    }

    

    /**
     * Displays a form to edit an existing Type entity.
     *
     * @Route("/{id}/edit", name="admin_ticket_type_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NeralindTicketBundle:Type')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Type entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
            );
    }

    /**
    * Creates a form to edit a Type entity.
    *
    * @param Type $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Type $entity)
    {
        $form = $this->createForm(new TypeType(), $entity, array(
            'action' => $this->generateUrl('admin_ticket_type_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            ));

        $form->add('submit', 'submit', array('label' => 'mettre à jour le type', 'attr'=> ['class' => 'btn']));

        return $form;
    }
    /**
     * Edits an existing Type entity.
     *
     * @Route("/{id}", name="admin_ticket_type_update")
     * @Method("PUT")
     * @Template("NeralindTicketBundle:AdminType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NeralindTicketBundle:Type')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Type entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_ticket_type_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
            );
    }

    /**
     * Displays a form to delete an existing Type entity.
     *
     * @Route("/{id}/delete", name="admin_ticket_type_erase")
     * @Method("GET")
     * @Template()
     */
    public function eraseAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NeralindTicketBundle:Type')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Type entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView()
            );
    }

    /**
     * Deletes a Type entity.
     *
     * @Route("/{id}", name="admin_ticket_type_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NeralindTicketBundle:Type')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Type entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_ticket'));
    }

    /**
     * Creates a form to delete a Type entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('admin_ticket_type_delete', array('id' => $id)))
        ->setMethod('DELETE')
        ->add('submit', 'submit', array('label' => 'Delete', 'attr'=> array('class' => 'icon-delete icon-big admin-actions-icon')))
        ->getForm()
        ;
    }
}
