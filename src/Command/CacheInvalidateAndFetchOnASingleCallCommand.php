<?php


namespace App\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CacheInvalidateAndFetchOnASingleCallCommand extends ContainerAwareCommand
{
    /**
     * @var TagAwareAdapterInterface
     */
    private $cachePool;

    protected function configure()
    {
        $this
            ->setName('app:single-flow')
            ->setDescription('Populates, invalidates by tag and returns tagged cases');
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
        // Populate...
        for ($i = 0; $i < $howMany; $i++) {
            $cacheItem = $this->cachePool->getItem("item-$i");
            $cacheItem->tag(['to_be_deleted']);
            $this->cachePool->save($cacheItem);
        }

        $output->writeln("Check that all the items are saved properly");
        for ($i = 0; $i < $howMany; $i++) {
            $cacheItem = $this->cachePool->getItem("item-$i");
            $hit = $cacheItem->isHit()?'true':'false';
            $output->writeln("{$cacheItem->getKey()}, isHit:{$hit}");
        }
        $this->cachePool->invalidateTags(['to_be_deleted']);


        $output->writeln("Check that all the items are cleared properly");
        for ($i = 0; $i < $howMany; $i++) {
            $cacheItem = $this->cachePool->getItem("item-$i");
            $hit = $cacheItem->isHit()?'true':'false';
            $output->writeln("{$cacheItem->getKey()}, isHit:{$hit}");
        }

    }
}