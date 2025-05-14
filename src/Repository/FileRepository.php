<?php

namespace App\Repository;

use App\Entity\File;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;



/**
 * @extends ServiceEntityRepository<File>
 */
class FileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, File::class);
    }

     // Filtrer les documents archivés
    public function findByUser($user)
     {
         return $this->createQueryBuilder('d')
             ->andWhere('d.user = :user')
             ->setParameter('user', $user)
             ->andWhere('d.archived = false')
             ->getQuery()
             ->getResult();
     }

     public function findDeletedFiles(): array
        {
            $qb=$this->createQueryBuilder('f');
            return $qb
                ->andWhere($qb->expr()->isNotNull('f.deletedAt'))
                ->getQuery()
                ->getResult()
            ;
        }

    public function findRecentFiles(): array
        {
          $qb=$this->createQueryBuilder('f');
          return $qb
                ->andWhere($qb->expr()->isNull('f.deletedAt'))
                ->orderBy('f.date', 'DESC') 
                ->setMaxResults(10)  
                ->getQuery()
                ->getResult()
              ;
        }

       /**
     * Récupère les documents ayant une extension spécifique
     *
     * @param string $extension L'extension du fichier sans le point (ex: 'pdf', 'png')
     * @return Document[]
     */ 
    public function findByFileExtension(string $extension): array
    {
        return $this->createQueryBuilder('d')
            ->where('d.filename LIKE :ext')
            ->setParameter('ext', '%'.$extension) 
            ->orderBy('d.date', 'ASC') 
            ->getQuery()
            ->getResult();
    
    }

    public function findByvideoExtension(string $extension): array
    {
        return $this->createQueryBuilder('d')
            ->where('d.filename LIKE :ext')
            ->setParameter('ext', '%'.$extension) 
            ->orderBy('d.date', 'ASC') 
            ->getQuery()
            ->getResult();
    
    }

    public function findByzipExtension(string $extension): array
    {
        return $this->createQueryBuilder('d')
            ->where('d.filename LIKE :ext')
            ->setParameter('ext', '%'.$extension) 
            ->orderBy('d.date', 'ASC') 
            ->getQuery()
            ->getResult();
    
    }
                            
    public function findByKeyword(string $keyword): array
    {
        $qb=$this->createQueryBuilder('f');
        if ($keyword) {
            $expr = $qb->expr(); // Raccourci vers l'expression builder

            return $qb->where(
                $expr->orX(
                    $expr->like('LOWER(f.name)', ':kw'),
                    $expr->like('LOWER(f.description)', ':kw')
                )
            )
            ->setParameter('kw', '%' . strtolower($keyword) . '%')
            ->andWhere($qb->expr()->isNotNull('f.createdAt'))
            ->getQuery()
            ->getResult()
            ;
        }
           
            // Retourne un tableau vide si aucun mot-clé
            return [];
    }


    //    /**
    //     * @return File[] Returns an array of File objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?File
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}