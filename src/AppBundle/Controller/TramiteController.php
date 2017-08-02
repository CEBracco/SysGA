<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tramite;
use AppBundle\Entity\Estado;
use AppBundle\Entity\Titular;
use AppBundle\Entity\Provincia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

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
            $nombreTitular = $form->get('nombreTitular')->getData();
            $apellidoTitular = $form->get('apellidoTitular')->getData();
            $provinciaTitular = $form->get('provinciaTitular')->getData();

            $tramite->setTitular($this->getTitular($nombreTitular,$apellidoTitular,$provinciaTitular));

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
            $nombreTitular = $editForm->get('nombreTitular')->getData();
            $apellidoTitular = $editForm->get('apellidoTitular')->getData();
            $provinciaTitular = $editForm->get('provinciaTitular')->getData();

            $tramite->setTitular($this->getTitular($nombreTitular,$apellidoTitular,$provinciaTitular));

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tramite_index');
        }

        return $this->render('tramite/form.html.twig', array(
            'tramite' => $tramite,
            'form' => $editForm->createView(),
            'edit' => true,
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
        $tramite->setDeletedAt(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('tramite_index');
    }

    /**
     * Obtiene los estados del tramite recibido por parametro
     *
     * @Route("/{id}/estados", name="tramite_status")
     * @Method({"POST"})
     */
    public function tramiteStatusAction(Request $request, Tramite $tramite)
    {
        $normalizer = new GetSetMethodNormalizer();
        $normalizer->setIgnoredAttributes(array('tramite'));
        $encoder = new JsonEncoder();

        $callback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('Y-m-d H:i:s')
                : '';
        };
        $normalizer->setCallbacks(array('fecha' => $callback));

        $serializer = new Serializer(array($normalizer), array($encoder));
        $content=$serializer->serialize($tramite->getEstados(), 'json');
        return new Response($content);
    }

    /**
     * Agrega un nuevo estado al tramite recibido por parametro
     *
     * @Route("/{id}/addEstado", name="tramite_addEstado")
     * @Method({"POST"})
     */
    public function addTramiteStatusAction(Request $request, Tramite $tramite)
    {
        $status=$request->request->get('estado');
        $observacion=$request->request->get('observacion');

        $estado=new Estado($status);
        $estado->setObservacion($observacion);

        $tramite->addEstado($estado);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new JsonResponse(array('status' => 'ok'));
    }

    private function getTitular($nombre, $apellido, Provincia $provincia){
        $em = $this->getDoctrine()->getManager();
        $titular = $em->getRepository('AppBundle:Titular')->findOneBy(array(
            'nombre' => $nombre,
            'apellido' => $apellido,
            'provincia' => $provincia
        ));

        if($titular == null){
            $titular=new Titular($nombre);
            $titular->setNombre($nombre);
            $titular->setApellido($apellido);
            $titular->setProvincia($provincia);
        }

        return $titular;
    }
}
