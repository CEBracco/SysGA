<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}

