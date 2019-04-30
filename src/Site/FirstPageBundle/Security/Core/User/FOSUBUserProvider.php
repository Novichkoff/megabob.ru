<?php
namespace Site\FirstPageBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Admin\AdminBundle\Model\Transactions;
use Admin\AdminBundle\Model\UserAccount;
use Admin\AdminBundle\Controller\Image;

class FOSUBUserProvider extends BaseClass
{

    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();		

        // формируем access token и user ID
        $service = $response->getResourceOwner()->getName();

        $setter = 'set'.ucfirst($service);
        $setter_id = $setter.'Id';
        $setter_token = $setter.'AccessToken';

        // разъединяем уже подключенного пользователя
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }

        // соединяем с текущим пользователем
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());
		$this->userManager->updateUser($user);
        if ($response->getProfilePicture() && !$user->getPhoto()) {			
          $Filename = uniqid();
          if (@$Filename) {
            $dir = 'images/users/photos';							
            $image_new = new Image($response->getProfilePicture());
            $image_new->thumbnail_full(50, 50);
            $image_new->save($dir . '/' . $Filename . '.png');
            unset($image_new);
          }
          $user->setPhoto($Filename.'.png');
          $this->userManager->updateUser($user);
        }
	}

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $username = $response->getUsername();
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));        

        // если пользователь отсутствует
        if (null === $user) {
            
          $email = $response->getEmail();
          $user = $this->userManager->findUserByUsernameOrEmail($email);
          if ($user) {
            $this->connect($user,$response);
          } else {			
            // блок автоматической регистрации нового пользователя
            //var_dump($response);

            $service = $response->getResourceOwner()->getName();
            if ($service == 'facebook' || $service == 'vkontakte') {					
            
              $setter = 'set'.ucfirst($service);	
              $setter_id = $setter.'Id';
              $setter_token = $setter.'AccessToken';

              // создаем нового пользователя
              $user = $this->userManager->createUser();
              $user->$setter_id($username);
              $user->$setter_token($response->getAccessToken());

              $realname = $response->getRealName();            

              $user->setUsername($email);
              $user->setEmail($email);
              $user->setRealName($realname);
              //if ($response->getProfilePicture()) $user->setPhoto($response->getProfilePicture());
              if ($response->getProfilePicture()) {	
                $Filename = uniqid();
                if (@$Filename) {
                  $dir = 'images/users/photos';							
                  $image_new = new Image($response->getProfilePicture());
                  $image_new->thumbnail_full(50, 50);
                  $image_new->save($dir . '/' . $Filename . '.png');
                  unset($image_new);
                }
                $user->setPhoto($Filename.'.png');
              }
              $user->setCreateDate(date("Y-m-d H:i:s"));
              $user->setEmailToken(md5(uniqid()));
              $user->setPhoneCode(rand(111111, 999999));
              $password_new = uniqid();
              $user->setPlainPassword($password_new);
              $user->setEnabled(true);

              $this->userManager->updateUser($user);   

              $user_account = new UserAccount();
              $user_account->setFosUserId($user->getId());
              $user_account->setBalance(20);
              $user_account->save();
              
              $transaction = new Transactions();
              $transaction->setEmail($user->getEmail());
              $transaction->setFosUserId($user->getId());
              $transaction->setSum('20');
              $transaction->setType('Бонус за регистрацию');
              $transaction->setTransactionDate(date("Y-m-d H:i:s"));
              $transaction->save();

              # Отправляем пользователю письмо о регистрации 
              /*
              $subject = 'Добро пожаловать на Claso';
              $from = 'Claso <no-reply@claso.ru>';
              $to = $user->getEmail();
              $body = $this->renderView(
                'SiteFirstPageBundle:Adv:email.txt.twig',
                array('username' => $user->getUsername(), 'realname' => $user->getRealname(), 'email' => $user->getEmail(), 'email_token' => $user->getEmailToken(),'password' => $password_new)
              );
              if ($this->get('mail_helper')->sendMailing($from, $to, $subject, $body)) $this->get('session')->getFlashBag()->add(
                'noticesite',
                'Письмо с регистрационными данными успешно отправлено');
                
                */

              return $user;
            } else {
              throw new UsernameNotFoundException(sprintf('Нет пользователей связанных с аккаунтом "%s".', $username));
            }
          }			
        }

        // если пользователь есть
        $user = parent::loadUserByOAuthUserResponse($response);

        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';

        //обновляем access token
        $user->$setter($response->getAccessToken());

        return $user;
    }

}