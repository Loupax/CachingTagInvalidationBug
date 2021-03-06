<?php


namespace App\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetAllCacheItemsCommand extends ContainerAwareCommand
{
    /**
     * @var TagAwareAdapterInterface
     */
    private $cachePool;

    protected function configure()
    {
        $this
            ->setName('app:get');
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
        $howMany = 5;

        for ($i = 0; $i < $howMany; $i++) {
            $cacheItem = $this->cachePool->getItem("item-$i");
            $hit = $cacheItem->isHit()?'true':'false';
            $output->writeln("{$cacheItem->getKey()}, isHit:{$hit}");
        }

    }
}