<?php
namespace FrontOffice\Repository;

use Admin\Repository\Common;
use Core\Repository\DuplicateSlugTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

use FrontOffice\Entity\Purchase;

/**
 * @method Purchase|null find($id, $lockMode = null, $lockVersion = null)
 * @method Purchase|null findOneBy(array $criteria, array $orderBy = null)
 * @method Purchase[]    findAll()
 * @method Purchase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Purchase::class);
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
    
    use Common;
    use DuplicateSlugTrait;
}
