<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Concesionaria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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

            return $this->redirectToRoute('concesionaria_index');
        }

        return $this->render('concesionaria/form.html.twig', array(
            'concesionaria' => $concesionaria,
            'form' => $form->createView(),
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
        $editForm = $this->createForm('AppBundle\Form\ConcesionariaType', $concesionaria);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('concesionaria_index');
        }

        return $this->render('concesionaria/form.html.twig', array(
            'concesionaria' => $concesionaria,
            'form' => $editForm->createView(),
            'edit' => true,
        ));
    }

    /**
     * Deletes a concesionaria entity.
     *
     * @Route("/{id}/delete", name="concesionaria_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Concesionaria $concesionaria)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($concesionaria);
        $em->flush();

        return $this->redirectToRoute('concesionaria_index');
    }

    /**
     * Finds and displays a concesionaria entity.
     *
     * @Route("/{id}/cuentas", name="concesionaria_cuentas")
     * @Method("POST")
     */
    public function getCuentasAction(Concesionaria $concesionaria)
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('concesionaria'));
        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));
        $content=$serializer->serialize($concesionaria->getCuentas(), 'json');
        return new Response($content);
    }
}
