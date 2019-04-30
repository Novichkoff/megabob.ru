<?php

namespace Site\FirstPageBundle\Feed;

use Eko\FeedBundle\Feed\Feed;
use Eko\FeedBundle\Field\Item\ItemField;
use Eko\FeedBundle\Item\Writer\ItemInterface;
use Eko\FeedBundle\Formatter\Formatter;
use Eko\FeedBundle\Formatter\FormatterInterface;

use Symfony\Component\Translation\TranslatorInterface;

class AutoFormatter extends Formatter implements FormatterInterface
{
    
    public function __construct(TranslatorInterface $translator, $domain = null)
    {
        $this->itemFields = array(
            new ItemField('url', 'getFeedItemLink'),
            new ItemField('date', 'getFeedItemPubDate', array('date_format' => 'Y-m-d h:i:s \G\M\T+5')),
			new ItemField('update-date', 'getFeedItemPubDate', array('date_format' => 'Y-m-d h:i:s \G\M\T+5')),
			new ItemField('valid-thru-date', 'getFeedItemPubBeforeDate', array('date_format' => 'd.m.Y')),
            new ItemField('additional-info', 'getFeedItemDescription', array('cdata' => false)),            
            new ItemField('mark', 'getFeedItemMark'),
            new ItemField('model', 'getFeedItemModel'),
            new ItemField('year', 'getFeedItemYear'),  
            new ItemField('run', 'getFeedItemRun'),            
            new ItemField('run-metric', 'getFeedItemRunMetric'),
            new ItemField('displacement', 'getFeedItemDisplacement'),
            new ItemField('steering-wheel', 'getFeedItemSteeringWheel'),
            new ItemField('stock', 'getFeedItemStock'),
			new ItemField('state', 'getFeedItemState'),
            new ItemField('price', 'getFeedItemPrice'),
            new ItemField('currency-type', 'getFeedItemCurrencyType'),
            new ItemField('seller-city', 'getFeedItemSellerCity'),
            new ItemField('seller-phone', 'getFeedItemSellerPhone'),
			new ItemField('image', 'getFeedItemImage'),
			new ItemField('color', 'getFeedItemColor'),
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

        $root = $this->dom->createElement('auto-catalog');        
        $root = $this->dom->appendChild($root);
        
        $date = new \DateTime();
        $lastBuildDate = $this->dom->createElement('creation-date', $date->format('Y-m-d h:i:s \G\M\T+5'));
        
        $root->appendChild($lastBuildDate);

        $host = $this->dom->createElement('host','claso.ru');
        $host = $root->appendChild($host);

        $channel = $this->dom->createElement('offers');
        $channel = $root->appendChild($channel);
        
        $this->addChannelFields($channel);
        
        $items = $this->feed->getItems();

        foreach ($items as $item) {
            $this->addItem($channel, $item);
        }
    }
    
    public function addItem(\DOMElement $channel, ItemInterface $item)
    {
        $node = $this->dom->createElement('offer');
        $node->setAttribute('type', 'private');
        $node = $channel->appendChild($node);

        foreach ($this->itemFields as $field) {
            $elements = $this->format($field, $item);

            foreach ($elements as $element) {
                if ($element->nodeValue) $node->appendChild($element);
            }
        }
    }
    
    public function getName()
    {
        return 'rss';
    }
}
