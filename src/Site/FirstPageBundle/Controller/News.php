<?php

namespace Site\FirstPageBundle\Controller;

use Admin\AdminBundle\Model\News;
use Eko\FeedBundle\Item\Writer\ItemInterface;
use Zend\Stdlib\DateTime;

class NewsItem implements ItemInterface
{
    public function __construct($news)
    {
        $this->news = $news;
    }
    
    public function getFeedItemTitle() {
      return $this->news->getTitle();
    }

    public function getFeedItemDescription() {
      return $this->news->getDescription();
    }
    
    public function getFeedItemLink() {      
      $url = "https://claso.ru/news/".$this->news->getAlias();
      return $url;
    }
         
    public function getFeedItemPubDate() {      
      return $this->news->getUpdatedAt();
    }	

}
