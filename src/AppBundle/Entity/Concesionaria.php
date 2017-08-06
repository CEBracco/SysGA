<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Cuenta;
use AppBundle\Entity\RegistroDelAutomotor;
use AppBundle\Entity\Movimiento;

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
     * @ORM\OneToMany(targetEntity="Cuenta", mappedBy="concesionaria", cascade={"persist", "remove"})
     */
    private $cuentas;


    function __construct() {
        $this->saldoDepositado=0;
        $this->cuentas = new ArrayCollection();
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
     * Set cuentas
     *
     * @param \Doctrine\Common\Collections\Collection $cuentas
     *
     * @return Concesionaria
     */
    public function setCuentas($cuentas)
    {
        $this->cuentas = $cuentas;

        return $this;
    }

    /**
     * Get cuentas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCuentas(){
        return $this->cuentas;
    }

    /**
     * Add cuenta
     *
     * @param \AppBundle\Entity\Cuenta $cuenta
     *
     * @return Concesionaria
     */
    public function addCuenta(Cuenta $cuenta){
        $cuenta->setConcesionaria($this);
        $this->cuentas[] = $cuenta;
        return $this;
    }

    /**
     * Remove cuenta
     *
     * @param \AppBundle\Entity\Cuenta $cuenta
     */
    public function removeCuenta(Cuenta $cuenta){
        $this->cuentas->removeElement($cuenta);
    }

    public function findCuentaRegistroDelAutomotor(RegistroDelAutomotor $registroDelAutomotor){
        $result=null;
        foreach ($this->cuentas as $cuenta) {
            if($cuenta->getRegistroDelAutomotor() == $registroDelAutomotor){
                $result=$cuenta;
                break;
            }
        }
        if($result == null){
            $result= new Cuenta();
            $result->setRegistroDelAutomotor($registroDelAutomotor);
            $this->addCuenta($result);
        }

        return $result;
    }

    public function efectuarEntrada(Movimiento $movimiento){
        $cuenta=$this->findCuentaRegistroDelAutomotor($movimiento->getRegistroDelAutomotor());
        $cuenta->efectuarEntrada($movimiento);
    }

    public function efectuarSalida(Movimiento $movimiento){
        $cuenta=$this->findCuentaRegistroDelAutomotor($movimiento->getRegistroDelAutomotor());
        $cuenta->efectuarSalida($movimiento);
    }
}
