<?php

namespace Unoegohh\EntitiesBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Unoegohh\UserBundle\Entity\User;

class MenuItemRepository extends EntityRepository
{
    public function getMainMenu()
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->where($qb->expr()->isNull('u.parent'))
            ->orderBy("u.orderNum", "ASC");
        return $qb->getQuery()->getResult();
    }

}