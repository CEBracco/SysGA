<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tarea;
use AppBundle\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;


/**
 * Tarea controller.
 *
 * @Route("agenda")
 */
class TareaController extends Controller
{
    /**
     * Lists all tarea entities.
     *
     * @Route("/", name="tarea_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tareas = $em->getRepository('AppBundle:Tarea')->findAll();
		$usuarios = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('tarea/index.html.twig', array(
            'tareas' => $tareas,
			'usuarios' => $usuarios
        ));
    }

    /**
     * Creates a new tarea entity.
     *
     * @Route("/new", name="tarea_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tarea = new Tarea();
        $form = $this->createForm('AppBundle\Form\TareaType', $tarea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tarea);
            $em->flush();

            return $this->redirectToRoute('tarea_index');
        }

        return $this->render('tarea/form.html.twig', array(
            'tarea' => $tarea,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tarea entity.
     *
     * @Route("/{id}/edit", name="tarea_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tarea $tarea)
    {
        $editForm = $this->createForm('AppBundle\Form\TareaType', $tarea);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tarea_index');
        }

        return $this->render('tarea/form.html.twig', array(
            'tarea' => $tarea,
            'form' => $editForm->createView(),
            'edit' => true,
        ));
    }

    /**
     * Deletes a tarea entity.
     *
     * @Route("/{id}/delete", name="tarea_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Tarea $tarea)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($tarea);
        $em->flush();

        return $this->redirectToRoute('tarea_index');
    }

	/**
     * Marca una tarea como realizada
     *
     * @Route("/{id}/done", name="tarea_done")
	 * @Method({"POST"})
     */
    public function doneAction(Request $request, Tarea $tarea)
    {
        $em = $this->getDoctrine()->getManager();
        $tarea->setRealizada(true);
        $em->flush();

        return new JsonResponse(array('status' => 'ok'));
    }

	/**
	 *
	 * @Route("/{id}/listado", name="tarea_list")
	 * @Method({"POST"})
	 */
	public function tareaListadoAction(Request $request, User $user)
	{
		$fecha=\DateTime::createFromFormat('!d/m/Y',$request->request->get('fecha',''));

		$em = $this->getDoctrine()->getManager();
		$tareas = $em->getRepository('AppBundle:Tarea')->findBy(array('user' => $user,'fecha' => $fecha));

		$normalizer = new GetSetMethodNormalizer();
		$normalizer->setIgnoredAttributes(array('user'));
		$encoder = new JsonEncoder();

		$callback = function ($dateTime) {
			return $dateTime instanceof \DateTime
				? $dateTime->format('Y-m-d H:i:s')
				: '';
		};
		$normalizer->setCallbacks(array('fecha' => $callback));

		$serializer = new Serializer(array($normalizer), array($encoder));
		$content=$serializer->serialize($tareas, 'json');
		return new Response($content);
	}
}
