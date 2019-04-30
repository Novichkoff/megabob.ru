<?php

namespace Site\FirstPageBundle\Controller;

use \Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Propel\UserQuery;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\UserMessagesQuery;

class BotController extends Controller
{
  
  public function indexAction(Request $request)
  {    
    $token = "366655492:AAH7rNtNASdn3ZegHL9M4zt9bs1pZ-5S8Gc";
    $output = json_decode(file_get_contents('php://input'), TRUE);
    $chat_id = $output['message']['chat']['id'];
    
    $code = "\ud83d\ude03";
    $emoji = json_decode('"'.$code.'"');
      
    if ($chat_id) {
      $user = UserQuery::create()->filterByTelegram($chat_id)->filterByTelegramOn(1)->findOne();
      $keys = array();
      $keys[] = array("Поиск");
      if ($user) {
        $keys[] = array("Мои объявления","Мои сообщения");
        $first_name = $user->getRealname();
      } else {
        $keys[] = array("Авторизоваться");
        $first_name = $output['message']['chat']['first_name'];
      }      
      
      $bot = new \TelegramBot\Api\BotApi($token);
      $replyMarkup = new \TelegramBot\Api\Types\ReplyKeyboardMarkup($keys, false, true);      
      $answers = array();
      
      
      $message = $output['message']['text'];
      $reply_to_message = @$output['message']['reply_to_message']['text']?:NULL;   
      
      if ($reply_to_message) {
        switch($reply_to_message) {
          case ('Введите логин:') : 
            $user = UserQuery::create()->filterByEmail($message)->findOne();		
            if (@$user->getId()) {
              $user->setTelegram($chat_id);
              $user->save();
              $answers[] = 'Введите пароль:';
              // Ждем ответа
              $replyMarkup = new \TelegramBot\Api\Types\ForceReply();              
            } else {
              $answers[] = 'Не удалось найти такого пользователя';
            }
          break;
          case ('Введите пароль:') :
            $user = UserQuery::create()->filterByTelegram($chat_id)->findOne();
            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            if ($encoder->isPasswordValid($user->getPassword(), $message, $user->getSalt())) {
              if ($user->getLocked()) {
                $answers[] = 'Ваша учетная запись заблокирована!';
              } else {
                $answers[] = 'Добро пожаловать, '.$user->getRealname();              
                $user->setTelegramOn(1);
                $user->save();
                array_pop($keys);
                $keys[] = array("Мои объявления","Мои сообщения");
                $replyMarkup = new \TelegramBot\Api\Types\ReplyKeyboardMarkup($keys, false, true);
              }		  
            } else {
              $answers[] = 'Неверный пароль пользователя!';              
            }
          break;
          case ('Что ищем?') : 
            $advs = AdvsQuery::create('Advs')
              ->filterByEnabled(true)
              ->filterByDeleted(false)
              ->filterByText($message)
              ->orderBy('UpDate', 'desc')
              ->limit(5)
              ->find();
            if (count($advs)) {
              foreach ($advs as $adv) {
                $answers[] = '<a href="https://claso.ru/russia/'.$adv->getId().'">Объявление № '.$adv->getID().'</a>';
              }              
            } else {
              $answers[] = 'Не удалось ничего найти';
            }
          break;
        }        
      } else {      
        switch($this->strtolower_ru($message)) {
          case ('/start') : $answers[] = $first_name.',
Добро пожаловать!'; break;        
          case ('поиск') : 
            $answers[] = 'Что ищем?';
            // Ждем ответа
            $replyMarkup = new \TelegramBot\Api\Types\ForceReply(); 
          break;
          case ('авторизоваться') : 
            $answers[] = 'Введите логин:';
            // Ждем ответа
            $replyMarkup = new \TelegramBot\Api\Types\ForceReply(); 
          break;
          case ('мои объявления') : 
            $advs = $user->getAdvss();
            if (count($advs)) {
              foreach ($advs as $adv) {
                $answers[] = '<a href="https://claso.ru/russia/'.$adv->getId().'">Объявление № '.$adv->getID().'</a>';
              }
            } else {
              $answers[] = 'У вас нет объявлений';
            }
          break;
          case ('мои сообщения') : 
            $messages = UserMessagesQuery::create()->filterByFosUserId($user->getId())->orderByDate('DESC')->find();           
            if (count($messages)) {
              foreach ($messages as $message) {
                $answers[] = $message->getSenderName() . ': <b>'.$message->getMessage().'</b>';
              }
            } else {
              $answers[] = 'У вас нет сообщений';
            }
          break;
          default : $answers[] = 'Неизвестная команда ('.$message.')'; file_put_contents('bot.txt',serialize($output)); break;
        }
      }
      if (count($answers))
        foreach ($answers as $answer) {
          $bot->sendMessage($chat_id, $answer, 'html', false, null, $replyMarkup);
        }
    }
    
    return new Response('Ok');
  }
  
  function strtolower_ru($text) {
    $alfavitlover = array('ё','й','ц','у','к','е','н','г', 'ш','щ','з','х','ъ','ф','ы','в', 'а','п','р','о','л','д','ж','э', 'я','ч','с','м','и','т','ь','б','ю');
    $alfavitupper = array('Ё','Й','Ц','У','К','Е','Н','Г', 'Ш','Щ','З','Х','Ъ','Ф','Ы','В', 'А','П','Р','О','Л','Д','Ж','Э', 'Я','Ч','С','М','И','Т','Ь','Б','Ю');
    return str_replace($alfavitupper,$alfavitlover,strtolower($text));
  }
  
  public function sendAction(Request $request)
  {
    $text = file_get_contents('bot.txt');
    $data = unserialize($text);
    phpinfo();
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    return new Response('Ok');
  }
  
}
