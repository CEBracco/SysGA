<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Estado;
use AppBundle\Entity\Movimiento;
use AppBundle\Entity\Titular;

/**
 * Tramite
 *
 * @ORM\Table(name="tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TramiteRepository")
 */
class Tramite
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoInternoConcesionaria", type="string", length=255, nullable=true)
     */
    private $codigoInternoConcesionaria;

    /**
     * @var string
     *
     * @ORM\Column(name="gastoArancel", type="decimal", precision=12, scale=4)
     */
    private $gastoArancel;

    /**
     * @var string
     *
     * @ORM\Column(name="impuestosPatente", type="decimal", precision=12, scale=4)
     */
    private $impuestosPatente;

    /**
     * @var string
     *
     * @ORM\Column(name="selladosGestoria", type="decimal", precision=12, scale=4)
     */
    private $selladosGestoria;

    /**
     * @var string
     *
     * @ORM\Column(name="selladosRegistro", type="decimal", precision=12, scale=4)
     */
    private $selladosRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="honorarios", type="decimal", precision=12, scale=4)
     */
    private $honorarios;

    /**
     * @var string
     *
     * @ORM\Column(name="otros", type="decimal", precision=12, scale=4)
     */
    private $otros;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="Concesionaria")
     * @ORM\JoinColumn(name="concesionaria_id", referencedColumnName="id", nullable=false)
     */
     private $concesionaria;

     /**
      * @ORM\ManyToOne(targetEntity="RegistroDelAutomotor")
      * @ORM\JoinColumn(name="registrodelautomotor_id", referencedColumnName="id", nullable=false)
      */
      private $registroDelAutomotor;

     /**
      * @ORM\ManyToOne(targetEntity="Titular", cascade={"persist"})
      * @ORM\JoinColumn(name="titular_id", referencedColumnName="id", nullable=false)
      */
      private $titular;

     /**
      * @ORM\ManyToOne(targetEntity="Estado", cascade={"persist", "remove"})
      * @ORM\JoinColumn(name="estado_id", referencedColumnName="id", nullable=true)
      */
      private $estadoActual;

     /**
      * @ORM\OneToMany(targetEntity="Estado", mappedBy="tramite", cascade={"persist", "remove"})
      */
     private $estados;

	 /**
	  * @ORM\OneToMany(targetEntity="Movimiento", mappedBy="tramite", cascade={"persist", "remove"})
	  */
	 private $movimientos;

     /**
     * @var \DateTime $deletedAt
     *
     * @ORM\Column(name="deleted_at", type="date", nullable=true)
     */
     private $deletedAt;

    /**
    * @var \DateTime $deletedAt
    *
    * @ORM\Column(name="fechaLiquidacion", type="date", nullable=true)
    */
    private $fechaLiquidacion;

    function __construct() {
        $this->gastoArancel=0;
        $this->impuestosPatente=0;
        $this->selladosGestoria=0;
        $this->selladosRegistro=0;
        $this->honorarios=0;
        $this->otros=0;
        $this->estados = new ArrayCollection();
        $this->addEstado(new Estado('Pendiente'));
		$this->movimientos = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set gastoArancel
     *
     * @param string $gastoArancel
     *
     * @return Tramite
     */
    public function setGastoArancel($gastoArancel)
    {
        $this->gastoArancel = $gastoArancel;

        return $this;
    }

    /**
     * Get gastoArancel
     *
     * @return string
     */
    public function getGastoArancel()
    {
        return $this->gastoArancel;
    }

    /**
     * Set impuestosPatente
     *
     * @param string $impuestosPatente
     *
     * @return Tramite
     */
    public function setImpuestosPatente($impuestosPatente)
    {
        $this->impuestosPatente = $impuestosPatente;

        return $this;
    }

    /**
     * Get impuestosPatente
     *
     * @return string
     */
    public function getImpuestosPatente()
    {
        return $this->impuestosPatente;
    }

    /**
     * Set selladosGestoria
     *
     * @param string $selladosGestoria
     *
     * @return Tramite
     */
    public function setSelladosGestoria($selladosGestoria)
    {
        $this->selladosGestoria = $selladosGestoria;

        return $this;
    }

    /**
     * Get selladosGestoria
     *
     * @return string
     */
    public function getSelladosGestoria()
    {
        return $this->selladosGestoria;
    }

    /**
     * Set selladosRegistro
     *
     * @param string $selladosRegistro
     *
     * @return Tramite
     */
    public function setSelladosRegistro($selladosRegistro)
    {
        $this->selladosRegistro = $selladosRegistro;

        return $this;
    }

    /**
     * Get selladosRegistro
     *
     * @return string
     */
    public function getSelladosRegistro()
    {
        return $this->selladosRegistro;
    }

    /**
     * Set honorarios
     *
     * @param string $honorarios
     *
     * @return Tramite
     */
    public function setHonorarios($honorarios)
    {
        $this->honorarios = $honorarios;

        return $this;
    }

    /**
     * Get honorarios
     *
     * @return string
     */
    public function getHonorarios()
    {
        return $this->honorarios;
    }

    /**
     * Set otros
     *
     * @param string $otros
     *
     * @return Tramite
     */
    public function setOtros($otros)
    {
        $this->otros = $otros;

        return $this;
    }

    /**
     * Get otros
     *
     * @return string
     */
    public function getOtros()
    {
        return $this->otros;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Movimiento
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return Movimiento
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set fechaLiquidacion
     *
     * @param \DateTime $fechaLiquidacion
     *
     * @return Movimiento
     */
    public function setFechaLiquidacion($fechaLiquidacion)
    {
        $this->fechaLiquidacion = $fechaLiquidacion;

        return $this;
    }

    /**
     * Get fechaLiquidacion
     *
     * @return \DateTime
     */
    public function getFechaLiquidacion()
    {
        return $this->fechaLiquidacion;
    }

    /**
     * Set estadoActual
     *
     * @param Estado $estadoActual
     *
     * @return Tramite
     */
    public function setEstadoActual($estado)
    {
        $this->estadoActual = $estado;

        return $this;
    }

    /**
     * Get estadoActual
     *
     * @return estadoActual
     */
    public function getEstadoActual()
    {
        return $this->estadoActual;
    }

    /**
     * Set concesionaria
     *
     * @param Concesionaria $concesionaria
     *
     * @return Tramite
     */
    public function setConcesionaria($concesionaria)
    {
        $this->concesionaria = $concesionaria;

        return $this;
    }

    /**
     * Get concesionaria
     *
     * @return concesionaria
     */
    public function getConcesionaria()
    {
        return $this->concesionaria;
    }

    /**
     * Set registroDelAutomotor
     *
     * @param RegistroDelAutomotor $registroDelAutomotor
     *
     * @return Tramite
     */
    public function setRegistroDelAutomotor($registroDelAutomotor)
    {
        $this->registroDelAutomotor = $registroDelAutomotor;

        return $this;
    }

    /**
     * Get registroDelAutomotor
     *
     * @return registroDelAutomotor
     */
    public function getRegistroDelAutomotor()
    {
        return $this->registroDelAutomotor;
    }

    /**
     * Set titular
     *
     * @param Titular $titular
     *
     * @return Tramite
     */
    public function setTitular($titular)
    {
        $this->titular = $titular;

        return $this;
    }

    /**
     * Get titular
     *
     * @return titular
     */
    public function getTitular()
    {
        return $this->titular;
    }

    /**
     * Set codigoInternoConcesionaria
     *
     * @param string $codigoInternoConcesionaria
     *
     * @return Tramite
     */
    public function setCodigoInternoConcesionaria($codigoInternoConcesionaria)
    {
        $this->codigoInternoConcesionaria = $codigoInternoConcesionaria;

        return $this;
    }

    /**
     * Get codigoInternoConcesionaria
     *
     * @return string
     */
    public function getCodigoInternoConcesionaria()
    {
        return $this->codigoInternoConcesionaria;
    }

    /**
     * Set estados
     *
     * @param \Doctrine\Common\Collections\Collection $estados
     *
     * @return Tramite
     */
    public function setEstados($estados)
    {
        $this->estados = $estados;

        return $this;
    }

    /**
     * Get estados
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEstados(){
        return $this->estados;
    }

    /**
     * Add estado
     *
     * @param \AppBundle\Entity\Estado $estado
     *
     * @return Delegacion
     */
    public function addEstado(Estado $estado){
        $estado->setTramite($this);
        $this->estados[] = $estado;
        $this->estadoActual = $estado;
        return $this;
    }

    /**
     * Remove estado
     *
     * @param \AppBundle\Entity\Estado $estado
     */
    public function removeEstado(Estado $estado){
        $this->estadoActual=null;
        $this->estados->removeElement($estado);
    }

	/**
     * Set movimientos
     *
     * @param \Doctrine\Common\Collections\Collection $movimientos
     *
     * @return Tramite
     */
    public function setMovimientos($movimientos)
    {
        $this->movimientos = $movimientos;

        return $this;
    }

    /**
     * Get movimientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovimientos(){
        return $this->movimientos;
    }

    /**
     * Add movimiento
     *
     * @param \AppBundle\Entity\Movimiento $movimiento
     *
     * @return Delegacion
     */
    public function addMovimiento(Movimiento $movimiento){
        $movimiento->setTramite($this);
        $this->movimientos[] = $movimiento;
        return $this;
    }

    /**
     * Remove movimiento
     *
     * @param \AppBundle\Entity\Movimiento $movimiento
     */
    public function removeMovimiento(Movimiento $movimiento){
        $this->movimientos->removeElement($movimiento);
    }

    public function getTotalEnRegistro(){
        return $this->gastoArancel + $this->impuestosPatente + $this->selladosRegistro;
    }

    public function getTotalGestoria(){
        return $this->selladosGestoria + $this->honorarios + $this->otros;
    }

	public function doDepositoEnRegistro($monto){
		$this->doDeposito($monto,3,$this->getRegistroDelAutomotor());
	}

	public function doDepositoGestoria($monto){
		$this->doDeposito($monto,1,null);
	}

	private function doDeposito($monto, $tipo, $registroDelAutomotor){
		if($monto != 0){
			$deposito = new Movimiento();
			$deposito->setMonto($monto);
			$deposito->setConcesionaria($this->getConcesionaria());
			$deposito->setRegistroDelAutomotor($registroDelAutomotor);
			$deposito->setFecha(new \DateTime());
			$deposito->setTipo($tipo);

			$this->aplicarMonto($deposito);
			$this->addMovimiento($deposito);
		}
	}

	public function liquidate(){
		$montoTramiteEnRegistro=$this->getTotalEnRegistro() - $this->getTotalLiquidadoEnRegistro();
		if($montoTramiteEnRegistro != 0){
		    $movimientoEnRegistro = new Movimiento();
		    $movimientoEnRegistro->setMonto($montoTramiteEnRegistro);
		    $movimientoEnRegistro->setConcesionaria($this->getConcesionaria());
		    $movimientoEnRegistro->setRegistroDelAutomotor($this->getRegistroDelAutomotor());
		    $movimientoEnRegistro->setFecha(new \DateTime());
		    $movimientoEnRegistro->setTipo(4);

			$this->aplicarMonto($movimientoEnRegistro);
			$this->addMovimiento($movimientoEnRegistro);
		}

		$montoTramiteGestoria=$this->getTotalGestoria() - $this->getTotalLiquidadoGestoria();
		if($montoTramiteGestoria != 0){
		    $movimientoGestoria = new Movimiento();
		    $movimientoGestoria->setMonto($montoTramiteGestoria);
		    $movimientoGestoria->setConcesionaria($this->getConcesionaria());
		    $movimientoGestoria->setFecha(new \DateTime());
		    $movimientoGestoria->setTipo(2);

			$this->aplicarMonto($movimientoGestoria);
			$this->addMovimiento($movimientoGestoria);
		}
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

	private function getTotalLiquidadoEnRegistro(){
		return $this->getTotalByTipo(4);
	}

	private function getTotalLiquidadoGestoria(){
		return $this->getTotalByTipo(2);
	}

	private function getTotalByTipo($tipo){
		$total=0;
		foreach ($this->getMovimientos() as $movimiento) {
			if($movimiento->getTipo() == $tipo && $movimiento->getDeletedAt() == null){
				$total=$total+$movimiento->getMonto();
			}
		}
		return $total;
	}

	public function getTotalDepositadoEnRegistro(){
		return $this->getTotalByTipo(3);
	}

	public function getTotalDepositadoGestoria(){
		return $this->getTotalByTipo(1);
	}
}
