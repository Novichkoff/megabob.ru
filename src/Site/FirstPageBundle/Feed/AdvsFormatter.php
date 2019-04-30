<?php

namespace Site\FirstPageBundle\Feed;

use Eko\FeedBundle\Feed\Feed;
use Eko\FeedBundle\Field\Item\ItemField;
use Eko\FeedBundle\Item\Writer\ItemInterface;
use Eko\FeedBundle\Formatter\Formatter;
use Eko\FeedBundle\Formatter\FormatterInterface;

use Symfony\Component\Translation\TranslatorInterface;

class AdvsFormatter extends Formatter implements FormatterInterface
{
    
    public function __construct(TranslatorInterface $translator, $domain = null)
    {
        $this->itemFields = array(
            new ItemField('title', 'getFeedItemTitle', array('cdata' => true)),
            new ItemField('description', 'getFeedItemDescription', array('cdata' => true)),
            new ItemField('link', 'getFeedItemLink'),
            new ItemField('pubDate', 'getFeedItemPubDate', array('date_format' => \DateTime::RSS)),
			new ItemField('image', 'getFeedItemImage'),
			new ItemField('enclosure', 'getFeedItemEnclosure',array(),array(
				'url'	=> 'getFeedItemImage',
				'type'	=> 'image/jpeg'
				)),			
        );

        parent::__construct($translator, $domain);
    }
    
    public function setFeed(Feed $feed)
    {
        $this->feed = $feed;

        $this->initialize();
    }

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        parent::initialize();

        $encoding = $this->feed->get('encoding');

        $this->dom = new \DOMDocument('1.0', $encoding);

        $root = $this->dom->createElement('rss');
        $root->setAttribute('version', '2.0');
        $root = $this->dom->appendChild($root);

        $channel = $this->dom->createElement('channel');
        $channel = $root->appendChild($channel);

        $title = $this->translate($this->feed->get('title'));
        $title = $this->dom->createElement('title', $title);
        $channel->appendChild($title);

        $description = $this->translate($this->feed->get('description'));
        $description = $this->dom->createElement('description', $description);
        $channel->appendChild($description);

        $link = $this->dom->createElement('link', $this->feed->get('link'));
        $channel->appendChild($link);
		
		$image = $this->dom->createElement('image', $this->feed->get('image'));		
        $channel->appendChild($image);
		
        $date = new \DateTime();
        $lastBuildDate = $this->dom->createElement('lastBuildDate', $date->format(\DateTime::RSS));

        $channel->appendChild($lastBuildDate);

        // Add custom channel fields
        $this->addChannelFields($channel);

        // Add feed items
        $items = $this->feed->getItems();

        foreach ($items as $item) {
            $this->addItem($channel, $item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addItem(\DOMElement $channel, ItemInterface $item)
    {
        $node = $this->dom->createElement('item');
        $node = $channel->appendChild($node);

        foreach ($this->itemFields as $field) {
            $elements = $this->format($field, $item);

            foreach ($elements as $element) {
                $node->appendChild($element);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'rss';
    }
}
