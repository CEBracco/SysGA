<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estado
 *
 * @ORM\Table(name="estado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EstadoRepository")
 */
class Estado
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
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text", nullable=true)
     */
    private $observacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
	 * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Tramite", inversedBy="estados")
	 * @ORM\JoinColumn(name="tramite_id", referencedColumnName="id", nullable=false)
	 */
    private $tramite;

    function __construct($estado) {
        $this->estado=$estado;
        $this->fecha=new \DateTime();
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
     * Set observacion
     *
     * @param string $observacion
     *
     * @return Estado
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Estado
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
     * @return Estado
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
     * Set tramite
     *
     * @param Tramite $tramite
     *
     * @return Tramite
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
}
