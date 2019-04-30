<?php
namespace Site\FirstPageBundle\Controller;

use Symfony\Component\Routing\RouterInterface;

use Presta\SitemapBundle\Service\SitemapListenerInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\PagesQuery;
use Admin\AdminBundle\Model\NewsQuery;
use Admin\AdminBundle\Model\ShopsQuery;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\RegionsQuery;
use FOS\UserBundle\Propel\UserQuery;

class SitemapListener implements SitemapListenerInterface
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
        $this->towns = RegionsQuery::create()->find();
        $this->areas = AreasQuery::create()->find();
    }

    public function populateSitemap(SitemapPopulateEvent $event)
    {
        $section = $event->getSection();
        $date = new \DateTime();
        //$date->modify( '-100 day' );
        if (is_null($section) || $section == 'default') {
            
          # Главная страница (Объявления)
          $url = $this->router->generate('site_first_page_homepage', array('region'=> 'russia'), true);

          $event->getGenerator()->addUrl(
              new Url\UrlConcrete(
                  $url,
                  $date,
                  Url\UrlConcrete::CHANGEFREQ_WEEKLY,
                  1
              ),
              'default'
          );          
          
          foreach ($this->areas as $area) {
            $url = $this->router->generate('site_first_page_homepage', array('region'=> $area->getAlias()), true);

            $event->getGenerator()->addUrl(
                new Url\UrlConcrete(
                    $url,
                    $date,
                    Url\UrlConcrete::CHANGEFREQ_HOURLY,
                    0.2
                ),
                'areas'
            );
          }
          
          foreach ($this->towns as $town) {
            $url = $this->router->generate('site_first_page_homepage', array('region'=> $town->getAlias()), true);

            $event->getGenerator()->addUrl(
                new Url\UrlConcrete(
                    $url,
                    $date,
                    Url\UrlConcrete::CHANGEFREQ_HOURLY,
                    0.2
                ),
                'towns'
            );
          }
          
           
          # Магазины
          $url = $this->router->generate('site_shops_homepage', array('region'=> 'russia'), true);
          
          $event->getGenerator()->addUrl(
              new Url\UrlConcrete(
                  $url,
                  $date,
                  Url\UrlConcrete::CHANGEFREQ_DAILY,
                  0.6
              ),
              'shops'
          );
		  
          # Подать объявление          
          $url = $this->router->generate('add_adv_page', array('region'=> 'russia'), true);
          
          $event->getGenerator()->addUrl(
              new Url\UrlConcrete(
                  $url,
                  $date,
                  Url\UrlConcrete::CHANGEFREQ_WEEKLY,
                  0.8
              ),
              'add'
          );          
          
          
          foreach ($this->towns as $area) {
            $url = $this->router->generate('add_adv_page', array('region'=> $area->getAlias()), true);
          
            $event->getGenerator()->addUrl(
                new Url\UrlConcrete(
                    $url,
                    $date,
                    Url\UrlConcrete::CHANGEFREQ_WEEKLY,
                    0.8
                ),
                'add_towns'
            ); 
          }          
          
          # Категории
          
          $categories = AdCategoriesQuery::create()            
            ->filterByParentId(NULL)
            ->filterByDeleted(false)
            ->find();
          
          foreach ($categories as $category) {
            $url = $this->router->generate('site_category_page', array('category' => $category->getAlias(),'region'=> 'russia'), true);
            
            $event->getGenerator()->addUrl(
                new Url\UrlConcrete(
                    $url,
                    $date,
                    Url\UrlConcrete::CHANGEFREQ_HOURLY,
                    0.8
                ),
                'categories'
            );
            
            if (count($category->getAdChildss())) {
              foreach ($category->getAdChildss() as $subcategory) {
                $url = $this->router->generate('site_category_page', array('category' => $category->getAlias(), 'subcategory' => $subcategory->getAlias(), 'region'=> 'russia'), true);
                
                $event->getGenerator()->addUrl(
                    new Url\UrlConcrete(
                        $url,
                        $date,
                        Url\UrlConcrete::CHANGEFREQ_HOURLY,
                        0.8
                    ),
                    'subcategories'
                );
              }
            }
          }
          
          foreach ($this->areas as $area) {
            foreach ($categories as $category) {
              $url = $this->router->generate('site_category_page', array('category' => $category->getAlias(),'region'=> $area->getAlias()), true);
              
              $event->getGenerator()->addUrl(
                  new Url\UrlConcrete(
                      $url,
                      $date,
                      Url\UrlConcrete::CHANGEFREQ_HOURLY,
                      0.2
                  ),
                  'categories_areas'
              );
              
              if (count($category->getAdChildss())) {
                foreach ($category->getAdChildss() as $subcategory) {
                  $url = $this->router->generate('site_category_page', array('category' => $category->getAlias(), 'subcategory' => $subcategory->getAlias(), 'region'=> $area->getAlias()), true);
                  
                  $event->getGenerator()->addUrl(
                      new Url\UrlConcrete(
                          $url,
                          $date,
                          Url\UrlConcrete::CHANGEFREQ_HOURLY,
                          0.2
                      ),
                      'subcategories_areas'
                  );
                }
              }
            }
          }  
          
          foreach ($this->towns as $area) {
            foreach ($categories as $category) {
              $url = $this->router->generate('site_category_page', array('category' => $category->getAlias(),'region'=> $area->getAlias()), true);
              
              $event->getGenerator()->addUrl(
                  new Url\UrlConcrete(
                      $url,
                      $date,
                      Url\UrlConcrete::CHANGEFREQ_HOURLY,
                      0.2
                  ),
                  'categories_towns'
              );
              
              if (count($category->getAdChildss())) {
                foreach ($category->getAdChildss() as $subcategory) {
                  $url = $this->router->generate('site_category_page', array('category' => $category->getAlias(), 'subcategory' => $subcategory->getAlias(), 'region'=> $area->getAlias()), true);
                  
                  $event->getGenerator()->addUrl(
                      new Url\UrlConcrete(
                          $url,
                          $date,
                          Url\UrlConcrete::CHANGEFREQ_HOURLY,
                          0.2
                      ),
                      'subcategories_towns'
                  );
                }
              }
            }
          }  
          
          
          # Объявления пользователей
          
          $users = UserQuery::create()            
            ->find();
			
          foreach ($users as $user) {
              
            $url = $this->router->generate('site_user_advs_page', array('user_id' => $user->getId(), 'region'=> 'russia'), true);

            $event->getGenerator()->addUrl(
              new Url\UrlConcrete(
                $url,
                @$user->getCreateDate()?:$user->getLastLogin(),
                Url\UrlConcrete::CHANGEFREQ_WEEKLY,
                0.5
              ),
              'users'
            );				
          }          
		  
          # Объявления магазинов
          $shops = ShopsQuery::create()
            ->filterByEnabled(true)
            ->find();
          
          foreach ($shops as $shop) {
            $url = $this->router->generate('site_shop_advspage', array('alias' => $shop->getAlias(),'region'=> 'russia'), true);
            
            $event->getGenerator()->addUrl(
                new Url\UrlConcrete(
                    $url,
                    $date,
                    Url\UrlConcrete::CHANGEFREQ_DAILY,
                    0.1
                ),
                'shops'
            );
          }
          
          # Объявления
          $advs = AdvsQuery::create()            
            ->orderById()            
            ->find();
          
          foreach ($advs as $adv) {
            $url = $this->router->generate('site_adv_page', array(
              'category' => $adv->getAdCategories()->getAdCategoriesRelatedByParentId()->getAlias(),
              'subcategory' => $adv->getAdCategories()->getAlias(),
              'id' => $adv->getId(),
              'alias' => $adv->getAlias(),
              'region'=> $adv->getRegions()->getAlias()
              ), true);
            $event->getGenerator()->addUrl(
            new Url\UrlConcrete(
              $url,
              $adv->getPublishDate(),
              Url\UrlConcrete::CHANGEFREQ_HOURLY,
              0.7
            ),
            'advs'
          );                      
          }
          
          # Страницы
          $pages = PagesQuery::create()            
            ->orderByAlias()              
            ->find();
          
          foreach ($pages as $page) {
            $url = $this->router->generate('site_pages_page', array('alias' => $page->getAlias()), true);
            
            $event->getGenerator()->addUrl(
                new Url\UrlConcrete(
                    $url,
                    $page->getCreatedAt(),
                    Url\UrlConcrete::CHANGEFREQ_DAILY,
                    1
                ),
                'pages'
            );
          }    
		
          # Новости
          $pages = NewsQuery::create()            
            ->orderByAlias()              
            ->find();
          
          foreach ($pages as $page) {
            $url = $this->router->generate('site_news_item_page', array('alias' => $page->getAlias()), true);
            
            $event->getGenerator()->addUrl(
                new Url\UrlConcrete(
                    $url,
                    $page->getCreatedAt(),
                    Url\UrlConcrete::CHANGEFREQ_DAILY,
                    1
                ),
                'news'
            );
          }   

        }
        if ($section == 'advs') {         
		  
          # Объявления
          $advs = AdvsQuery::create()            
            ->orderById()            
            ->find();
          
          foreach ($advs as $adv) {
            $url = $this->router->generate('site_adv_page', array(
              'category' => $adv->getAdCategories()->getAdCategoriesRelatedByParentId()->getAlias(),
              'subcategory' => $adv->getAdCategories()->getAlias(),
              'id' => $adv->getId(),
              'alias' => $adv->getAlias(),
              'region'=> $adv->getRegions()->getAlias()
              ), true);
            $event->getGenerator()->addUrl(
                new Url\UrlConcrete(
                  $url,
                  $adv->getPublishDate(),
                  Url\UrlConcrete::CHANGEFREQ_HOURLY,
                  0.8
                ),
                'advs'
            );                      
          }            

        }
    }
}