<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RegistroDelAutomotor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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

            return $this->redirectToRoute('registrodelautomotor_index');
        }

        return $this->render('registrodelautomotor/form.html.twig', array(
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
        return $this->render('registrodelautomotor/show.html.twig', array(
            'registroDelAutomotor' => $registroDelAutomotor,
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
        $editForm = $this->createForm('AppBundle\Form\RegistroDelAutomotorType', $registroDelAutomotor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('registrodelautomotor_index');
        }

        return $this->render('registrodelautomotor/form.html.twig', array(
            'registroDelAutomotor' => $registroDelAutomotor,
            'form' => $editForm->createView(),
            'edit' => true,
        ));
    }

    /**
     * Deletes a registroDelAutomotor entity.
     *
     * @Route("/{id}/delete", name="registrodelautomotor_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, RegistroDelAutomotor $registroDelAutomotor)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($registroDelAutomotor);
        $em->flush();

        return $this->redirectToRoute('registrodelautomotor_index');
    }

}
