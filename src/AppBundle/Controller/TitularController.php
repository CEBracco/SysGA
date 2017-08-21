<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Titular;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

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

        $titulares = $em->getRepository('AppBundle:Titular')->findAll();

        return $this->render('titular/index.html.twig', array(
            'titulares' => $titulares,
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

            return $this->redirectToRoute('titular_index');
        }

        return $this->render('titular/form.html.twig', array(
            'titular' => $titular,
            'form' => $form->createView(),
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
        $editForm = $this->createForm('AppBundle\Form\TitularType', $titular);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('titular_index');
        }

        return $this->render('titular/form.html.twig', array(
            'titular' => $titular,
            'form' => $editForm->createView(),
            'edit' => true
        ));
    }

    /**
     * Deletes a titular entity.
     *
     * @Route("/{id}/delete", name="titular_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Titular $titular)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($titular);
        $em->flush();

        return $this->redirectToRoute('titular_index');
    }

	/**
	 * Search titular entities.
	 *
	 * @Route("/search", name="titular_search")
	 * @Method({"GET", "POST"})
	 */
	public function searchAction(Request $request)
	{
		$value=$request->request->get('value','');

		$em = $this->getDoctrine()->getManager();

		if ($this->getUser()->getRol() != 'ROLE_CONCESIONARIA'){
			$titulares = $em->getRepository('AppBundle:Titular')->search($value);
		}
		else{
			$titulares = $em->getRepository('AppBundle:Titular')->searchInConcesionaria($value,$this->getUser()->getConcesionaria());
		}

		$normalizer = new GetSetMethodNormalizer();
		$encoder = new JsonEncoder();

		$serializer = new Serializer(array($normalizer), array($encoder));
		$content=$serializer->serialize($titulares, 'json');
		return new Response($content);
	}
}
