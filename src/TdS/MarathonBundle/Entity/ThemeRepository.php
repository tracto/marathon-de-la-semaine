<?php

namespace TdS\MarathonBundle\Entity;

/**
 * ThemeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ThemeRepository extends \Doctrine\ORM\EntityRepository{
	public function findAll(){
        return $this->findBy(array(), array('dateFin' => 'DESC'));
    }
}
