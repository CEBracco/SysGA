<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RegistroDelAutomotor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Registrodelautomotor controller.
 *
 * @Route("registrodelautomotor")
 */
class RegistroDelAutomotorController extends Controller
{
    /**
     * Lists all registroDelAutomotor entities.
     *
     * @Route("/", name="registrodelautomotor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $registrosDelAutomotor = $em->getRepository('AppBundle:RegistroDelAutomotor')->findAll();

        return $this->render('registrodelautomotor/index.html.twig', array(
            'registrosDelAutomotor' => $registrosDelAutomotor,
        ));
    }

    /**
     * Creates a new registroDelAutomotor entity.
     *
     * @Route("/new", name="registrodelautomotor_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $registroDelAutomotor = new Registrodelautomotor();
        $form = $this->createForm('AppBundle\Form\RegistroDelAutomotorType', $registroDelAutomotor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($registroDelAutomotor);
            $em->flush();

            return $this->redirectToRoute('registrodelautomotor_show', array('id' => $registroDelAutomotor->getId()));
        }

        return $this->render('registrodelautomotor/new.html.twig', array(
            'registroDelAutomotor' => $registroDelAutomotor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a registroDelAutomotor entity.
     *
     * @Route("/{id}", name="registrodelautomotor_show")
     * @Method("GET")
     */
    public function showAction(RegistroDelAutomotor $registroDelAutomotor)
    {
        $deleteForm = $this->createDeleteForm($registroDelAutomotor);

        return $this->render('registrodelautomotor/show.html.twig', array(
            'registroDelAutomotor' => $registroDelAutomotor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing registroDelAutomotor entity.
     *
     * @Route("/{id}/edit", name="registrodelautomotor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RegistroDelAutomotor $registroDelAutomotor)
    {
        $deleteForm = $this->createDeleteForm($registroDelAutomotor);
        $editForm = $this->createForm('AppBundle\Form\RegistroDelAutomotorType', $registroDelAutomotor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('registrodelautomotor_edit', array('id' => $registroDelAutomotor->getId()));
        }

        return $this->render('registrodelautomotor/edit.html.twig', array(
            'registroDelAutomotor' => $registroDelAutomotor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a registroDelAutomotor entity.
     *
     * @Route("/{id}", name="registrodelautomotor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RegistroDelAutomotor $registroDelAutomotor)
    {
        $form = $this->createDeleteForm($registroDelAutomotor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($registroDelAutomotor);
            $em->flush();
        }

        return $this->redirectToRoute('registrodelautomotor_index');
    }

    /**
     * Creates a form to delete a registroDelAutomotor entity.
     *
     * @param RegistroDelAutomotor $registroDelAutomotor The registroDelAutomotor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RegistroDelAutomotor $registroDelAutomotor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('registrodelautomotor_delete', array('id' => $registroDelAutomotor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
