<?php

namespace Site\FirstPageBundle\Feed;

use Eko\FeedBundle\Feed\Feed;
use Eko\FeedBundle\Field\Item\ItemField;
use Eko\FeedBundle\Field\Item\GroupItemField;
use Eko\FeedBundle\Item\Writer\ItemInterface;
use Eko\FeedBundle\Formatter\Formatter;
use Eko\FeedBundle\Formatter\FormatterInterface;

use Symfony\Component\Translation\TranslatorInterface;


class VacancyFormatter extends Formatter implements FormatterInterface
{    
    public function __construct(TranslatorInterface $translator, $domain = null)
    {
        
		$this->itemFields = array(            
			new ItemField('url', 'getFeedItemLink'),
			new ItemField('mobile-url', 'getFeedItemLink'),			
            new ItemField('creation-date', 'getFeedItemCreateDate', array('date_format' => \DateTime::ATOM)),
			new ItemField('update-date', 'getFeedItemPubDate', array('date_format' => \DateTime::ATOM)),
			new ItemField('salary', 'getFeedItemPrice'),
			new ItemField('currency', 'getFeedItemCurrency'),
			new GroupItemField('category', array(
				new ItemField('industry','getFeedItemIndustry')
				)),
			new ItemField('job-name', 'getFeedItemTitle'),
			new ItemField('employment', 'getFeedItemEmployment'),
			new ItemField('description', 'getFeedItemDescription', array('cdata' => false)),			
			new GroupItemField('addresses', array(				
				new GroupItemField('address', array(
					new ItemField('location','getFeedItemAddress'),
					new ItemField('metro','getFeedItemMetro')
					))
				)),
			/*new GroupItemField('company', array(
					new ItemField('name','getFeedItemCompany')
					))*/
			new GroupItemField('anonymous-company', array(
					new ItemField('description','getFeedItemCompanyDescription')
					))
        );

        parent::__construct($translator, $domain);
    }
    
    public function setFeed(Feed $feed)
    {
        $this->feed = $feed;

        $this->initialize();
    }
    
    public function initialize()
    {
        parent::initialize();

        $encoding = $this->feed->get('encoding');

        $this->dom = new \DOMDocument('1.0', $encoding);

        $date = new \DateTime();
		$root = $this->dom->createElement('source');
		$root->setAttribute('creation-time', $date->format(\DateTime::ATOM));
		$root->setAttribute('host', 'claso.ru');        
        $root = $this->dom->appendChild($root);
		
		$channel = $this->dom->createElement('vacancies');
        $channel = $root->appendChild($channel);
		$this->addChannelFields($channel);
        
        $items = $this->feed->getItems();

        foreach ($items as $item) {
            $this->addItem($channel, $item);
        }
		
    }
    
    public function addItem(\DOMElement $channel, ItemInterface $item)
    {
        $node = $this->dom->createElement('vacancy');
		$node = $channel->appendChild($node);

        foreach ($this->itemFields as $field) {
            $elements = $this->format($field, $item);

            foreach ($elements as $element) {
                $node->appendChild($element);
            }
        }
    }
    
    public function getName()
    {
        return 'rss';
    }
}
