<?php
namespace FrontOffice\Repository;

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

    public function findOneByIdAndUser(int $orderId, int $userId): ?Purchase
    {
        return $this->createQueryBuilder('o')
            ->where('o.id = :id')
            ->andWhere('o.user = :user_id')
            ->setParameter('id', $orderId)
            ->setParameter('user_id', $userId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
