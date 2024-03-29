<?php
/**
 * Created by PhpStorm.
 * User: Альберт
 * Date: 15.04.2015
 * Time: 23:02
 */

namespace common\component;


class Request extends \yii\web\Request
{
	private static $botList = [
		['facebookexternalhit','facebook'],
		['Twitterbot','twitter'],
		['TweetmemeBot','twitter:share'],
		['dataminr','twitter'],
		['vkShare','vk'],
		['MJ12bot','majestic'],
		['google','google'],
		'Yandex',
		'YaDirectBot',
		'Yahoo',
		'Go',
		'Gsa-crawler',
		'Rambler',
		'msn',
		'Gigabot',
		'Aport',
		'Lycos',
		'FAST-WebCrawler',
		'Mail.Ru',
		'IDBot',
		'eStyle',
		'AbachoBOT',
		'accoona',
		'AcoiRobot',
		'ASPSeek',
		'CrocCrawler',
		'Dumbot',
		'GeonaBot',
		'MSRBOT',
		'Scooter',
		'AltaVista',
		'WebAlta',
		'Scrubby',
		'Slurp',
		'ia_archiver',
		'Baiduspider',
		'oBot',
		'Speedy Spider',
		'Teoma',
		'Binky',
		'amaya',
		'Webgate',
		'W3C_Validator',
		'libwww',
		'What You Seek',
		'Offline Explorer',
		'Teleport',
		'rambler',
		'aport',
		'yahoo',
		'msnbot',
		'turtle',
		'mail.ru',
		'omsktele',
		'yetibot',
		'picsearch',
		'sape.bot',
		'sape_context',
		'gigabot',
		'snapbot',
		'alexa.com',
		'megadownload.net',
		'askpeter.info',
		'igde.ru',
		'ask.com',
		'qwartabot',
		'yanga.co.uk',
		'scoutjet',
		'similarpages',
		'oozbot',
		'shrinktheweb.com',
		'aboutusbot',
		'followsite.com',
		'dataparksearch',
		'google-sitemaps',
		'appEngine-google',
		'feedfetcher-google',
		'liveinternet.ru',
		'xml-sitemaps.com',
		'agama',
		'metadatalabs.com',
		'h1.hrn.ru',
		'googlealert.com',
		'seo-rus.com',
		'yaDirectBot',
		'yandeG',
		'yandex',
		'yandexSomething',
		'Copyscape.com',
		'AdsBot-Google',
		'domaintools.com',
		'Nigma.ru',
		'dotnetdotcom',
		['Trident','robot'],
	];
	private $_botDetect;
	public function getIsRobot()
	{
		if(!$this->_botDetect){
			/* Эта функция будет проверять, является ли посетитель роботом поисковой системы */
			foreach (static::$botList as $bot) {
				if(is_array($bot)){
					list($id,$title)=$bot;
				}else{
					$id = $title = $bot;
				}
				if (stripos(\Yii::$app->request->getUserAgent(), $id) !== false) {
					$this->_botDetect = $title;
					break;
				}
			}
		}
		return $this->_botDetect;
	}
}