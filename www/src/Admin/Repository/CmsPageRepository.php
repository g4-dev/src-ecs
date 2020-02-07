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
}