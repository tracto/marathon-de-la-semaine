<?php
namespace TdS\MarathonBundle\Entity;
use TdS\MarathonBundle\Entity\Saison;


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

    public function findThemesBySaison(Saison $saison){
        	$queryBuilder=$this->_em->createQueryBuilder()
			->select('a')
			->where('a.saison = :saison')
       			->setParameter('saison', $saison)
       		->orderBy('a.dateDebut', 'ASC')
			->from($this->_entityName,'a');


		return $queryBuilder
    		->getQuery()
    		->getResult();
    }
}
