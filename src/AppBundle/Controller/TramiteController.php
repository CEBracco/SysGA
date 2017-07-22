<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tramite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

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

            return $this->redirectToRoute('tramite_index');
        }

        return $this->render('tramite/form.html.twig', array(
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
        $editForm = $this->createForm('AppBundle\Form\TramiteType', $tramite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tramite_index');
        }

        return $this->render('tramite/form.html.twig', array(
            'tramite' => $tramite,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a tramite entity.
     *
     * @Route("/{id}/delete", name="tramite_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Tramite $tramite)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($tramite);
        $em->flush();

        return $this->redirectToRoute('tramite_index');
    }

    /**
     * Deletes a tramite entity.
     *
     * @Route("/{id}/change_status", name="change_status")
     * @Method("POST")
     */
    public function changeStatusAction(Request $request, Tramite $tramite)
    {
        $status=$request->request->get('status');
        $tramite->setEstado($status);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new JsonResponse(array('status' => 'ok'));
    }
}
