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
     * @param $text
     * @param $page
     * @param $limit
     * @return array
     */
    public function findWikiByText($text, $page, $limit)
    {
        $qb = $this->createQueryBuilder('w');
        $qb
            ->orderBy('w.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        if ($text) {
            $qb
                ->where($qb->expr()->like('w.text', ":text"))
                ->setParameter('text', "%{$text}%");
        }

        return $qb->getQuery()->getResult();
    }
}