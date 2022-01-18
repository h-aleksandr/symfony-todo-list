<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;

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
        $from = \DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d 00:00:00"));
        $to = \DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d 23:59:59"));

        return $this->createQueryBuilder('t')
            // ->where('t.dueDate >= :from')    // <<-- it work also
            // ->andWhere('t.dueDate <= :to')
            ->where('t.dueDate between :from and :to')
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            // ->orderBy('t.id', 'ASC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
        ;
    }

     public function findExpired($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.dueDate < :val')
            ->andWhere('t.completed = false')
            ->setParameter('val', $value)
            // ->orderBy('t.id', 'ASC')
            ->setMaxResults(30)
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
