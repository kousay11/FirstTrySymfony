<?php

namespace App\Repository;

use App\Entity\Kouasay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Kouasay>
 *
 * @method Kouasay|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kouasay|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kouasay[]    findAll()
 * @method Kouasay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KouasayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kouasay::class);
    }

//    /**
//     * @return Kouasay[] Returns an array of Kouasay objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('k')
//            ->andWhere('k.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('k.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Kouasay
//    {
//        return $this->createQueryBuilder('k')
//            ->andWhere('k.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
