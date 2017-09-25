<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Deposito
 *
 * @ORM\Table(name="deposito")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DepositoRepository")
 */
class Deposito
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
     * @ORM\ManyToOne(targetEntity="Tramite", inversedBy="depositos")
     * @ORM\JoinColumn(name="tramite_id", referencedColumnName="id")
     */
     private $tramite;

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
     * @return Deposito
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
     * @return Deposito
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
}
