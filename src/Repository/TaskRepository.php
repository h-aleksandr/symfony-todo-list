<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

     public function findByDate($value)
    {
        //  $from = new \DateTime($value->format("Y-m-d")." 00:00:00");
        //  $to   = new \DateTime($value->format("Y-m-d")." 23:59:59");

        return $this->createQueryBuilder('t')
            ->where('t.dueDate between :from AND :to')
            ->setParameter('from', $value->setTime(00, 00, 00))
            ->setParameter('to', $value->setTime(23, 59, 59))
            // ->orderBy('t.id', 'ASC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
        ;
    }
//'t.dueDate < :val
     public function findExpired($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.dueDate < :val')
            ->setParameter('val', $value)
            // ->orderBy('t.id', 'ASC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
        ;
    }

    
    // /**
    //  * @return Task[] Returns an array of Task objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Task
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
