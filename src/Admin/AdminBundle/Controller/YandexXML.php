<?php
/**
 * Created by PhpStorm.
 * User: Новичков
 * Date: 10.04.14
 * Time: 14:40
 */

namespace Admin\AdminBundle\Controller;

class YandexXML {
	var $domain = 'ru';
	var $params = array(
		'user' => 'clasoru',
		'key' => '03.292217608:9aed698aee90eb1d283500be5d940231',
	);
	var $life_time = 0;
	var $cache_path = '';

	function set_param($key, $val=null) {
		if ( is_array($key) ) {
			foreach ( $key as $k=>$v ) $this->set_param($k, $v);
		} else {
			if ( empty($val) ) {
				switch ( $key ) {
					case 'domain': $this->domain = 'ru'; break;
					case 'life_time': $this->life_time = 0; break;
					case 'cache_path': $this->cache_path = ''; break;
					default: unset($this->params[$key]); break;
				}
			} else {
				switch ( $key ) {
					case 'domain': $this->domain = (string) $val; break;
					case 'life_time': $this->life_time = (int) $val; break;
					case 'cache_path': $this->cache_path = (string) $val; break;
					default: $this->params[$key] = (string) $val; break;
				}
			}
		}
	}

	function get() {
		$url = 'http://xmlsearch.yandex.'. $this->domain .'/xmlsearch?'. http_build_query($this->params).'&groupby=attr%3D%22%22.mode%3Dflat.groups-on-page%3D100.docs-in-group%3D1';
		return file_get_contents($url);
	}

	function request() {
		if ( $this->life_time > 0 ) {
			$cache_md5 = md5(http_build_query($this->params));
			$cache_file = $this->cache_path .'yandex_'. $cache_md5 .'.xml';
			if ( file_exists($cache_file) ) {
				$cache_time = filemtime($cache_file);
				if ( ( time() - $cache_time ) > $this->life_time ) {
					$xmlstr = $this->get();
					file_put_contents($cache_file, $xmlstr);
				} else {
					$xmlstr = file_get_contents($cache_file);
				}
			} else {
				$xmlstr = $this->get();
				file_put_contents($cache_file, $xmlstr);
			}
		} else {
			$xmlstr = $this->get();
		}
		return new \SimpleXMLElement($xmlstr);
	}
}