<?php

namespace SON\CategoriaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SON\CategoriaBundle\Entity\Categoria;
use SON\CategoriaBundle\Form\CategoriaType;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Categoria controller.
 *
 */
class CategoriaController extends Controller
{

    /** @var  SecurityContext */
    private $securityContext;

    /**
     * Lists all Categoria entities.
     *
     */
    public function indexAction()
    {
    	
        $this->validarPermissao();
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CategoriaBundle:Categoria')->findAll();

        return $this->render('CategoriaBundle:Categoria:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Categoria entity.
     *
     */
    public function showAction($id)
    {
        $this->validarPermissao();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CategoriaBundle:Categoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CategoriaBundle:Categoria:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Categoria entity.
     *
     */
    public function newAction()
    {
        $this->validarPermissao();
        $entity = new Categoria();
        $form   = $this->createForm(new CategoriaType(), $entity);

        return $this->render('CategoriaBundle:Categoria:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Categoria entity.
     *
     */
    public function createAction(Request $request)
    {
        $this->validarPermissao();
        $entity  = new Categoria();
        $form = $this->createForm(new CategoriaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('categoria_show', array('id' => $entity->getId())));
        }

        return $this->render('CategoriaBundle:Categoria:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Categoria entity.
     *
     */
    public function editAction($id)
    {
        $this->validarPermissao();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CategoriaBundle:Categoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }

        $editForm = $this->createForm(new CategoriaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CategoriaBundle:Categoria:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Categoria entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $this->validarPermissao();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CategoriaBundle:Categoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CategoriaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('categoria_edit', array('id' => $id)));
        }

        return $this->render('CategoriaBundle:Categoria:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Categoria entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $this->validarPermissao();
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CategoriaBundle:Categoria')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Categoria entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('categoria'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    private function validarPermissao(){
        $this->securityContext = $this->get('security.context');

        if(!$this->securityContext->isGranted('ROLE_USER')){
            throw new AccessDeniedException("Somente Admins podem acessar");
        }
    }

}