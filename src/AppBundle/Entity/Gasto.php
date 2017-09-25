<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gasto
 *
 * @ORM\Table(name="gasto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GastoRepository")
 */
class Gasto
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
     * @ORM\Column(name="concepto", type="string", length=255)
     */
    private $concepto;

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal", precision=12, scale=4)
     */
    private $monto;

	/**
	 * @ORM\ManyToOne(targetEntity="Tramite", inversedBy="gastosAdicionales")
	 * @ORM\JoinColumn(name="tramite_id", referencedColumnName="id")
	 */
	 private $tramite;

	 /**
	 * @var bool
	 *
	 * @ORM\Column(name="isgastoenregistro", type="boolean")
	 */
	 private $isGastoEnRegistro;


	function __construct($concepto,$monto) {
		$this->isGastoEnRegistro=false;
		$this->monto=$monto;
		$this->concepto=$concepto;
	}

	public static function enGestoria($concepto,$monto)
	{
		$gasto=new Gasto($concepto,$monto);
		$gasto->setIsGastoEnRegistro(false);
		return $gasto;
	}

	public static function enRegistro($concepto,$monto)
	{
		$gasto=new Gasto($concepto,$monto);
		$gasto->setIsGastoEnRegistro(true);
		return $gasto;
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
     * Set concepto
     *
     * @param string $concepto
     *
     * @return Gasto
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return string
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set monto
     *
     * @param string $monto
     *
     * @return Gasto
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
	 * Set tramite
	 *
	 * @param Tramite $tramite
	 *
	 * @return Gasto
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
	 * Set isGastoEnRegistro
	 *
	 * @param boolean $isGastoEnRegistro
	 *
	 * @return Gasto
	 */
	public function setIsGastoEnRegistro($isGastoEnRegistro){
		$this->isGastoEnRegistro = $isGastoEnRegistro;
		return $this;
	}

	/**
	 * Get isGastoEnRegistro
	 *
	 * @return bool
	 */
	public function getIsGastoEnRegistro(){
		return $this->isGastoEnRegistro;
	}

	public function toArray(){
		return array('concepto' => $this->concepto, 'monto' => $this->monto);
	}
}
