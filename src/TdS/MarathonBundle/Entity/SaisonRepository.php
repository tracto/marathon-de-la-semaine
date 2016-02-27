<?php

namespace TdS\MarathonBundle\Entity;

/**
 * SaisonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SaisonRepository extends \Doctrine\ORM\EntityRepository{
	public function findAll()
    {
        return $this->findBy(array(), array('titre' => 'DESC'));
    }

    public function findLastOne(){
    	return $this->findBy(array(), array('activate' => 1));
    }
}
