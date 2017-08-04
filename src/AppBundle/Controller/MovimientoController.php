<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Movimiento;
use AppBundle\Entity\Tramite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

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
            if($movimiento->isMovimientoEnRegistro()){
                $movimiento->setRegistroDelAutomotor(null);
            }

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
        $contramovimiento->setRegistroDelAutomotor($movimiento->getRegistroDelAutomotor());
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
                $concesionaria->efectuarEntrada($movimiento);
                break;
            case 4:
                $concesionaria->efectuarSalida($movimiento);
                break;
        }
    }

    private function saveMovimiento(Movimiento $movimiento){
        $em = $this->getDoctrine()->getManager();
        $em->persist($movimiento);
        $this->aplicarMonto($movimiento);
        $em->flush();
    }

    /**
     * Creates a new movimiento entity with tramite.
     *
     * @Route("/newFromTramite/{id}", name="movimiento_tramite_new")
     * @Method({"GET", "POST"})
     */
    public function newMovimientoTramiteAction(Tramite $tramite)
    {
        $movimientoEnRegistro = new Movimiento();
        $movimientoEnRegistro->setMonto($tramite->getTotalEnRegistro());
        $movimientoEnRegistro->setConcesionaria($tramite->getConcesionaria());
        $movimientoEnRegistro->setRegistroDelAutomotor($tramite->getRegistroDelAutomotor());
        $movimientoEnRegistro->setFecha(new \DateTime());
        $movimientoEnRegistro->setTipo(4);
        // setTramite

        $movimientoGestoria = new Movimiento();
        $movimientoGestoria->setMonto($tramite->getTotalGestoria());
        $movimientoGestoria->setConcesionaria($tramite->getConcesionaria());
        $movimientoGestoria->setRegistroDelAutomotor($tramite->getRegistroDelAutomotor());
        $movimientoGestoria->setFecha(new \DateTime());
        $movimientoGestoria->setTipo(2);
        // setTramite

        $em = $this->getDoctrine()->getManager();

        $em->persist($movimientoEnRegistro);
        $this->aplicarMonto($movimientoEnRegistro);

        $em->persist($movimientoGestoria);
        $this->aplicarMonto($movimientoGestoria);

        $tramite->fechaLiquidacion(new \DateTime());

        $em->flush();

        return new JsonResponse(array('status' => 'ok'));
    }
}
