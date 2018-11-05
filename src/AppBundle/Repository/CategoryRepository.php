<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 06.09.2018
 * Time: 23:18
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findCategoriesByGroupSubCategory(): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->orderBy( 'c.groupId', 'ASC');

        return $qb->getQuery()->getResult();
    }
}