<?php

namespace Prueba\PruebaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Prueba\PruebaBundle\Entity\Productos;
use Prueba\PruebaBundle\Form\ProductosType;

/**
 * Productos controller.
 *
 */
class ProductosController extends Controller
{
    /**
     * Lists all Productos entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $productos = $em->getRepository('PruebaBundle:Productos')->findAll();

        return $this->render('productos/index.html.twig', array(
            'productos' => $productos,
        ));
    }

    /**
     * Creates a new Productos entity.
     *
     */
    public function newAction(Request $request)
    {
        $producto = new Productos();
        $form = $this->createForm(new ProductosType(), $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($producto);
            $em->flush();

            return $this->redirectToRoute('productos_show', array('id' => $productos->getId()));
        }

        return $this->render('productos/new.html.twig', array(
            'producto' => $producto,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Productos entity.
     *
     */
    public function showAction(Productos $producto)
    {
        $deleteForm = $this->createDeleteForm($producto);

        return $this->render('productos/show.html.twig', array(
            'producto' => $producto,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Productos entity.
     *
     */
    public function editAction(Request $request, Productos $producto)
    {
        $deleteForm = $this->createDeleteForm($producto);
        $editForm = $this->createForm(new ProductosType(), $producto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($producto);
            $em->flush();

            return $this->redirectToRoute('productos_edit', array('id' => $producto->getId()));
        }

        return $this->render('productos/edit.html.twig', array(
            'producto' => $producto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Productos entity.
     *
     */
    public function deleteAction(Request $request, Productos $producto)
    {
        $form = $this->createDeleteForm($producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($producto);
            $em->flush();
        }

        return $this->redirectToRoute('productos_index');
    }

    /**
     * Creates a form to delete a Productos entity.
     *
     * @param Productos $producto The Productos entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Productos $producto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('productos_delete', array('id' => $producto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
