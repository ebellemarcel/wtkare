<?php

namespace App\Repository;

use App\Entity\Propriete;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\LockMode;

/**
 * @extends ServiceEntityRepository<Propriete>
 */
class ProprieteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Propriete::class);
    }

	
     /**
     * @param mixed $id
     * @param int|null $lockMode
     * @param int|null $lockVersion
     * @return Propriete|null
     */
    public function find($id, $lockMode = null, $lockVersion = null): ?Propriete
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    /**
        * @return Propriete[] Returns an array of Propriete objects
       */
       public function listproprietes(): array
        {
            return $this->createQueryBuilder('p')
                ->orderBy('p.id', 'ASC')
                ->setMaxResults(30)
                ->getQuery()
                ->getResult()
            ;
        }


       /**
        * @return Propriete[] Returns an array of Propriete objects
       */
       public function findByville($value): array
        {
            return $this->createQueryBuilder('p')
                ->andWhere('p.ville = :val')
                ->setParameter('val', $value)
                ->orderBy('p.id', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }

        public function findOneBytitre($value): ?Propriete
        {
            return $this->createQueryBuilder('p')
                ->andWhere('p.titre = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult()
            ;
	}


	/**
     	* @param float $minPrice
     	* @param float $maxPrice
     	* @return Property[]
     	*/
    	public function findPropertyByRangeOfPrice(float $minPrice, float $maxPrice): array
    	{
        	$query = $this->createQueryBuilder('p')
            		->andWhere('p.prix >= :minPrice')
            		->andWhere('p.prix <= :maxPrice')
            		->setParameter('minPrice', $minPrice)
            		->setParameter('maxPrice', $maxPrice)
            		->getQuery();

        	return $query->getResult();
	}



	/**
     	* @param string $accessoireType
     	* @return Property[]
    	*/
    	public function findPropertyByAccessoireType(string $accessoireType): array
    	{
        	$query = $this->createQueryBuilder('p')
            	->leftJoin('p.accessoires', 'a')
            	->andWhere('a.type = :accessoireType')
            	->setParameter('accessoireType', $accessoireType)
            	->getQuery();

        	return $query->getResult();
    	}

	public function findProprieteById($id)
	{
    		$dql = "SELECT p.id, p.titre, p.description, p.type,p.surface, p.prix,
       		 p.chambres, p.ville, p.codepostal, p.longitude, p.latitude, p.date_creation 
        	FROM App\Entity\Propriete p 
        	WHERE p.id = :id";

    		$query = $this->getEntityManager()->createQuery($dql);       

    		$proprietes = $query->execute(array('id' => $id));

    		$propriete = null;
   		if ($proprietes != null && isset($proprietes[0])) {
       		$proprietes = $proprietes[0];
    	}

    		return $propriete; 
	}


}
