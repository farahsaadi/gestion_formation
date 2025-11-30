<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    //    /**
    //     * @return Session[] Returns an array of Session objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Session
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findMostPopularSessions(): array
{
    $sql = "SELECT s.id, f.titre AS formationTitle, COUNT(sa.apprenant_id) AS nbApprenants
            FROM session s
            INNER JOIN formation f ON f.id = s.formation_id
            LEFT JOIN session_apprenant sa ON sa.session_id = s.id
            GROUP BY s.id, f.titre
            ORDER BY nbApprenants DESC";

    $conn = $this->getEntityManager()->getConnection();
    $stmt = $conn->prepare($sql);
    return $stmt->executeQuery()->fetchAllAssociative();
}

}
