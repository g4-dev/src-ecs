<?php


namespace Admin\Repository;


use Doctrine\ORM\Tools\Pagination\Paginator;

trait Common
{
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
           ->orderBy('p.createdAt', 'DESC')
           ->setFirstResult($firstResult)
           ->setMaxResults($maxResults);
        
        return new Paginator($query);
    }
    
    public function findLatest(int $maxResults): array
    {
        return $this->createQueryBuilder('p')
           ->select('p')
           ->orderBy('p.createdAt', 'DESC')
           ->setMaxResults($maxResults)
           ->getQuery()
           ->getResult();
    }
}