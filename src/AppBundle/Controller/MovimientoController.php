<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Movimiento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Movimiento controller.
 *
 * @Route("movimiento")
 */
class MovimientoController extends Controller
{
    /**
     * Lists all movimiento entities.
     *
     * @Route("/", name="movimiento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $movimientos = $em->getRepository('AppBundle:Movimiento')->findAll();

        return $this->render('movimiento/index.html.twig', array(
            'movimientos' => $movimientos,
        ));
    }

    /**
     * Creates a new movimiento entity.
     *
     * @Route("/new", name="movimiento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $movimiento = new Movimiento();
        $form = $this->createForm('AppBundle\Form\MovimientoType', $movimiento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movimiento);
            $em->flush();

            return $this->redirectToRoute('movimiento_show', array('id' => $movimiento->getId()));
        }

        return $this->render('movimiento/new.html.twig', array(
            'movimiento' => $movimiento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a movimiento entity.
     *
     * @Route("/{id}", name="movimiento_show")
     * @Method("GET")
     */
    public function showAction(Movimiento $movimiento)
    {
        $deleteForm = $this->createDeleteForm($movimiento);

        return $this->render('movimiento/show.html.twig', array(
            'movimiento' => $movimiento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing movimiento entity.
     *
     * @Route("/{id}/edit", name="movimiento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Movimiento $movimiento)
    {
        $deleteForm = $this->createDeleteForm($movimiento);
        $editForm = $this->createForm('AppBundle\Form\MovimientoType', $movimiento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('movimiento_edit', array('id' => $movimiento->getId()));
        }

        return $this->render('movimiento/edit.html.twig', array(
            'movimiento' => $movimiento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a movimiento entity.
     *
     * @Route("/{id}", name="movimiento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Movimiento $movimiento)
    {
        $form = $this->createDeleteForm($movimiento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($movimiento);
            $em->flush();
        }

        return $this->redirectToRoute('movimiento_index');
    }

    /**
     * Creates a form to delete a movimiento entity.
     *
     * @param Movimiento $movimiento The movimiento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Movimiento $movimiento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('movimiento_delete', array('id' => $movimiento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
