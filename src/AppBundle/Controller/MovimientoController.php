<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Movimiento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
            var_dump($movimiento);
            $em = $this->getDoctrine()->getManager();
            $em->persist($movimiento);
            $em->flush();

            return $this->redirectToRoute('movimiento_index');
        }

        return $this->render('movimiento/form.html.twig', array(
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
        return $this->render('movimiento/show.html.twig', array(
            'movimiento' => $movimiento,
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
        $editForm = $this->createForm('AppBundle\Form\MovimientoType', $movimiento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('movimiento_index');
        }

        return $this->render('movimiento/form.html.twig', array(
            'movimiento' => $movimiento,
            'form' => $editForm->createView(),
            'edit' => true,
        ));
    }

    /**
     * Deletes a movimiento entity.
     *
     * @Route("/{id}/delete", name="movimiento_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Movimiento $movimiento)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($movimiento);
        $em->flush();

        return $this->redirectToRoute('movimiento_index');
    }
}
