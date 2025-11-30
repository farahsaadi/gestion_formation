<?php

namespace App\Repository;

use App\Entity\Apprenant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Apprenant>
 */
class ApprenantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apprenant::class);
    }

    //    /**
    //     * @return Apprenant[] Returns an array of Apprenant objects
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

    //    public function findOneBySomeField($value): ?Apprenant
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
 public function countApprenantsByFormation()
{
    return $this->createQueryBuilder('a')
        ->select('f.titre AS formation', 'COUNT(a.id) AS total')
        ->join('a.sessions', 's')
        ->join('s.formation', 'f')
        ->groupBy('f.titre')
        ->getQuery()
        ->getResult();
}

public function findAllOrdered()
{
    return $this->createQueryBuilder('a')
        ->orderBy('a.nom', 'ASC')
        ->addOrderBy('a.prenom', 'ASC')
        ->getQuery()
        ->getResult();
}
}
