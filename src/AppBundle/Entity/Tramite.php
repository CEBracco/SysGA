<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Estado;
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
     * @ORM\Column(name="sellados", type="decimal", precision=12, scale=4)
     */
    private $sellados;

    /**
     * @var string
     *
     * @ORM\Column(name="honorarios", type="decimal", precision=12, scale=4)
     */
    private $honorarios;

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
        $this->sellados=0;
        $this->honorarios=0;
        $this->estados = new ArrayCollection();
        $this->addEstado(new Estado('Pendiente'));
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
     * Set sellados
     *
     * @param string $sellados
     *
     * @return Tramite
     */
    public function setSellados($sellados)
    {
        $this->sellados = $sellados;

        return $this;
    }

    /**
     * Get sellados
     *
     * @return string
     */
    public function getSellados()
    {
        return $this->sellados;
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

    public function getTotalEnRegistro(){
        return $this->gastoArancel + $this->impuestosPatente;
    }

    public function getTotalGestoria(){
        return $this->sellados + $this->honorarios;
    }
}
