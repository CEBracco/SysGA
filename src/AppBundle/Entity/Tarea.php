<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use AppBundle\Entity\User;

/**
 * Tarea
 *
 * @ORM\Table(name="tarea")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TareaRepository")
 */
class Tarea
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
	 */
	 private $user;

	 /**
	 * @var bool
	 *
	 * @ORM\Column(name="realizada", type="boolean")
	 */
	 private $realizada;

	 function __construct() {
		 $this->realizada=false;
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Tarea
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
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Tarea
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Tarea
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

	/**
	 * Set user
	 *
	 * @param User $user
	 *
	 * @return Tarea
	 */
	public function setUser($user)
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * Get user
	 *
	 * @return user
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * Set realizada
	 *
	 * @param boolean $realizada
	 *
	 */
	public function setRealizada($realizada){
		$this->realizada = $realizada;
		return $this;
	}

	/**
	 * Get realizada
	 *
	 * @return bool
	 */
	public function getRealizada(){
		return $this->realizada;
	}
}
