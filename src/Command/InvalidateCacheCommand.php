<?php


namespace App\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InvalidateCacheCommand extends ContainerAwareCommand
{
    /**
     * @var TagAwareAdapterInterface
     */
    private $cachePool;

    protected function configure()
    {
        $this
            ->setName('app:invalidate');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->cachePool = $this->getContainer()->get('app.cache');
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->cachePool->invalidateTags(['to_be_deleted']);
    }
}