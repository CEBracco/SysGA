<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cuenta
 *
 * @ORM\Table(name="cuenta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CuentaRepository")
 */
class Cuenta
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
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Concesionaria", inversedBy="cuentas")
     * @ORM\JoinColumn(name="concesionaria_id", referencedColumnName="id", nullable=false)
     */
    private $concesionaria;

    /**
    * @ORM\ManyToOne(targetEntity="RegistroDelAutomotor")
    * @ORM\JoinColumn(name="registrodelautomotor_id", referencedColumnName="id", nullable=false)
    */
    private $registroDelAutomotor;

    /**
     * @var string
     *
     * @ORM\Column(name="saldo", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $saldo;

    function __construct() {
        $this->saldo=0;
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
     * Set concesionaria
     *
     * @param Concesionaria $concesionaria
     *
     * @return Cuenta
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
     * @return Cuenta
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
     * Set saldo
     *
     * @param string $saldo
     *
     * @return Cuenta
     */
    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;

        return $this;
    }

    /**
     * Get saldo
     *
     * @return string
     */
    public function getSaldo()
    {
        return $this->saldo;
    }

    public function efectuarEntrada($movimiento){
        $this->saldo = $this->saldo + $movimiento->getMonto();
    }

    public function efectuarSalida($movimiento){
        $this->saldo = $this->saldo - $movimiento->getMonto();
    }
}
