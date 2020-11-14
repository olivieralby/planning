<?php

namespace App\Repository;

use App\Entity\Day;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Day|null find($id, $lockMode = null, $lockVersion = null)
 * @method Day|null findOneBy(array $criteria, array $orderBy = null)
 * @method Day[]    findAll()
 * @method Day[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Day::class);
    }

    // /**
    //  * @return Day[] Returns an array of Day objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findOneBySomeField($value, $id): ?Day
    {
        return $this->createQueryBuilder('d')
            ->select('d','u')
            ->join('d.users','u')
            ->andWhere('u.id = :id')
            ->setParameter('id',$id)
            ->andWhere('d.start = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    

    public function getDay($id)
    {
        
        return $this->createQueryBuilder('d')
                ->select('d.id as day_id, d.start, d.end','a.label, a.color','u.id , u.lastname')
                ->join('d.activites','a')
                ->join('d.users','u')
                ->where('u.id =:id')
                ->setParameter('id',$id)
                ->getQuery()
                ->getResult();
    }

    public function findByUser($id)
    {
        return $this->createQueryBuilder('d')
                ->select('d','u')
                ->join('d.users','u')
                ->where('u.id =:id')
                ->setParameter('id',$id)
                ->getQuery()
                ->getResult();
    
    }
}
