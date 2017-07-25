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
            $this->saveMovimiento($movimiento);
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
     * Deletes a movimiento entity.
     *
     * @Route("/{id}/delete", name="movimiento_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Movimiento $movimiento)
    {
        $contramovimiento=new Movimiento();
        $contramovimiento->setMonto($movimiento->getMonto() * -1);
        $contramovimiento->setConcesionaria($movimiento->getConcesionaria());
        $contramovimiento->setFecha($movimiento->getFecha());
        $contramovimiento->setTipo($movimiento->getTipo());
        $contramovimiento->setIsContramovimiento(true);

        $movimiento->setDeletedAt(new \DateTime());

        $this->saveMovimiento($contramovimiento);

        return $this->redirectToRoute('movimiento_index');
    }

    private function aplicarMonto(Movimiento $movimiento){
        $concesionaria=$movimiento->getConcesionaria();
        switch ($movimiento->getTipo()) {
            case 1:
                $concesionaria->setSaldoDepositado($concesionaria->getSaldoDepositado() + $movimiento->getMonto());
                break;
            case 2:
                $concesionaria->setSaldoDepositado($concesionaria->getSaldoDepositado() - $movimiento->getMonto());
                break;
            case 3:
                $concesionaria->setSaldoEnRegistro($concesionaria->getSaldoEnRegistro() + $movimiento->getMonto());
                break;
            case 4:
                $concesionaria->setSaldoEnRegistro($concesionaria->getSaldoEnRegistro() - $movimiento->getMonto());
                break;
        }
    }

    private function saveMovimiento(Movimiento $movimiento){
        $em = $this->getDoctrine()->getManager();
        $em->persist($movimiento);
        $this->aplicarMonto($movimiento);
        $em->flush();
    }
}
