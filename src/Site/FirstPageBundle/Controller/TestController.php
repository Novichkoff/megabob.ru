<?php

namespace Site\FirstPageBundle\Controller;
use Admin\AdminBundle\Model\AdvParamsPeer;
use Admin\AdminBundle\Model\AdvsPeer;
use Admin\AdminBundle\Model\UserAccountQuery;
use \Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\AdminBundle\Model\RegionsQuery;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Site\FirstPageBundle\Controller\TopPanel;
use Site\FirstPageBundle\Form\SimpleSearchType;
use Site\FirstPageBundle\Form\Filter;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdvsQuery;
use Site\FirstPageBundle\Form\ExtFilter;
use Admin\AdminBundle\Model\AdvParamsQuery;
use Admin\AdminBundle\Model\AdvImagesQuery;
use Admin\AdminBundle\Model\AdvVideosQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;
use Admin\AdminBundle\Model\MenuQuery;
use Admin\AdminBundle\Model\BannersQuery;

class TestController extends Controller
{

    ##################################################
    #                 Страница поиска                #
    ##################################################

    public function indexAction(Request $request) {
        
      $user = $this->container->get('security.context')->getToken()->getUser();
		
      $advs = AdvsQuery::create()
          ->find();
      $adv = AdvsQuery::create()
          ->findOne();
          
      $body = $this->renderView(
          'SiteFirstPageBundle:Adv:send_mail_admin.txt.twig',
          array('email' => 'test@megabob.ru', 'username' => 'Тест Тестов', 'token' => '54354325', 'advs' => $advs, 'adv' => $adv,
          'sendername' => 'John Doe',
          'senderemail' => 'john.doe@gmail.com',
          'senderphone' => '+72390289320',
          'messagetext' => 'Привет, как дела?')
      );
      return new Response($body);
      
    }

}