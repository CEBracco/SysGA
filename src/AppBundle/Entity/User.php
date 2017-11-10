<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * User
 * @ORM\Table(name="user")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email", column=@ORM\Column(type="string", name="email", length=255, unique=false, nullable=true)),
 *      @ORM\AttributeOverride(name="emailCanonical", column=@ORM\Column(type="string", name="email_canonical", length=255, unique=false, nullable=true))
 * })
 * @ORM\Entity
 */
class User extends BaseUser{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

   /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=50, nullable=true)
     */
    private $apellido;

	/**
     * @ORM\ManyToOne(targetEntity="Concesionaria")
     * @ORM\JoinColumn(name="concesionaria_id", referencedColumnName="id", nullable=true)
     */
     private $concesionaria;

	/**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return User
     */
    public function setNombre($nombre){
        $this->nombre = $nombre;
        return $this;
    }


    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre(){
		return $this->nombre;
    }


    /**
     * Set apellido
     *
     * @param string $apellido
     *
     * @return User
     */
    public function setApellido($apellido){
        $this->apellido = $apellido;
        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido(){
		return $this->apellido;
    }
	/*
    public function __construct(){
        parent::__construct();
    }
	*/

	public function setRol($rol){
		$this->addRole($rol);
	}

	public function getRol(){
		return $this->getRoles()[0];
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

    /**
     * Set concesionaria
     *
     * @param Concesionaria $concesionaria
     *
     * @return User
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

	public function serializar(){
		return array(
			'id' => $this->getId(),
			'apellido' => $this->getApellido(),
			'nombre' => $this->getNombre(),
			'rol' => $this->getRol(),
			'username' => $this->getUsername());
	}

	public function serializarJSON(){
		return json_encode($this->serializar(),true);
	}

	function getRolAImprimir(){
		$rol = $this->getRol();
		switch($rol){
			case "ROLE_SUPER_ADMIN": return "Super-Admin";
			case "ROLE_ADMIN": return "Administrador";
			case "ROLE_GESTION": return "Gestión";
			case "ROLE_CONCESIONARIA": return "Concesionaria";
			default: throw new \Exception("El rol '$rol' no tiene una entrada en el switch del método getRolAImprimir() de la clase User");
		}
	}

	function getNivelDeJerarquia(){ //Se usa para ordenar a los usuarios en un listado segun su jerarquia
		$rol = $this->getRol();
		switch($rol){
			case "ROLE_SUPER_ADMIN": return 4;
			case "ROLE_ADMIN": return 3;
			case "ROLE_GESTION": return 2;
			case "ROLE_CONCESIONARIA": return 1;
			default: throw new \Exception("El rol '$rol' no tiene una entrada en el switch del método getNivelDeJerarquia() de la clase User");
		}
	}

	function toString(){
		return $this->getNombre()." ".$this->getApellido()." (".$this->getUsername().") -- ".$this->getRolAImprimir();
	}
}
