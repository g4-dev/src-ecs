<?php


namespace Admin\Repository;


use Admin\Entity\CmsPage;
use Admin\Entity\Diy;
use Core\Repository\DuplicateSlugTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class DiyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CmsPage::class);
    }
    
    public function findAllQueryBuilder()
    {
        return $this->createQueryBuilder('p')
           ->getQuery();
    }
    
    public function findOneBySlug(string $slug): ?Diy
    {
        return $this->createQueryBuilder('p')
           ->where('p.slug = :slug')
           ->setParameter('slug', $slug)
           ->getQuery()
           ->getOneOrNullResult();
    }
}