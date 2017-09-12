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
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getManager();

		$fromDate=\DateTime::createFromFormat('!d/m/Y',$request->request->get('fromDate',''));
		$toDate=\DateTime::createFromFormat('!d/m/Y',$request->request->get('toDate',''));

		$concesionarias=$em->getRepository('AppBundle:Concesionaria')->findAll();
		$concesionaria=$request->request->get('concesionaria','');

		$titularString='';
		$titular=$request->request->get('titular','');
		if($titular != ''){
			$titularEntity=$em->getRepository('AppBundle:Titular')->find($titular);
			$titularString=$titularEntity->getNombre().' '.$titularEntity->getApellido().' ('.$titularEntity->getDni().')';
		}

		$tipo=$request->request->get('tipo','');
		$filter=$this->getFilter($fromDate,$toDate,$concesionaria,$titular,$tipo);

		$movimientos= $this->listMovimientos($filter);

        return $this->render('movimiento/index.html.twig', array(
            'movimientos' => $movimientos,
			'concesionarias' => $concesionarias,
			'filtro' => array(
							'fromDate' => $request->request->get('fromDate',''),
							'toDate' => $request->request->get('toDate',''),
							'concesionaria' => $concesionaria,
							'titular' => $titular,
							'titularString' => $titularString,
							'tipo' => $tipo
						)
        ));
    }

	private function getFilter($fromDate,$toDate,$concesionaria,$titular,$tipo){
		$filter=array();
		if(!empty($fromDate)){
			$filter['fromDate']=$fromDate;
		}
		if(!empty($toDate)){
			$filter['toDate']=$toDate;
		}
		if(!empty($concesionaria)){
			$filter['concesionaria']=$concesionaria;
		}
		if(!empty($titular)){
			$filter['titular']=$titular;
		}
		if(!empty($tipo)){
			$filter['tipo']=$tipo;
		}
		return $filter;
	}

	private function listMovimientos($filter){
		// var_dump($filter);
		$em = $this->getDoctrine()->getManager();
		return $em->getRepository('AppBundle:Movimiento')->findByFilter($filter);
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
            if(!$movimiento->isMovimientoEnRegistro()){
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

}
