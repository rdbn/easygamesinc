<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UploadImageWikiCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:upload_image_wiki')
            ->setDescription('чСоздаем первого пользователя ROLE_ADMIN');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');
        $uploadImage = $container->get('app.service.upload_image');
        $logger = $container->get('logger');

        $uploadImage->upload([]);

        $logger->info('Parser wiki image.');
    }
}
