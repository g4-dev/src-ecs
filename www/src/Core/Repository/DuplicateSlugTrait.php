<?php


namespace Core\Repository;


use Admin\Entity\AbstractSluggable;

trait DuplicateSlugTrait
{
    public function findDuplicateSlug(?int $id, string $slug): ?Product
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder
           ->andWhere('p.deletedAt = 0');
        if ($id) {
            $queryBuilder
               ->andWhere('p.id != :id')
               ->setParameter('id', $id);
        }
        $queryBuilder->andWhere('p.slug = :slug OR p.slug LIKE :slug_with_suffix')
           ->setParameter('slug', $slug)
           ->setParameter('slug_with_suffix', $slug . '-%');
        
        return $queryBuilder
           ->orderBy('p.slug', 'DESC')
           ->setMaxResults(1)
           ->getQuery()
           ->getOneOrNullResult();
    }
    
    public function findOneBySlug(string $slug): ?AbstractSluggable
    {
        return $this->createQueryBuilder('p')
           ->where('p.slug = :slug')
           ->setParameter('slug', $slug)
           ->getQuery()
           ->getOneOrNullResult();
    }
}