<?php
/**
 * Created by PhpStorm.
 * User: Новичков
 * Date: 18.02.14
 * Time: 14:26
 */

namespace Site\FirstPageBundle\Controller;


class WeatherTraffic {

    public static function currentWeather($code){
        if ($code){
            $file = file_get_contents("http://informer.gismeteo.ru/rss/".$code.".xml");
            preg_match_all("#<item.*?>(.*?)</item>#is", $file, $items);
            $data = array();
            foreach($items[1] as $item)
            {
                # выдергиваем текст описания.
                preg_match("#<description>(.*?)</description>#is", $item, $descr);
                # отбрасываем все, что за температурой (давление, ветер и пр.)                
                $descr = preg_replace("#.*температура (.*) С,.*#i", "$1", $descr[1]);
                $descr_items = explode ('..',$descr);

                # получаем адрес картинки.
                preg_match("#<enclosure url=(['\"])(.*?)\\1#is", $item, $img);
                $img = $img[2];

                $dat['descr'] = $descr;
                $dat['img'] = $img;

                $data[] = $dat;
            }
            $_SESSION['weather'] = $data;
            return $data;
        }
    }

    public static function getTraffic(){

            $file = file_get_contents("http://export.yandex.ru/bar/reginfo.xml");
            preg_match_all("#<traffic.*?>(.*?)</traffic>#is", $file, $items);
            $data = array();
            foreach($items[1] as $item)
            {
                # выдергиваем уровень
                preg_match("#<level>(.*?)</level>#is", $item, $level);

                # выдергиваем цвет
                preg_match("#<icon>(.*?)</icon>#is", $item, $icon);

                $dat['level'] = $level[1];
                $dat['icon'] = $icon[1];

                $data[] = $dat;
            }
        $_SESSION['traffic'] = $data;
        return $data;

    }

    public static function getCurrency(){

        $date = date("d/m/Y");
        $url = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=".$date;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_REFERER, 'http://google.com');
        curl_setopt($ch, CURLOPT_USERAGENT, "Opera/9.80 (Windows NT 5.1; U; ru) Presto/2.9.168 Version/11.51");
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        do {
            curl_setopt($ch, CURLOPT_URL, $url);
            $header = curl_exec($ch);
            $ccode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if($ccode == 301 || $ccode == 302) {
                preg_match('/Location:(.*?)\n/', $header, $matches);
                $url = trim(array_pop($matches));
            } else
                $ccode = 0;
        } while($ccode);
        $file = curl_exec($ch);
        curl_close($ch);

        //$file = file_get_contents($url);

        $code='R01235';
        preg_match("/\<Valute ID=\"".$code."\".*?\>(.*?)\<\/Valute\>/is", $file, $m);
        if ($m) preg_match("/<Value>(.*?)<\/Value>/is", $m[1], $r);
        if (@$r) $data['dollar'] = str_replace(",", ".", $r[1]);

        $code='R01239';
        preg_match("/\<Valute ID=\"".$code."\".*?\>(.*?)\<\/Valute\>/is", $file, $m);
        if ($m) preg_match("/<Value>(.*?)<\/Value>/is", $m[1], $r);
        if (@$r) $data['euro'] = str_replace(",", ".", $r[1]);

        $_SESSION['currency'] = @$data;
        return @$data;

    }

} 