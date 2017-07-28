<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Estado;

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
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

    /**
     * @ORM\ManyToOne(targetEntity="Concesionaria")
     * @ORM\JoinColumn(name="concesionaria_id", referencedColumnName="id", nullable=false)
     */
     private $concesionaria;

     /**
      * @ORM\OneToMany(targetEntity="Estado", mappedBy="tramite", cascade={"persist", "remove"})
      */
     private $estados;

    function __construct() {
        $this->gastoArancel=0;
        $this->impuestosPatente=0;
        $this->sellados=0;
        $this->honorarios=0;
        $this->estado="Pendiente";
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
     * Set estado
     *
     * @param string $estado
     *
     * @return Tramite
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
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
        return $this;
    }

    /**
     * Remove estado
     *
     * @param \AppBundle\Entity\Estado $estado
     */
    public function removeEstado(Estado $estado){
        $this->estados->removeElement($estado);
    }
}
