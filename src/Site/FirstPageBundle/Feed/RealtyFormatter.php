<?php
/*
 * This file is part of the Eko\FeedBundle Symfony bundle.
 *
 * (c) Vincent Composieux <vincent.composieux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Site\FirstPageBundle\Feed;

use Eko\FeedBundle\Feed\Feed;
use Eko\FeedBundle\Field\Item\ItemField;
use Eko\FeedBundle\Field\Item\GroupItemField;
use Eko\FeedBundle\Item\Writer\ItemInterface;
use Eko\FeedBundle\Formatter\Formatter;
use Eko\FeedBundle\Formatter\FormatterInterface;

use Symfony\Component\Translation\TranslatorInterface;

/**
 * RSS formatter
 *
 * This class provides an RSS formatter
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class RealtyFormatter extends Formatter implements FormatterInterface
{
    /**
     * Construct a formatter with given feed
     *
     * @param TranslatorInterface $translator A Symfony translator service instance
     * @param string|null         $domain     A Symfony translation domain
     */
    public function __construct(TranslatorInterface $translator, $domain = null)
    {
        
		$this->itemFields = array(
      new ItemField('type', 'getFeedItemType'),
			new ItemField('property-type', 'getFeedItemPropertyType'),
			new ItemField('category', 'getFeedItemCategory'),
			new ItemField('url', 'getFeedItemLink'),
      new ItemField('creation-date', 'getFeedItemPubDate', array('date_format' => \DateTime::ATOM)),            
      new GroupItemField('location', array(
				new ItemField('country','getFeedItemCountry'), 
				new ItemField('locality-name','getFeedItemTown'), 
				new ItemField('address','getFeedItemAddress')
				)),
      new ItemField('image', 'getFeedItemImage'),        
			new ItemField('description', 'getFeedItemDescription', array('cdata' => false)),
			new GroupItemField('area', array(
				new ItemField('value','getFeedItemArea'),
				new ItemField('unit','getFeedItemUnitArea'),
				)),			
			new GroupItemField('living-space', array(
				new ItemField('value','getFeedItemLivingSpace'),
				new ItemField('unit','getFeedItemUnitLiving'),
				)),			
			new GroupItemField('kitchen-space', array(
				new ItemField('value','getFeedItemKitchenSpace'),
				new ItemField('unit','getFeedItemUnitKitchen'),
				)),
			new ItemField('rooms', 'getFeedItemRooms'),
			new GroupItemField('price', array(
				new ItemField('value', 'getFeedItemPrice'),
				new ItemField('currency', 'getFeedItemCurrencyType'),
				new ItemField('period', 'getFeedItemPeriodType')
				)),
      new GroupItemField('sales-agent', array(
				new ItemField('phone','getFeedItemSellerPhone')
				))
      );		

      parent::__construct($translator, $domain);
    }

    /**
     * Sets feed instance
     *
     * @param Feed $feed
     */
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

        $root = $this->dom->createElement('realty-feed');
        $root->setAttribute('xmlns', 'http://webmaster.yandex.ru/schemas/feed/realty/2010-06');        
        $root = $this->dom->appendChild($root);
        
        $date = new \DateTime();
        $lastBuildDate = $this->dom->createElement('generation-date', $date->format(\DateTime::ATOM));        
        $root->appendChild($lastBuildDate);

        // Add feed items
        $items = $this->feed->getItems();

        foreach ($items as $item) {
            $this->addItem($root, $item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addItem(\DOMElement $channel, ItemInterface $item)
    {
        $node = $this->dom->createElement('offer');
        $node->setAttribute('internal-id', $item->getFeedItemId());
        $node = $channel->appendChild($node);

        foreach ($this->itemFields as $field) {            
          $elements = $this->format($field, $item);

          foreach ($elements as $element) {
            if ($element->nodeValue) $node->appendChild($element);
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
