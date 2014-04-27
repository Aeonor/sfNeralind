<?php

namespace Neralind\TagBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Neralind\TagBundle\Entity\Tag;
use Neralind\TagBundle\Form\TagType;

/**
 * Tag controller.
 *
 * @Route("/admin/tag")
 */
class AdminController extends Controller {

  /**
   * Lists all Tag entities.
   * @Method("GET")
   * @Template()
   */
  public function listAction() {
    $em = $this->getDoctrine()->getManager();
    $entities = $em->getRepository('NeralindTagBundle:Tag')->findAll();

    return array(
        'entities' => $entities,
    );
  }

  /**
   * Display search form.
   * @Method("GET")
   * @Template()
   */
  public function findAction() {
    $form = $this->createSearchForm();
    return array('search_form' => $form->createView());
  }

  private function createSearchForm() {
    $defaultData = array('message' => 'Type your message here');
    return $this->createFormBuilder($defaultData)
                    ->setAction($this->generateUrl('admin_tag_search'))
                    ->setMethod('POST')
                    ->add('q', 'search')
                    ->add('search', 'submit')
                    ->getForm();
  }

  /**
   * Query search form.
   * @Route("/search", name="admin_tag_search")
   * @Method("POST")
   * @Template()
   */
  public function searchAction(Request $request) {
    $defaultData = array('message' => 'Type your message here');
    $form = $this->createSearchForm();
    $form->handleRequest($request);

    if ($form->isValid()) {
      $data = $form->getData();
      var_dump($data);
      exit;
    }
    return array();
  }

  /**
   * Creates a new Tag entity.
   *
   * @Route("/", name="admin_tag_create")
   * @Method("POST")
   * @Template("NeralindTagBundle:Admin:new.html.twig")
   */
  public function createAction(Request $request) {
    $entity = new Tag();
    $form = $this->createCreateForm($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('admin_tag_show', array('id' => $entity->getId())));
    }

    return array(
        'entity' => $entity,
        'form' => $form->createView(),
    );
  }

  /**
   * Creates a form to create a Tag entity.
   *
   * @param Tag $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createCreateForm(Tag $entity) {
    $form = $this->createForm(new TagType(), $entity, array(
        'action' => $this->generateUrl('admin_tag_create'),
        'method' => 'POST',
    ));

    $form->add('submit', 'submit', array('label' => 'Create'));

    return $form;
  }

  /**
   * Displays a form to create a new Tag entity.
   *
   * @Route("/", name="admin_tag")
   * @Route("/new", name="admin_tag_new")
   * @Method("GET")
   * @Template()
   */
  public function newAction() {
    $entity = new Tag();
    $form = $this->createCreateForm($entity);

    return array(
        'entity' => $entity,
        'form' => $form->createView(),
    );
  }

  /**
   * Displays a form to edit an existing Tag entity.
   *
   * @Route("/{slug}/edit", name="admin_tag_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction($slug) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('NeralindTagBundle:Tag')->find($slug);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Tag entity.');
    }

    $editForm = $this->createEditForm($entity);
    $deleteForm = $this->createDeleteForm($slug);

    return array(
        'entity' => $entity,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Creates a form to edit a Tag entity.
   *
   * @param Tag $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Tag $entity) {
    $form = $this->createForm(new TagType(), $entity, array(
        'action' => $this->generateUrl('admin_tag_update', array('id' => $entity->getId())),
        'method' => 'PUT',
    ));

    $form->add('submit', 'submit', array('label' => 'Update'));

    return $form;
  }

  /**
   * Edits an existing Tag entity.
   *
   * @Route("/{id}", name="admin_tag_update")
   * @Method("PUT")
   * @Template("NeralindTagBundle:Admin:edit.html.twig")
   */
  public function updateAction(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('NeralindTagBundle:Tag')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Tag entity.');
    }

    $deleteForm = $this->createDeleteForm($id);
    $editForm = $this->createEditForm($entity);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em->flush();

      return $this->redirect($this->generateUrl('admin_tag_edit', array('id' => $id)));
    }

    return array(
        'entity' => $entity,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a Tag entity.
   *
   * @Route("/{id}", name="admin_tag_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, $id) {
    $form = $this->createDeleteForm($id);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('NeralindTagBundle:Tag')->find($id);

      if (!$entity) {
        throw $this->createNotFoundException('Unable to find Tag entity.');
      }

      $em->remove($entity);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('admin_tag'));
  }

  /**
   * Creates a form to delete a Tag entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm($id) {
    return $this->createFormBuilder()
                    ->setAction($this->generateUrl('admin_tag_delete', array('id' => $id)))
                    ->setMethod('DELETE')
                    ->add('submit', 'submit', array('label' => 'Delete'))
                    ->getForm()
    ;
  }

}
