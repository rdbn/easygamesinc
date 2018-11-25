<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 06.09.2018
 * Time: 23:18
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository
{
    /**
     * @param array $ids
     * @return array
     */
    public function findCommentById(array $ids): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->where($qb->expr()->in('c.id', $ids));

        return $qb->getQuery()->getResult();
    }
}