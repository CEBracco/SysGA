<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Titular;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Titular controller.
 *
 * @Route("titular")
 */
class TitularController extends Controller
{
    /**
     * Lists all titular entities.
     *
     * @Route("/", name="titular_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $titulars = $em->getRepository('AppBundle:Titular')->findAll();

        return $this->render('titular/index.html.twig', array(
            'titulars' => $titulars,
        ));
    }

    /**
     * Creates a new titular entity.
     *
     * @Route("/new", name="titular_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $titular = new Titular();
        $form = $this->createForm('AppBundle\Form\TitularType', $titular);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($titular);
            $em->flush();

            return $this->redirectToRoute('titular_show', array('id' => $titular->getId()));
        }

        return $this->render('titular/new.html.twig', array(
            'titular' => $titular,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a titular entity.
     *
     * @Route("/{id}", name="titular_show")
     * @Method("GET")
     */
    public function showAction(Titular $titular)
    {
        $deleteForm = $this->createDeleteForm($titular);

        return $this->render('titular/show.html.twig', array(
            'titular' => $titular,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing titular entity.
     *
     * @Route("/{id}/edit", name="titular_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Titular $titular)
    {
        $deleteForm = $this->createDeleteForm($titular);
        $editForm = $this->createForm('AppBundle\Form\TitularType', $titular);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('titular_edit', array('id' => $titular->getId()));
        }

        return $this->render('titular/edit.html.twig', array(
            'titular' => $titular,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a titular entity.
     *
     * @Route("/{id}", name="titular_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Titular $titular)
    {
        $form = $this->createDeleteForm($titular);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($titular);
            $em->flush();
        }

        return $this->redirectToRoute('titular_index');
    }

    /**
     * Creates a form to delete a titular entity.
     *
     * @param Titular $titular The titular entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Titular $titular)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('titular_delete', array('id' => $titular->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
