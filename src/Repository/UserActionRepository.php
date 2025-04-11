<?php

namespace App\Repository;

use App\Entity\UserAction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserAction>
 */
class UserActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAction::class);
    }
    

    /**
     * Find actions by type
     */
    public function findByAction(string $action): array
    {
        return $this->createQueryBuilder('ua')
            ->andWhere('ua.action = :action')
            ->setParameter('action', $action)
            ->orderBy('ua.actionAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find actions in a date range
     */
    public function findByDateRange(\DateTimeInterface $startDate, \DateTimeInterface $endDate): array
    {
        return $this->createQueryBuilder('ua')
            ->andWhere('ua.actionAt BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->orderBy('ua.actionAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find the latest actions (limited by count)
     */
    public function findLatest(int $limit = 10): array
    {
        return $this->createQueryBuilder('ua')
            ->orderBy('ua.actionAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Count actions by type
     */
    public function countByAction(string $action): int
    {
        return $this->createQueryBuilder('ua')
            ->select('COUNT(ua.id)')
            ->andWhere('ua.action = :action')
            ->setParameter('action', $action)
            ->getQuery()
            ->getSingleScalarResult();

    }

    //    /**
    //     * @return UserAction[] Returns an array of UserAction objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?UserAction
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
