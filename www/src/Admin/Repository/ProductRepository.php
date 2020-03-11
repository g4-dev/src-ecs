<?php
namespace Admin\Repository;

use Admin\Entity\Product;
use Core\Repository\DuplicateSlugTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
    
    use Common;
    use DuplicateSlugTrait;
    
    public function countCurrentlySelling()
    {
        return $this->createQueryBuilder('p')
           ->select('count(p.id)')
           ->getQuery()
           ->getSingleScalarResult();
    }

    public function findLatest(int $maxResults): array
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.updatedAt', 'DESC')
            ->setMaxResults($maxResults)
            ->getQuery()
            ->getResult();
    }
}
