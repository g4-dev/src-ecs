<?php
namespace Admin\Repository;

use Admin\Entity\AbstractCategory;
use Core\Repository\DuplicateSlugTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method CategoryRepository|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryRepository[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbstractCategory::class);
    }
    
    use DuplicateSlugTrait;

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return $this->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneBySlug(string $slug): ?AbstractCategory
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

    public function findAllWithDeleted()
    {
        return $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult();
    }

    public function findAllById(array $ids)
    {
        return $this->createQueryBuilder('p')
            ->where('p.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }
    
    /**
     * @param string|null $query
     * @param int $firstResult
     * @param int $maxResults
     * @return Paginator
     */
    public function search(?string $query, int $firstResult = 0, int $maxResults = 10)
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.name LIKE :query')
            ->setFirstResult($firstResult)
            ->setMaxResults($maxResults)
            ->setParameter('query', '%'.addcslashes($query, '%_').'%')
            ->getQuery();

        return new Paginator($query);
    }

    public function getPaginated(int $firstResult = 0, int $maxResults = 10)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.dateCreated', 'DESC')
            ->setFirstResult($firstResult)
            ->setMaxResults($maxResults);

        return new Paginator($query);
    }

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
            ->orderBy('p.dateCreated', 'DESC')
            ->setMaxResults($maxResults)
            ->getQuery()
            ->getResult();
    }
}
