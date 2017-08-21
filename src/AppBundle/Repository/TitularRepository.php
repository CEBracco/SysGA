<?php

namespace AppBundle\Repository;

/**
 * TitularRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TitularRepository extends \Doctrine\ORM\EntityRepository
{
	public function search($value){
		$cb = $this->createQueryBuilder('t');

		$cb->where('LOWER(t.nombre) LIKE :valueNombre')
			->setParameter('valueNombre', '%'.$value.'%')
			->orWhere('LOWER(t.apellido) LIKE :valueApellido')
			->setParameter('valueApellido', '%'.$value.'%')
			->orWhere('t.dni LIKE :valueDni')
			->setParameter('valueDni', '%'.$value.'%');

		$query=$cb->getQuery();
		return $query->getResult();
	}

	public function searchInConcesionaria($value,$concesionaria){
		$em = $this->getEntityManager();
		$query = $em->createQuery('SELECT t
									from AppBundle:Titular t
									where t in (select IDENTITY(tramite.titular)
												from AppBundle:Tramite tramite join tramite.concesionaria concesionaria
												where concesionaria = :concesionaria)
											and (t.nombre LIKE :valueNombre OR t.apellido LIKE :valueApellido or t.dni LIKE :valueDni)');

		$query->setParameter('concesionaria', $concesionaria);
		$query->setParameter('valueNombre', '%'.$value.'%');
		$query->setParameter('valueApellido', '%'.$value.'%');
		$query->setParameter('valueDni', '%'.$value.'%');

		return $query->getResult();
	}
}
