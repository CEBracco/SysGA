<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tramite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Tramite controller.
 *
 * @Route("tramite")
 */
class TramiteController extends Controller
{
    /**
     * Lists all tramite entities.
     *
     * @Route("/", name="tramite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tramites = $em->getRepository('AppBundle:Tramite')->findAll();

        return $this->render('tramite/index.html.twig', array(
            'tramites' => $tramites,
        ));
    }

    /**
     * Creates a new tramite entity.
     *
     * @Route("/new", name="tramite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tramite = new Tramite();
        $form = $this->createForm('AppBundle\Form\TramiteType', $tramite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tramite);
            $em->flush();

            return $this->redirectToRoute('tramite_show', array('id' => $tramite->getId()));
        }

        return $this->render('tramite/new.html.twig', array(
            'tramite' => $tramite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tramite entity.
     *
     * @Route("/{id}", name="tramite_show")
     * @Method("GET")
     */
    public function showAction(Tramite $tramite)
    {
        $deleteForm = $this->createDeleteForm($tramite);

        return $this->render('tramite/show.html.twig', array(
            'tramite' => $tramite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tramite entity.
     *
     * @Route("/{id}/edit", name="tramite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tramite $tramite)
    {
        $deleteForm = $this->createDeleteForm($tramite);
        $editForm = $this->createForm('AppBundle\Form\TramiteType', $tramite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tramite_edit', array('id' => $tramite->getId()));
        }

        return $this->render('tramite/edit.html.twig', array(
            'tramite' => $tramite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tramite entity.
     *
     * @Route("/{id}", name="tramite_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tramite $tramite)
    {
        $form = $this->createDeleteForm($tramite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tramite);
            $em->flush();
        }

        return $this->redirectToRoute('tramite_index');
    }

    /**
     * Creates a form to delete a tramite entity.
     *
     * @param Tramite $tramite The tramite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tramite $tramite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tramite_delete', array('id' => $tramite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
