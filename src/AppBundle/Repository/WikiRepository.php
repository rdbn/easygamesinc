<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 06.09.2018
 * Time: 23:18
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Wiki;
use Doctrine\ORM\EntityRepository;

class WikiRepository extends EntityRepository
{
    /**
     * @param $text
     * @return Wiki[]
     */
    public function findWikiByText($text)
    {
        $qb = $this->createQueryBuilder('w');
        $qb
            ->orderBy('w.title', 'ASC')
            ->orderBy('w.title', 'ASC')
            ->addOrderBy('w.parent', 'ASC')
        ;

        if ($text) {
            $qb
                ->where($qb->expr()->like('w.text', ":text"))
                ->setParameter('text', "%{$text}%");
        }

        return $qb->getQuery()->getResult();
    }
}