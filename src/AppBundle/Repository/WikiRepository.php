<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 06.09.2018
 * Time: 23:18
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class WikiRepository extends EntityRepository
{
    /**
     * @param $categoryId
     * @param $text
     * @param $page
     * @param $limit
     * @return array
     */
    public function findWikiByText($categoryId, $text, $page, $limit)
    {
        $qb = $this->createQueryBuilder('w');
        $qb
            ->orderBy('w.title', 'ASC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        if ($categoryId) {
            $qb
                ->leftJoin('w.category', 'c')
                ->andWhere($qb->expr()->eq('c.id', ':categoryId'))
                ->setParameter('categoryId', $categoryId);
        }

        if ($text) {
            $qb
                ->where($qb->expr()->like('w.text', ":text"))
                ->setParameter('text', "%{$text}%");
        }

        return $qb->getQuery()->getResult();
    }
}