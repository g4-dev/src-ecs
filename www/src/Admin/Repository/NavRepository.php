<?php

namespace Admin\Repository;

use Admin\Entity\Nav;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Nav|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nav|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nav[]    findAll()
 * @method Nav[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NavRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nav::class);
    }
}
