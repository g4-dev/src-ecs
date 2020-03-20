<?php

namespace Admin\Repository;

use Admin\Entity\TitleContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TitleContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method TitleContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method TitleContent[]    findAll()
 * @method TitleContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TitleContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TitleContent::class);
    }

    // /**
    //  * @return TitleContent[] Returns an array of TitleContent objects
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
    public function findOneBySomeField($value): ?TitleContent
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
