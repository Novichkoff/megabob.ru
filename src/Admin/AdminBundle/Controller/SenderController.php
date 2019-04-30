<?php

namespace Admin\AdminBundle\Controller;

use \Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Propel\UserQuery;
use Admin\AdminBundle\Model\AdvsQuery;
use Symfony\Component\Security\Core\SecurityContext;
use Admin\AdminBundle\Model\Senders;
use Admin\AdminBundle\Model\SendersQuery;
use Site\FirstPageBundle\Controller\TopPanel;
use Site\FirstPageBundle\Form\SimpleSearchType;
use Admin\AdminBundle\Model\MenuQuery;
use Admin\AdminBundle\Model\BannersQuery;
use Admin\AdminBundle\Model\Transactions;
use Admin\AdminBundle\Model\TransactionsQuery;
use Admin\AdminBundle\Model\UserAccount;
use Admin\AdminBundle\Model\UserAccountQuery;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SenderController extends Controller
{
    public function indexAction()
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();
        
        $sender_name = 'take.bonus';
        
        $cnt = 0;
        $senders_all = SendersQuery::create()->filterByName($sender_name)->count();
        $senders_used = SendersQuery::create()->filterByName($sender_name)->filterByUsed(true)->count();

        return $this->render('AdminAdminBundle:Sender:index.html.twig',array(
            'cnt'              => $senders_all,
            'cntUsed'              => $senders_used,
            'for_moders'        => $for_moders
        ));
    } 
    
    public function sendAction()
    {
        $sender_name = 'take.bonus';
        $subject = 'Ваш бонус на MegaBob.ru';
        $from = 'MegaBob.ru <team@megabob.ru>';
        $bonus = 50;
        $advs_cnt = 0;
              
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $users = UserQuery::create()
          ->filterByEmailStatus(true)
          ->filterByEmailConfirm(true)
          //->filterById(2)
          //->join('Shops',Criteria::LEFT_JOIN)
          //->where('Shops.id is null')
          ->join('Advs',Criteria::LEFT_JOIN)          
          //->where('Advs.id is not null')
          //->where('Advs.site is not null')          
          ->withColumn('count(Advs.id)','cnt_adv')
          ->having('cnt_adv >= 1')
          ->groupBy('id')
          //->limit(100)
          ->find();
        
        
        $cnt_all = count($users);
        $cnt = 0;
        
        foreach ($users as $user) {           
          $advs_cnt = AdvsQuery::create()->filterByUserId($user->getId())->count();
          
		  if ($advs_cnt >= 1) {
            $token = uniqid();            
            $sender = SendersQuery::create()->filterByName($sender_name)->findOneByFosUserId($user->getId());
            if (!$sender) {
              $sender = new Senders();
              $sender->setFosUserId($user->getId());
              $sender->setToken($token);
              $sender->setName($sender_name);
              $sender->setBonus($bonus);
              $sender->save();
              
              $to = $user->getEmail();
              $body = $this->renderView(
                  'AdminAdminBundle:Sender:'.$sender_name.'.html.twig',
                  array(
                      'name'  => $user->getRealname(),
                      'email'  => $user->getEmail(),
                      'token' => $token,
                      'bonus' => $bonus,
                      'user'  => $user,
                      'cnt'   => $advs_cnt
                  )
              );
              if($this->get('mail_helper')->sendMailing($from, $to, $subject, $body)) $cnt++;
            }            
            //$cnt++;
          }
        }

        return $this->render('AdminAdminBundle:Sender:index.html.twig',array(
            'cnt'              => $cnt,
            'cntUsed'          => $cnt_all,
            'for_moders'        => $for_moders
        ));
    } 
      
      public function emailAction()
    {
        $sender_name = 'return';        
        $bonus = 50;
        $advs_cnt = 0;
        
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $users = UserQuery::create()
            ->join('Advs',Criteria::INNER_JOIN)            
            ->groupBy('id')
            ->limit(1)
            ->find();
        $user = $users[0];
        $advs_cnt = AdvsQuery::create()->filterByDeleted(true)->filterByUserId($user->getId())->count();
        

        return $this->render('AdminAdminBundle:Sender:'.$sender_name.'.html.twig',array(
            'name'  => $user->getRealname(),
            'email' => $user->getEmail(),
            'token' => uniqid(),
            'bonus' => $bonus,
            'user'  => $user,
            'cnt'   => $advs_cnt
        ));
    }
	
	public function takeBonusAction(Request $request)
    {
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }
        if ($error) {
            $error = $error->getMessage();
        }

        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);
        
        $csrfToken = $this->container->has('form.csrf_provider')
            ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')
            : null;        
        
        $dispatcher = $this->container->get('event_dispatcher');

        $user = UserQuery::create()->findOneById(1);
        $token = @$request->query->get('uid');

        if (@$token) {
          $sender = SendersQuery::create()->findOneByToken($token);
          if ($sender) {
            $user = UserQuery::create()->findOneById($sender->getFosUserId());
            
            // Автовход
            $ftoken = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.context')->setToken($ftoken);
            $this->get('session')->set('_security_main',serialize($ftoken));
            if (!$sender->getUsed()) {
              // Добавление бонуса
              if ($sender->getBonus()) {
                $transaction = new Transactions();
                $transaction->setEmail('team@megabob.ru');
                $transaction->setSum($sender->getBonus());
                $transaction->setFosUserId($user->getId());
                $transaction->setType('Mega Бонус');
                $transaction->setTransactionDate(date("Y-m-d H:i:s"));
                $transaction->save();
                $account = UserAccountQuery::create()->findOneByFosUserId($user->getId());
                if (!$account) {
                  $account = new UserAccount;
                  $account->setFosUserId($user->getId());
                }
                $account->setBalance($account->getBalance() + $sender->getBonus());
                $account->save();
              }
			  
              $sender->setUsed(true);
              $sender->save();
            }
          }
        }
        return $this->redirect($this->generateUrl('user_balance_page'));        
    }
    
    public function restoreAction(Request $request)
    {
        #---- Единая конфигурация -------------------------------------------------------
        #---- Баннеры --------        
        $banner_search = $this->get('banner')->select($zone=2, $request);
        #------------------------------

        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }
        if ($error) {
            $error = $error->getMessage();
        }

        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);
        
        $csrfToken = $this->container->has('form.csrf_provider')
            ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')
            : null;
        # Формируем верхнюю панель
        $top_panel = $this->get('toppanel')->buildPanel($request);        

        $search_form = $this->createForm(new SimpleSearchType());

        $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'show';

        $menu = MenuQuery::create()->find();
        
        $dispatcher = $this->container->get('event_dispatcher');

        $user = UserQuery::create()->findOneById(1);
        $token = @$request->query->get('uid');

        if (@$token) {
          $sender = SendersQuery::create()->findOneByToken($token);
          if ($sender) {
            $user = UserQuery::create()->findOneById($sender->getFosUserId());
            
            // Автовход
            $ftoken = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.context')->setToken($ftoken);
            $this->get('session')->set('_security_main',serialize($ftoken));
            if (!$sender->getUsed()) {
              // Добавление бонуса
              if ($sender->getBonus()) {
                $transaction = new Transactions();
                $transaction->setEmail('return@megabob.ru');
                $transaction->setSum($sender->getBonus());
                $transaction->setFosUserId($user->getId());
                $transaction->setType('Бонус за Возвращение');
                $transaction->setTransactionDate(date("Y-m-d H:i:s"));
                $transaction->save();
                $account = UserAccountQuery::create()->findOneByFosUserId($user->getId());
                if (!$account) {
                  $account = new UserAccount;
                  $account->setFosUserId($user->getId());
                }
                $account->setBalance($account->getBalance() + $sender->getBonus());
                $account->save();
              }           
                            
              // Автоматическое восстановление объявлений пользователя
              
              $advs = AdvsQuery::create()->filterByEnabled(false)->filterByUserId($user->getId())->find();
              foreach ($advs as $adv) {
                $adv->setPublishDate(date("Y-m-d H:i:s"));
                $adv->setPublishBeforeDate(strtotime("+90 days", strtotime(date("Y-m-d H:i:s"))));
                $adv->setModerApproved(false);
                $adv->setEnabled(true);
                $adv->setDeleted(false);
                $adv->save();
              }              
              
              $sender->setUsed(true);
              $sender->save();
            }
          }
        }
        //return $this->redirect($this->generateUrl('user_balance_page'));
        
        return $this->render('AdminAdminBundle:Sender:restore.html.twig',array(
            'banner_search'     => $banner_search,
            'csrf_token'        => $csrfToken,
            'last_username'     => $lastUsername,
            'error'             => $error, 
            'bonus'             => $sender->getBonus(),            
            'top_panel'         => $top_panel,
            'search_form'       => $search_form->createView(),
            'filt'              => $filt,            
            'menu'              => $menu,
            'name'              => $user->getRealname()
        ));
        
    }

}
