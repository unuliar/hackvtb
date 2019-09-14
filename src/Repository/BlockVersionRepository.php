<?php

namespace App\Repository;

use App\Entity\BlockVersion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BlockVersion|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlockVersion|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlockVersion[]    findAll()
 * @method BlockVersion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlockVersionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlockVersion::class);
    }

    // /**
    //  * @return BlockVersion[] Returns an array of BlockVersion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BlockVersion
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
