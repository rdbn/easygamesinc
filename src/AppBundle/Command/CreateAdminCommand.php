<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAdminCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:create_admin')
            ->setDescription('чСоздаем первого пользователя ROLE_ADMIN');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');
        $encoder = $container->get('security.password_encoder');
        $logger = $container->get('logger');

        $user = new User();
        $user
            ->setUsername('admin')
            ->setPassword($encoder->encodePassword($user, 'lWhEXFcl'))
            ->setRole(User::ROLE_USER['Admin']);

        try {
            $em->persist($user);
            $em->flush();
        } catch (OptimisticLockException $e) {
            $logger->error($e->getMessage());
        }

        $logger->info('Create user admin.');
    }
}
