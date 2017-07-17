<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Concesionaria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Concesionaria controller.
 *
 * @Route("concesionaria")
 */
class ConcesionariaController extends Controller
{
    /**
     * Lists all concesionaria entities.
     *
     * @Route("/", name="concesionaria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $concesionarias = $em->getRepository('AppBundle:Concesionaria')->findAll();

        return $this->render('concesionaria/index.html.twig', array(
            'concesionarias' => $concesionarias,
        ));
    }

    /**
     * Creates a new concesionaria entity.
     *
     * @Route("/new", name="concesionaria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $concesionaria = new Concesionaria();
        $form = $this->createForm('AppBundle\Form\ConcesionariaType', $concesionaria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($concesionaria);
            $em->flush();

            return $this->redirectToRoute('concesionaria_show', array('id' => $concesionaria->getId()));
        }

        return $this->render('concesionaria/new.html.twig', array(
            'concesionaria' => $concesionaria,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a concesionaria entity.
     *
     * @Route("/{id}", name="concesionaria_show")
     * @Method("GET")
     */
    public function showAction(Concesionaria $concesionaria)
    {
        $deleteForm = $this->createDeleteForm($concesionaria);

        return $this->render('concesionaria/show.html.twig', array(
            'concesionaria' => $concesionaria,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing concesionaria entity.
     *
     * @Route("/{id}/edit", name="concesionaria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Concesionaria $concesionaria)
    {
        $deleteForm = $this->createDeleteForm($concesionaria);
        $editForm = $this->createForm('AppBundle\Form\ConcesionariaType', $concesionaria);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('concesionaria_edit', array('id' => $concesionaria->getId()));
        }

        return $this->render('concesionaria/edit.html.twig', array(
            'concesionaria' => $concesionaria,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a concesionaria entity.
     *
     * @Route("/{id}", name="concesionaria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Concesionaria $concesionaria)
    {
        $form = $this->createDeleteForm($concesionaria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($concesionaria);
            $em->flush();
        }

        return $this->redirectToRoute('concesionaria_index');
    }

    /**
     * Creates a form to delete a concesionaria entity.
     *
     * @param Concesionaria $concesionaria The concesionaria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Concesionaria $concesionaria)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('concesionaria_delete', array('id' => $concesionaria->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
