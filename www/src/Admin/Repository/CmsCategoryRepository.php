<?php
namespace Admin\Repository;

use Admin\Entity\CmsCategory;
use Core\Repository\DuplicateSlugTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CmsCategoryRepository|null findOneBy(array $criteria, array $orderBy = null)
 * @method CmsCategoryRepository[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CmsCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CmsCategory::class);
    }
    
    use DuplicateSlugTrait;
    use Common;
}
