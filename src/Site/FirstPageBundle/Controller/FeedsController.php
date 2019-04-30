<?php

namespace Site\FirstPageBundle\Controller;

use Admin\AdminBundle\Model\AdvsPeer;
use Admin\AdminBundle\Model\UserAccountQuery;
use Admin\AdminBundle\Model\UserFavoriteQuery;
use \Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Site\FirstPageBundle\Form\SimpleSearchType;
use Site\FirstPageBundle\Form\Comment;
use Site\FirstPageBundle\Controller\Adv;
use Site\FirstPageBundle\Controller\NewsItem;
use Site\FirstPageBundle\Controller\AdvVk;
use Site\FirstPageBundle\Controller\Auto;
use Site\FirstPageBundle\Controller\Realty;
use Site\FirstPageBundle\Controller\Vacancy;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdvComments;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\ShopsQuery;
use Admin\AdminBundle\Model\MenuQuery;
use Admin\AdminBundle\Model\BannersQuery;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\NewsQuery;
use Admin\AdminBundle\Model\AdvsStatQuery;
use Admin\AdminBundle\Model\AdvParamsQuery;
use Admin\AdminBundle\Model\AdvImagesQuery;
use Admin\AdminBundle\Model\AdvVideosQuery;
use Admin\AdminBundle\Model\AdvComplaine;
use Admin\AdminBundle\Model\AdCategories;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;
use Admin\AdminBundle\Model\UserFavorite;
use Admin\AdminBundle\Model\UserMessages;
use Eko\FeedBundle\Item\Writer\ItemInterface;
use Eko\FeedBundle\Field\Item\MediaItemField;
use Symfony\Component\HttpFoundation\Response;
use Eko\FeedBundle\Field\Item\ItemField;

class FeedsController extends Controller
{

  ###########################################
  ##            RSS (Новости)              ##
  ###########################################
  public function rssAction(Request $request)
  {

    $news = NewsQuery::create()
		->orderByUpdatedAt('desc')
		->find();
    $feed = $this->get('eko_feed.feed.manager')->get('news');
    foreach ($news as $news_item) {
		$item = new NewsItem($news_item);
		$feed->add($item);
    }
    return new Response($feed->render('rss'));
  }

  ###########################################
  ##            RSS (Дайджест)             ##
  ###########################################
  public function rssVkAction(Request $request)
  {
    $advs = AdvsQuery::create()
		->filterByEnabled(true)
		->filterByDeleted(false)
		->filterByModerApproved(true)
		->limit(100)		
		->orderById('desc')
		->find();
    $feed = $this->get('eko_feed.feed.manager')->get('advs');
    foreach ($advs as $adv) {
		$adv->domain = $this->generateUrl('site_first_page_homepage', array(), true);
		$adv->url = $this->generateUrl('site_adv_page', array('category' => $adv->getAdCategories()->getAdCategoriesRelatedByParentId()->getAlias(),'subcategory' => $adv->getAdCategories()->getAlias(),'id' => $adv->getId(), 'alias' => $adv->getAlias(),'region' => $adv->getRegions()->getAlias()), true);
		
		$item = new AdvVk($adv);				
		$feed->add($item);		
    }	
    return new Response($feed->render('advs'));
  }

  ###########################################
  ##              Яндекс Авто              ##
  ###########################################
  public function yandexAutoAction(Request $request)
  {
    $advs = AdvsQuery::create()
		->filterByCategoryId(array(22))
		->filterByEnabled(true)
		->filterByDeleted(false)
		->filterByYandexPartner(true)
		->orderByPublishDate('desc')
		->find();
    $feed = $this->get('eko_feed.feed.manager')->get('auto');
    foreach ($advs as &$adv) {
		$adv->params = array();
		foreach ($adv->getAdvParamss()->getData() as $param) {
			if ($param->getValueId() && @$param->getAdCategoriesFieldsValues()) {
				$adv->params[$param->getFieldId()] = $param->getAdCategoriesFieldsValues()->getName();
			} else {
				$adv->params[$param->getFieldId()] = $param->getTextValue() ? $param->getTextValue() : '';
			}
		}	  	    
		if (@$adv->params[176] == 'Продам' && $adv->getPrice()>10000) {
			$item = new Auto($adv);
			$feed->add($item);
		}
    }
	//$response = new Response();
	//$response->setETag(md5($adv->getDescription()));
    return new Response($feed->render('auto'));
  }

  ###########################################
  ##           Яндекс Недвижимость         ##
  ###########################################
  public function yandexRealtyAction(Request $request)
  {

    $advs = AdvsQuery::create()
		->filterByCategoryId(array(29,125))
		->filterByEnabled(true)
		->filterByDeleted(false)
		->filterByYandexPartner(true)
		->orderByPublishDate('desc')
		->find();
    $feed = $this->get('eko_feed.feed.manager')->get('realty');
    foreach ($advs as &$adv) {
		if ($adv->getPrice()>0) {
			$adv->params = array();
			foreach ($adv->getAdvParamss()->getData() as $param) {
				if ($param->getValueId() && @$param->getAdCategoriesFieldsValues()) {
					$adv->params[$param->getFieldId()] = $param->getAdCategoriesFieldsValues()->getName();
				} else {
					$adv->params[$param->getFieldId()] = $param->getTextValue() ? $param->getTextValue() : '';
				}
			}
			if (($adv->params[88] == 'Продам' || $adv->params[88] == 'Сдам') && $adv->getPrice()) {
				$item = new Realty($adv);
				$feed->add($item);
			}
		}
    }
    return new Response($feed->render('realty'));
  }
  
  ###########################################
  ##             Яндекс Вакансии           ##
  ###########################################
  public function yandexVacancyAction(Request $request)
  {

    $advs = AdvsQuery::create()
		->filterByCategoryId(133)
		->filterByEnabled(true)
		->filterByDeleted(false)
		->filterByYandexPartner(true)
		->filterByPublishDate(array("min" => strtotime( date("Y-m-d H:i:s", strtotime('-30 days')))))
		->orderByPublishDate('desc')		
		->find();
    $feed = $this->get('eko_feed.feed.manager')->get('vacancy');
    foreach ($advs as &$adv)
    {
		if ($adv->getPrice()>5000) {
			$adv->params = array();
			foreach ($adv->getAdvParamss()->getData() as $param) {
				if ($param->getValueId() && @$param->getAdCategoriesFieldsValues()) {
					$adv->params[$param->getFieldId()] = $param->getAdCategoriesFieldsValues()->getName();
				} else {
					$adv->params[$param->getFieldId()] = $param->getTextValue() ? $param->getTextValue() : '';
				}
			}
			$item = new Vacancy($adv);
			$feed->add($item);
		}			
    }
    return new Response($feed->render('vacancy'));
  }

}