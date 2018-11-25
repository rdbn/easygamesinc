<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 16/11/2018
 * Time: 20:27
 */

namespace AppBundle\Listener;

use AppBundle\Entity\Comment;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class CommentListener
{
    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof Comment) {
            return;
        }

        $wikiId = $entity->getWiki()->getId();
        $em = $args->getObjectManager();
        /** @var User[] $users */
        $users = $em->getRepository(User::class)
            ->findAll();

        foreach ($users as $user) {
            if ($user->getId() == $entity->getUser()->getId()) {
                continue;
            }

            $checkComments = $user->getCheckComments();
            if (isset($checkComments[$wikiId])) {
                $checkComments[$wikiId][] = $entity->getId();
            } else {
                $checkComments[$wikiId] = [$entity->getId()];
            }
            $user->setCheckComments($checkComments);
        }

        $em->persist($entity);
        $em->flush();
    }
}