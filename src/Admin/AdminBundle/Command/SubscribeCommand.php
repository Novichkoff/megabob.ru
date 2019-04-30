<?php

namespace Admin\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Admin\AdminBundle\Model\AdvsQuery;
use \Criteria;
use Admin\AdminBundle\Model\SettingsQuery;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\AdCategoriesSubscribeQuery;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use FOS\UserBundle\Propel\UserQuery;

class SubscribeCommand extends ContainerAwareCommand
{

    # Ежедневное Cron-задание отправки новых объявлений подписчикам
    protected function configure()
    {
        $this
            ->setName('cron:subscribe')
            ->setDescription('Subscribe Task')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
      $top_panel = array();
      $top_panel['settings'] = SettingsQuery::create()->findOne();
        
      $subscribers = AdCategoriesSubscribeQuery::create()->find();
      foreach ($subscribers as $subscriber) {			
        $category = AdCategoriesQuery::create()->filterById($subscriber->getCategoryId())->findOne();        
        $category_array = array();
        $category_array[] = $category->getId();
        if (count($category->getAdChildss()))
          foreach ($category->getAdChildss() as $category_child) {
            $category_array[] = $category_child->getId();
          }        
        $last_advs_query = AdvsQuery::create('Advs');
        $last_advs_query->filterByCategoryId($category_array);
        $last_advs_query->join('Regions', Criteria::LEFT_JOIN);
        $last_advs_query->join('Areas', Criteria::LEFT_JOIN);
        if ($subscriber->getTownId()) {
          $last_advs_query->where('Regions.Id = ?', $subscriber->getTownId());
        } elseif ($subscriber->getAreaId()) {
          $last_advs_query->where('Areas.Id = ?', $subscriber->getAreaId());
        }
        $last_advs_query->filterById(array('min' => $subscriber->getLastAdvId()+1));
        $last_advs_query->orderById('ASC');
        $last_advs = $last_advs_query->filterByArray(array('enabled' => true, 'deleted' => false, 'moderApproved' => true))->find();			
        if (count($last_advs)) {
          $subject = 'Новые объявления на '.$top_panel['settings']->getName();
          $from = $top_panel['settings']->getName().' <noreply@'.mb_strtolower($top_panel['settings']->getName()).'>';
          $to = $subscriber->getEmail();
          $body = $this->getContainer()->get('templating')->render(
              'AdminAdminBundle:Advs:subscribe.html.twig',
              array('top_panel' => $top_panel, 'email' => $subscriber->getEmail(), 'token' => $subscriber->getUnsubscribeCode(), 'advs' => $last_advs)
          );
          $output->writeln($to);
          $this->getContainer()->get('mail_helper')->sendMailing($from, $to, $subject, $body);
          foreach($last_advs as $last_adv) {
            $subscriber->setLastAdvId($last_adv->getId());
          }
          $subscriber->setCnt($subscriber->getCnt()+count($last_advs));
          $subscriber->save();
        }			
      }		
      $output->writeln('ok');
    }	
	
}