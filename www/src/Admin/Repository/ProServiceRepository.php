<?php
namespace Admin\Repository;

use Admin\Entity\ProService;
use Core\Repository\DuplicateSlugTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProService|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProService|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProService[]    findAll()
 * @method ProService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProService::class);
    }
    
    use Common;
    use DuplicateSlugTrait;

}
