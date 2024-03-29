<?php

/**
 * Created by PhpStorm.
 * User: Новичков
 * Date: 16.04.14
 * Time: 8:59
 */

namespace Site\FirstPageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Admin\AdminBundle\Model\RegionsQuery;
use Symfony\Component\DependencyInjection\Container;

class GeoDetect
{

  public function __construct($options = null)
  {

    $this->dirname = dirname(__file__);

    // ip
    if (!isset($options['ip']) or !$this->is_valid_ip($options['ip'])) $this->ip = $this->
        get_ip();
    elseif ($this->is_valid_ip($options['ip'])) $this->ip = $options['ip'];
    // кодировка
    $this->charset = 'utf-8';
  }


  /**
   * функция возвращет конкретное значение из полученного массива данных по ip
   * @param string - ключ массива. Если интересует конкретное значение. 
   * Ключ может быть равным 'inetnum', 'country', 'city', 'region', 'district', 'lat', 'lng'
   * @param bolean - устанавливаем хранить данные в куки или нет
   * Если true, то в куки будут записаны данные по ip и повторные запросы на ipgeobase происходить не будут.
   * Если false, то данные постоянно будут запрашиваться с ipgeobase
   * @return array OR string - дополнительно читайте комментарии внутри функции.
   */
  function get_value($key = false, $cookie = true)
  {
    $key_array = array(
      'inetnum',
      'country',
      'city',
      'region',
      'district',
      'lat',
      'lng');
    if (!in_array($key, $key_array)) $key = false;

    // если используем куки и параметр уже получен, то достаем и возвращаем данные из куки
    if ($cookie && isset($_COOKIE['geobase']))
    {
      $data = unserialize($_COOKIE['geobase']);
    }
    else
    {
      $data = $this->get_geobase_data();
      setcookie('geobase', serialize($data), time() + 3600 * 24 * 7); //устанавливаем куки на неделю
    }
    if ($key && @$data[$key]) return $data[$key]; // если указан ключ, возвращаем строку с нужными данными
    else  return $data; // иначе возвращаем массив со всеми данными
  }

  /**
   * функция получает данные по ip.
   * @return array - возвращает массив с данными
   */
  function get_geobase_data()
  {
    // получаем данные по ip
    $link = 'ipgeobase.ru:7020/geo?ip=' . $this->ip;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $link);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    $string = curl_exec($ch);
    curl_close($ch);

    // если указана кодировка отличная от windows-1251, изменяем кодировку
    if ($this->charset) $string = iconv('windows-1251', $this->charset, $string);

    $data = $this->parse_string($string);

    return $data;
  }

  /**
   * функция парсит полученные в XML данные в случае, если на сервере не установлено расширение Simplexml
   * @return array - возвращает массив с данными
   */

  function parse_string($string)
  {
    $pa['inetnum'] = '#<inetnum>(.*)</inetnum>#is';
    $pa['country'] = '#<country>(.*)</country>#is';
    $pa['city'] = '#<city>(.*)</city>#is';
    $pa['region'] = '#<region>(.*)</region>#is';
    $pa['district'] = '#<district>(.*)</district>#is';
    $pa['lat'] = '#<lat>(.*)</lat>#is';
    $pa['lng'] = '#<lng>(.*)</lng>#is';
    $data = array();
    foreach ($pa as $key => $pattern)
    {
      if (preg_match($pattern, $string, $out))
      {
        $data[$key] = trim($out[1]);
      }
    }
    return $data;
  }

  /**
   * функция определяет ip адрес по глобальному массиву $_SERVER
   * ip адреса проверяются начиная с приоритетного, для определения возможного использования прокси
   * @return ip-адрес
   */
  function get_ip()
  {
    $ip = false;
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ipa[] = trim(strtok($_SERVER['HTTP_X_FORWARDED_FOR'],
        ','));

    if (isset($_SERVER['HTTP_CLIENT_IP'])) $ipa[] = $_SERVER['HTTP_CLIENT_IP'];

    if (isset($_SERVER['REMOTE_ADDR'])) $ipa[] = $_SERVER['REMOTE_ADDR'];

    if (isset($_SERVER['HTTP_X_REAL_IP'])) $ipa[] = $_SERVER['HTTP_X_REAL_IP'];

    // проверяем ip-адреса на валидность начиная с приоритетного.
    foreach ($ipa as $ips)
    {
      //  если ip валидный обрываем цикл, назначаем ip адрес и возвращаем его
      if ($this->is_valid_ip($ips))
      {
        $ip = $ips;
        break;
      }
    }
    return $ip;

  }

  /**
   * функция для проверки валидности ip адреса
   * @param ip адрес в формате 1.2.3.4
   * @return bolean : true - если ip валидный, иначе false
   */
  function is_valid_ip($ip = null)
  {
    if (preg_match("#^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$#", $ip)) 
        return true; // если ip-адрес попадает под регулярное выражение, возвращаем true

    return false; // иначе возвращаем false
  }

}
