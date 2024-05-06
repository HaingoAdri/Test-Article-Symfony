<?php

namespace App\Repository;

use App\Entity\Adminstrateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Adminstrateur>
 *
 * @method Adminstrateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adminstrateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adminstrateur[]    findAll()
 * @method Adminstrateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminstrateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adminstrateur::class);
    }

//    /**
//     * @return Adminstrateur[] Returns an array of Adminstrateur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Adminstrateur
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
