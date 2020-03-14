<?php

namespace Core\Repository;

use Core\Entity\Admin;
use Core\Helper\ListParams;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class AdminRepository extends EntityRepository
{
    use ListTrait;

    static private $sorting = [];

    public function buildAdminListQuery(ListParams $params = null, ?array $roles = null): QueryBuilder
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('a')
            ->from(Admin::class, 'a')
            ->where('a.isDeleted = false');
        
        if($roles) {
            $qb->where('a.isActive = true')
                ->where('a.roles IN (:roles)')
                ->setParameter('roles', $roles);
        } else {
            $qb->andWhere('a.isActive = true');
        }
        
        return $this->applyListParamsOnQueryBuilder($qb, $params);
    }
}
