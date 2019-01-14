<?php

namespace AppBundle\Command;

use AppBundle\Entity\Wiki;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateRealWeightCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:create_real_weight')
            ->setDescription('Hello PhpStorm');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');
        $logger = $container->get('logger');

        $logger->info('Start parser weight');
        $wikis = $em->getRepository(Wiki::class)
            ->findAll();

        foreach ($wikis as $wiki) {
            /** @var Wiki $wiki */
            $logger->info("Parse weight: {$wiki->getTitle()}");

            preg_match('/(\d+)\./i', $wiki->getTitle(), $matches);
            if (isset($matches[1])) {
                $wiki->setWeight($matches[1]);
            } else {
                $wiki->setWeight(100);
            }
        }

        try {
            $em->flush();
        } catch (OptimisticLockException $e) {
            $logger->error($e->getMessage());
            exit(1);
        }

        $logger->info('End end weight');
    }
}
