<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 12/12/2018
 * Time: 11:21
 */

namespace AppBundle\Services;

use AppBundle\Entity\Wiki;
use AppBundle\Repository\WikiRepository;
use Doctrine\ORM\EntityManager;

class CategoryListService
{
    /**
     * @var WikiRepository
     */
    private $wikiRepository;

    /**
     * CategoryListService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->wikiRepository = $em->getRepository(Wiki::class);
    }

    /**
     * @return array
     */
    public function listCategories(): array
    {
        $wikis = $this->wikiRepository->findAllWiki();

        $listWiki = [];
        $refWiki = [];
        foreach ($wikis as $wiki) {
            if ($wiki->getParent() == 0) {
                $listWiki[$wiki->getId()] = $wiki;
            } else {
                $refWiki[$wiki->getParent()][] = $wiki;
            }
        }

        return [
            'listWiki' => $listWiki,
            'refWiki' => $refWiki,
        ];
    }
}