<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Concesionaria
 *
 * @ORM\Table(name="concesionaria")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConcesionariaRepository")
 */
class Concesionaria
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="saldoDepositado", type="decimal", precision=12, scale=4, nullable=true)
     */
    private $saldoDepositado;

    /**
     * @var string
     *
     * @ORM\Column(name="saldoEnRegistro", type="decimal", precision=12, scale=4, nullable=true)
     */
    private $saldoEnRegistro;


    function __construct() {
        $this->saldoDepositado=0;
        $this->saldoEnRegistro=0;
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Concesionaria
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

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
     * Set saldoDepositado
     *
     * @param string $saldoDepositado
     *
     * @return Concesionaria
     */
    public function setSaldoDepositado($saldoDepositado)
    {
        $this->saldoDepositado = $saldoDepositado;

        return $this;
    }

    /**
     * Get saldoDepositado
     *
     * @return string
     */
    public function getSaldoDepositado()
    {
        return $this->saldoDepositado;
    }

    /**
     * Set saldoEnRegistro
     *
     * @param string $saldoEnRegistro
     *
     * @return Concesionaria
     */
    public function setSaldoEnRegistro($saldoEnRegistro)
    {
        $this->saldoEnRegistro = $saldoEnRegistro;

        return $this;
    }

    /**
     * Get saldoEnRegistro
     *
     * @return string
     */
    public function getSaldoEnRegistro()
    {
        return $this->saldoEnRegistro;
    }
}
