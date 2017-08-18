<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Titular
 *
 * @ORM\Table(name="titular")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TitularRepository")
 */
class Titular
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
     * @ORM\Column(name="dni", type="string", length=15, nullable=true, unique=true)
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=255)
     */
    private $apellido;

    /**
     * @ORM\ManyToOne(targetEntity="Provincia")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id", nullable=false)
     */
     private $provincia;

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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Titular
     */
    public function setNombre($nombre)
    {
        $this->nombre = mb_strtolower($nombre,'UTF-8');

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Titular
     */
    public function setApellido($apellido)
    {
        $this->apellido = mb_strtolower($apellido,'UTF-8');

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set provincia
     *
     * @param Provincia $provincia
     *
     * @return Titular
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return provincia
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

	/**
	 * Set dni
	 *
	 * @param string $dni
	 *
	 * @return Titular
	 */
	public function setDni($dni)
	{
		$this->dni = $dni;

		return $this;
	}

	/**
	 * Get dni
	 *
	 * @return dni
	 */
	public function getDni()
	{
		return $this->dni;
	}

	public function toString(){
		return $this->nombre.' '.$this->apellido.'('.$this->dni.')';
	}
}
