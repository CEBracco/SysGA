<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movimiento
 *
 * @ORM\Table(name="movimiento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MovimientoRepository")
 */
class Movimiento
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
     * @ORM\Column(name="monto", type="decimal", precision=12, scale=4)
     */
    private $monto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;

    /**
    * @ORM\ManyToOne(targetEntity="Concesionaria")
    * @ORM\JoinColumn(name="concesionaria_id", referencedColumnName="id", nullable=false)
    */
    private $concesionaria;

    /**
    * @ORM\ManyToOne(targetEntity="RegistroDelAutomotor")
    * @ORM\JoinColumn(name="registrodelautomotor_id", referencedColumnName="id", nullable=true)
    */
    private $registroDelAutomotor;

    /**
    * @var \DateTime $deletedAt
    *
    * @ORM\Column(name="deleted_at", type="date", nullable=true)
    */
    private $deletedAt;

    /**
    * @var bool
    *
    * @ORM\Column(name="is_contramovimiento", type="boolean")
    */
    private $isContramovimiento;

    /**
     * @ORM\ManyToOne(targetEntity="Tramite", inversedBy="movimientos")
     * @ORM\JoinColumn(name="tramite_id", referencedColumnName="id", nullable=true)
     */
     private $tramite;

    function __construct() {
        $this->isContramovimiento=false;
        $this->contramovimiento=null;
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
     * Set monto
     *
     * @param string $monto
     *
     * @return Movimiento
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return string
     */
    public function getMonto()
    {
        return $this->monto;
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
     * Set tipo
     *
     * @param string $tipo
     *
     * @return Movimiento
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set concesionaria
     *
     * @param Concesionaria $concesionaria
     *
     * @return Movimiento
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
     * @return Movimiento
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
     * Set tramite
     *
     * @param Tramite $tramite
     *
     * @return Movimiento
     */
    public function setTramite($tramite)
    {
        $this->tramite = $tramite;

        return $this;
    }

    /**
     * Get tramite
     *
     * @return tramite
     */
    public function getTramite()
    {
        return $this->tramite;
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
     * Set isContramovimiento
     *
     * @param boolean $isContramovimiento
     *
     * @return Cooperativista
     */
    public function setIsContramovimiento($isContramovimiento){
        $this->isContramovimiento = $isContramovimiento;
        return $this;
    }

    /**
     * Get isContramovimiento
     *
     * @return bool
     */
    public function getIsContramovimiento(){
        return $this->isContramovimiento;
    }

    public function getTipoCanonical(){
        switch ($this->tipo) {
            case 1:
                return 'Entrada';
            case 2:
                return 'Salida';
            case 3:
                return 'Entrada en registro';
            case 4:
                return 'Salida en registro';
            default:
                return 'N/A';
        }
    }

    public function isMovimientoEnRegistro(){
        return ($this->tipo == 3 || $this->tipo == 4);
    }
}
