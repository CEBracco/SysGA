<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RegistroDelAutomotor
 *
 * @ORM\Table(name="registro_del_automotor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegistroDelAutomotorRepository")
 */
class RegistroDelAutomotor
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
     * @return RegistroDelAutomotor
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
	
	public function serialize(){
		$data = array(
			'id' => $this->getId(),
			'nombre' => $this->getNombre()
		);

		return json_encode($data);
	}
}
