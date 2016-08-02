<?php

namespace SON\CatalogoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SON\CatalogoBundle\Entity\Catalogo;
use SON\CatalogoBundle\Form\CatalogoType;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

/**
 * Catalogo controller.
 *
 * @Route("/")
 */
class CatalogoController extends Controller
{
    /**
     * Lists all Catalogo entities.
     *
     * @Route("/catalogo", name="catalogo")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CatalogoBundle:Catalogo')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Catalogo entity.
     *
     * @Route("/catalogo/{id}/show", name="catalogo_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CatalogoBundle:Catalogo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catalogo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Finds and displays a Catalogo entity.
     *
     * @Route("/catalogo/slug/{slug}", name="catalogo_show_slug")
     * @Template("CatalogoBundle:Catalogo:show.html.twig")
     */
    public function showBySlugAction($slug)
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$entity = $em->getRepository('CatalogoBundle:Catalogo')->findOneBySlug($slug);
    	
    	if (!$entity) {
    		throw $this->createNotFoundException('Catalogo não encontrado!!!');
    	}
    	
    	$deleteForm = $this->createDeleteForm($entity->getId());
    	
    	return array(
    			'entity'      => $entity,
    			'delete_form' => $deleteForm->createView(),
    	);
    }

    /**
     * Displays a form to create a new Catalogo entity.
     *
     * @Route("catalogo/new", name="catalogo_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Catalogo();
        $form   = $this->createForm(new CatalogoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Catalogo entity.
     *
     * @Route("/catalogo/create", name="catalogo_create")
     * @Method("POST")
     * @Template("CatalogoBundle:Catalogo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Catalogo();
        $form = $this->createForm(new CatalogoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
        	/** @var User */
        	$user = $this->getUser();
        	$entity->setAutor($user);
        	
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('catalogo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Catalogo entity.
     *
     * @Route("/catalogo/{id}/edit", name="catalogo_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CatalogoBundle:Catalogo')->find($id);
		
        $this->verificaAutor($entity);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catalogo entity.');
        }

        $editForm = $this->createForm(new CatalogoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Catalogo entity.
     *
     * @Route("/catalogo/{id}/update", name="catalogo_update")
     * @Method("POST")
     * @Template("CatalogoBundle:Catalogo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CatalogoBundle:Catalogo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catalogo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CatalogoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('catalogo_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Catalogo entity.
     *
     * @Route("/catalogo/{id}/delete", name="catalogo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CatalogoBundle:Catalogo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Catalogo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('catalogo'));
    }
	    
    /**
     * Ação de Curtir o catalogo.
     * @Route("/{id}/like.{_format}", name="catalogo_like", defaults={"_format"="json"})
     * 
     * @param int $id
     */
    public function likeAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	/** @var $entity \SON\CatalogoBundle\Entity\Catalogo */
    	$entity = $em->getRepository('CatalogoBundle:Catalogo')->find($id);
    	
    	if(!$entity->hasLike($this->getUser())) {
    		$entity->getLike()->add($this->getUser());
    	}
    		
    	$em->persist($entity);
    	$em->flush();
    	
    	if($this->getRequest()->getRequestFormat()=="json") {
    		return $this->retornoCurtir(true);
    	}
    	
    	return $this->redirect($this->generateUrl('catalogo_show_slug', array('slug'=>$entity->getSlug())));
    }
    
    /**
     * Ação de não curtir o catalogo.
     * @Route("/{id}/unlike.{_format}", name="catalogo_unlike", defaults={"_format"="json"})
     * 
     * @param int $id
     */
    public function unlikeAction($id)
    {
    	
    	$em = $this->getDoctrine()->getManager();
    	/** @var $entity \SON\CatalogoBundle\Entity\Catalogo */
    	$entity = $em->getRepository('CatalogoBundle:Catalogo')->find($id);
    	
    	if($entity->hasLike($this->getUser())) {
    		$entity->getLike()->removeElement($this->getUser());
    	}
    	
    	$em->persist($entity);
    	$em->flush();
    	
    	if($this->getRequest()->getRequestFormat()=="json") {
    		return $this->retornoCurtir(false);
    	}
    	
    	return $this->redirect($this->generateUrl('catalogo_show_slug', array('slug'=>$entity->getSlug())));
    }
    
    private function retornoCurtir($curtir)
    {
    	$data = array(
    			'like' => $curtir
    	);
    
    	$response = new Response(json_encode($data));
    	return $response;
    }
    
    
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    private function verificaAutor(Catalogo $catalogo){
    	$user = $this->getUser();
    	if($user != $catalogo->getAutor()){
    		throw new AccessDeniedException('Voce não é o autor do catalogo');
    	}
    }
 	   
}