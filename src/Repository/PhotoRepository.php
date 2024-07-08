<?php

namespace App\Repository;

use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Photo>
 */
class PhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Photo::class);
    }

        /**
         * @return Photo[] Returns an array of Photo objects
         */
        public function findByPropriete($value): array
        {
            return $this->createQueryBuilder('p')
                ->andWhere('p.propriete = :val')
                ->setParameter('val', $value)
                ->orderBy('p.id', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }

        public function findMainProprietetPhoto($value): ?Photo
        {
            return $this->createQueryBuilder('p')
		->andWhere('p.propriete = :val')
		->andWhere('p.principale = true')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
}
