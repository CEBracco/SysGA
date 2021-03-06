<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tramite;
use AppBundle\Entity\Movimiento;
use AppBundle\Entity\Estado;
use AppBundle\Entity\Titular;
use AppBundle\Entity\Provincia;
use AppBundle\Entity\Gasto;
use AppBundle\Entity\Deposito;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();

		$codigoInternoConcesionaria=$toDate=$request->request->get('codigoInternoConcesionaria','');

		$fromDate=\DateTime::createFromFormat('!d/m/Y',$request->request->get('fromDate',''));
		$toDate=\DateTime::createFromFormat('!d/m/Y',$request->request->get('toDate',''));

		if ($this->getUser()->getRol() != 'ROLE_CONCESIONARIA'){
			$concesionarias=$em->getRepository('AppBundle:Concesionaria')->findAll();
			$concesionaria=$request->request->get('concesionaria','');
		}
		else{
			$concesionarias=array();
			$concesionaria=$this->getUser()->getConcesionaria()->getId();
		}

		$titularString='';
		$titular=$request->request->get('titular','');
		if($titular != ''){
			$titularEntity=$em->getRepository('AppBundle:Titular')->find($titular);
			$titularString=$titularEntity->getNombre().' '.$titularEntity->getApellido().' ('.$titularEntity->getDni().')';
		}

		$estado=$request->request->get('estado','');
		$filter=$this->getFilter($codigoInternoConcesionaria,$fromDate,$toDate,$concesionaria,$titular,$estado);

		$tramites= $this->listTramites($filter);
        return $this->render('tramite/index.html.twig', array(
            'tramites' => $tramites,
			'concesionarias' => $concesionarias,
			'estados' => $this->getEstados(),
			'filtroAplicado' => !empty($filter),
			'filtro' => array(
							'fromDate' => $request->request->get('fromDate',''),
							'toDate' => $request->request->get('toDate',''),
							'concesionaria' => $concesionaria,
							'titular' => $titular,
							'titularString' => $titularString,
							'estado' => $estado,
							'codigoInternoConcesionaria' => $codigoInternoConcesionaria,
						)
        ));
    }

	private function getFilter($codigoInternoConcesionaria,$fromDate,$toDate,$concesionaria,$titular,$estado){
		$filter=array();
		if(!empty($codigoInternoConcesionaria)){
			$filter['codigoInternoConcesionaria']=$codigoInternoConcesionaria;
		}
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
		if(!empty($estado)){
			$filter['estado']=$estado;
		}
		return $filter;
	}

	private function listTramites($filter){
		// var_dump($filter);
		$em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:Tramite')->findByFilter($filter);
	}

    /**
     * Creates a new tramite entity.
     *
     * @Route("/new", name="tramite_new")
     * @Method({"GET", "POST"})
	 * @Security("has_role('ROLE_GESTION')")
     */
    public function newAction(Request $request)
    {
        $tramite = new Tramite();
        $form = $this->createForm('AppBundle\Form\TramiteType', $tramite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			$dniTitular = $form->get('dniTitular')->getData();
            $nombreTitular = $form->get('nombreTitular')->getData();
            $apellidoTitular = $form->get('apellidoTitular')->getData();
            $provinciaTitular = $form->get('provinciaTitular')->getData();
			$gastosAdicionalesNuevosJSON = $form->get('gastosAdicionalesNuevos')->getData();
			$depositoEnRegistro = $form->get('depositoEnRegistro')->getData();
			//$depositoGestoria = $form->get('depositoGestoria')->getData();

            $tramite->setTitular($this->getTitular($dniTitular,$nombreTitular,$apellidoTitular,$provinciaTitular));

			$gastosAdicionalesNuevos=$this->parseGastos($gastosAdicionalesNuevosJSON);
			$tramite->addGastosAdicionales($gastosAdicionalesNuevos);

			$tramite->doDepositoEnRegistro($depositoEnRegistro);
			//$tramite->doDepositoGestoria($depositoGestoria);
			$tramite->liquidate();

            $em = $this->getDoctrine()->getManager();
            $em->persist($tramite);
            $em->flush();

            return $this->redirectToRoute('tramite_index');
        }

		$registrosDelAutomotor = $this->getSerializedRegistrosDelAutomotor();

        return $this->render('tramite/form.html.twig', array(
            'tramite' => $tramite,
            'form' => $form->createView(),
			'registrosDelAutomotor' => $registrosDelAutomotor,
        ));
    }

    /**
     * Displays a form to edit an existing tramite entity.
     *
     * @Route("/{id}/edit", name="tramite_edit")
     * @Method({"GET", "POST"})
	 * @Security("has_role('ROLE_GESTION')")
     */
    public function editAction(Request $request, Tramite $tramite)
    {
        $editForm = $this->createForm('AppBundle\Form\TramiteType', $tramite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
			$dniTitular = $editForm->get('dniTitular')->getData();
            $nombreTitular = $editForm->get('nombreTitular')->getData();
            $apellidoTitular = $editForm->get('apellidoTitular')->getData();
            $provinciaTitular = $editForm->get('provinciaTitular')->getData();
			$gastosAdicionalesNuevosJSON = $editForm->get('gastosAdicionalesNuevos')->getData();
			$depositoEnRegistro = $editForm->get('depositoEnRegistro')->getData();
			//$depositoGestoria = $editForm->get('depositoGestoria')->getData();

            $tramite->setTitular($this->getTitular($dniTitular,$nombreTitular,$apellidoTitular,$provinciaTitular));

			$gastosAdicionalesNuevos=$this->parseGastos($gastosAdicionalesNuevosJSON);
			$tramite->addGastosAdicionales($gastosAdicionalesNuevos);

			$tramite->doDepositoEnRegistro($depositoEnRegistro);
			//$tramite->doDepositoGestoria($depositoGestoria);
			$tramite->liquidate();

			$em=$this->getDoctrine()->getManager();
			$em->flush();

			return $this->redirectToRoute('tramite_edit', array('id' => $tramite->getId(),'status' => 'ok'));

			// return $this->render('tramite/form.html.twig', array(
			// 	'tramite' => $tramite,
			// 	'form' => $editForm->createView(),
			// 	'edit' => true,
			// 	'estados' => $this->getEstados(),
			// 	'msg' => "lalala",
			// ));
		}

		$msg=null;
		if($request->query->get('status') == 'ok'){
			$msg="Los cambios han sido guardados";
		}
		
		$registrosDelAutomotor = $this->getSerializedRegistrosDelAutomotor();

		return $this->render('tramite/form.html.twig', array(
			'tramite' => $tramite,
			'form' => $editForm->createView(),
			'edit' => true,
			'estados' => $this->getEstados(),
			'msg' => $msg,
			'registrosDelAutomotor' => $registrosDelAutomotor,
		));
    }

	private function parseGastos($gastosAdicionalesJSON){
		$gastosAdicionalesDTO=json_decode($gastosAdicionalesJSON,true);

		$gastosAdicionales=array();
		if($gastosAdicionalesDTO != null){
			foreach ($gastosAdicionalesDTO as $gastoAdicionalDTO) {
				$gastosAdicionales[]=Gasto::enGestoria($gastoAdicionalDTO['concepto'],$gastoAdicionalDTO['monto'],$gastoAdicionalDTO['isDiferencia']);
			}
		}
		return $gastosAdicionales;
	}

	/**
	 *
	 * @Route("/{id}/removeDeposito", name="remove_deposito_tramite")
	 * @Method("POST")
	 * @Security("has_role('ROLE_GESTION')")
	 */
	public function removeDepositoAction(Request $request, Deposito $deposito){
		if($deposito->getTramite()->getRestoRegistroTrasferidoAGestoria() == null){
			$em = $this->getDoctrine()->getManager();
			$em->remove($deposito);
			$em->flush();
			return new JsonResponse(array('status' => 'ok'));
		}
		return new JsonResponse(array('status' => 'error'));
	}

	/**
	 *
	 * @Route("/{id}/removeGasto", name="remove_gasto_tramite")
	 * @Method("POST")
	 * @Security("has_role('ROLE_GESTION')")
	 */
	public function removeGastoAdicionalAction(Request $request, Gasto $gastoAdicional){
		$em = $this->getDoctrine()->getManager();
		$em->remove($gastoAdicional);
		$em->flush();
		return new JsonResponse(array('status' => 'ok'));
	}


    /**
     * Deletes a tramite entity.
     *
     * @Route("/{id}/delete", name="tramite_delete")
     * @Method("GET")
	 * @Security("has_role('ROLE_GESTION')")
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
	 * @Security("has_role('ROLE_GESTION')")
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

	/**
	 * Agrega un nuevo estado al tramite recibido por parametro
	 *
	 * @Route("/{id}/addResto", name="tramite_addResto")
	 * @Method({"POST"})
	 * @Security("has_role('ROLE_GESTION')")
	 */
	public function addRestoAction(Request $request, Tramite $tramite)
	{
		$tramite->addRestoRegistroAGestoria();

		$em = $this->getDoctrine()->getManager();
		$em->flush();

		return new JsonResponse(array('status' => 'ok'));
	}

    private function getTitular($dni, $nombre, $apellido, Provincia $provincia){
        $em = $this->getDoctrine()->getManager();
        // $titular = $em->getRepository('AppBundle:Titular')->findOneBy(array(
        //     'nombre' => mb_strtolower($nombre,'UTF-8'),
        //     'apellido' => mb_strtolower($apellido,'UTF-8'),
        //     'provincia' => $provincia
        // ));

		$titular = $em->getRepository('AppBundle:Titular')->findOneByDni($dni);
        if($titular == null){
            $titular=new Titular($nombre);
		}

		$titular->setDni($dni);
        $titular->setNombre($nombre);
        $titular->setApellido($apellido);
        $titular->setProvincia($provincia);

        return $titular;
    }

	private function getEstados(){
		return [
			"Pendiente",
			"Presentado",
			"Observado",
			"Reingresado",
			"Retirado",
			"Enviado",
		];
	}
	
	private function getSerializedRegistrosDelAutomotor(){
		$registrosDelAutomotor = $this->getDoctrine()->getManager()->getRepository('AppBundle:RegistroDelAutomotor')->findAll();
		
		$normalizer = new ObjectNormalizer();
		$encoder = new JsonEncoder();

		$serializer = new Serializer(array($normalizer), array($encoder));
		$content=$serializer->serialize($registrosDelAutomotor, 'json');
		return $content;
	}
}
