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
use Doctrine\ORM\NonUniqueResultException;

class WikiRepository extends EntityRepository
{
    /**
     * @return Wiki[]
     */
    public function findAllWiki(): array
    {
        $qb = $this->createQueryBuilder('w');
        $qb
            ->orderBy('w.weight', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param null $wikiId
     * @return Wiki
     */
    public function findOneWikiByDefaultOrWikiId($wikiId = null): ?Wiki
    {
        $qb = $this->createQueryBuilder('w');
        if ($wikiId) {
            $qb
                ->andWhere('w.id = :wiki_id')
                ->setParameter('wiki_id', $wikiId)
            ;
        } else {
            $qb
                ->andWhere('w.parent = 0')
                ->orderBy('w.parent', 'ASC')
                ->setMaxResults(1)
            ;
        }

        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}