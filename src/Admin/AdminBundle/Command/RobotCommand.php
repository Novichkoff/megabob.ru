<?php

namespace Admin\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\AdvImagesQuery;
use Admin\AdminBundle\Model\AdvPacketsQuery;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class RobotCommand extends ContainerAwareCommand
{

    # Ежедневное Cron-задание по выявлению повтроряющихся объявлений
    protected function configure()
    {
        $this
            ->setName('cron:robot')
            ->setDescription('Daily Task')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $advs_all = AdvsQuery::create()->find();
        $advs = AdvsQuery::create()->find();
		foreach ( $advs_all as $adv_a ) {
          foreach ( $advs as $adv_b ) {
				$procent = 0;
				if ($adv_a->getId()!=$adv_b->getId()) similar_text($adv_a->getName(),$adv_b->getName(),$procent);
				if ($procent>90) {
					$output->writeln($adv_a->getId().' - '.$adv_b->getId());
				}
			}
        }

        $output->writeln('ok');
    }
}