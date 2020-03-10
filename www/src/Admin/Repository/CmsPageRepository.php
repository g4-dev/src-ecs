<?php


namespace Admin\Repository;


use Admin\Entity\CmsPage;
use Core\Repository\DuplicateSlugTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class CmsPageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CmsPage::class);
    }
    
    use DuplicateSlugTrait;
    
    public function findOneBySlug(string $slug): ?CmsPage
    {
        return $this->createQueryBuilder('p')
           ->where('p.slug = :slug')
           ->setParameter('slug', $slug)
           ->getQuery()
           ->getOneOrNullResult();
    }
    
    public function findAll()
    {
        return $this->createQueryBuilder('p')
           ->getQuery()
           ->getResult();
    }
    
    public function findAllQueryBuilder()
    {
        return $this->createQueryBuilder('p')
           ->getQuery();
    }
}