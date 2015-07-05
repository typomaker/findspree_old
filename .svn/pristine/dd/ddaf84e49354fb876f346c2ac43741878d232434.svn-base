<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 28.03.2015
 * Time: 19:07
 */

namespace common\helpers;


use common\models\User;

class Html extends \yii\helpers\Html
{
	public static $bbRulesQueue=[
		['(\r\n|\n\r|\r|\n)',' <br/> '],
		['\[b\](.*?)\[\/b\]','<strong>$1</strong>'],
		['\[i\](.*?)\[\/i\]','<i>$1</i>'],
		['\[p\](.*?)\[\/p\]','<p>$1</p>'],
		['\[u\](.*?)\[\/u\]','<span style="text-decoration: underline">$1</span>'],
		['\[s\](.*?)\[\/s\]','<span style="text-decoration: line-through">$1</span>'],
		['\[center\](.*?)\[\/center\]','<div style="text-align: center">$1</div>'],
		['\[url\s+(.*?)\](.*?)\[\/url\]','<a href="$1">$2</a>'],
		['\[img\](.*?)\[\/img\]','<img src="$1" class="center-block img-responsive" style="max-width: 600px"/>'],
		['\[em\](.*?)\[\/em\]','<em>$1</em>'],
		['\[small\](.*?)\[\/small\]','<small>$1</small>'],
		['\[h\s*([3-6])\](.*?)\[\/h\]','<h$1>$2</h$1>'],
		['\[ol\](.*?)\[\/ol\]','<ol>$1</ol>'],
		['\[li\](.*?)\[\/li\]','<li>$1</li>'],
		['\[ul\](.*?)\[\/ul\]','<ul>$1</ul>'],
		['https?:\/\/youtu\.be\/([^\s]+)','<iframe width="420" height="315" class="center-block" src="https://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>'],
		['<\/li>[^(ul)]*?<li>','</li><li>'],
		['<ul>.*?<li>','<ul><li>'],
		['<ol>.*?<li>','<ol><li>'],
		['<\/li>\s*<br\/>\s*<\/ul>','</li></ul>'],
		['<\/li>\s*<br\/>\s*<\/ol>','</li></ol>'],
		['\[\/br\]','<br/>'],
	];
    public static $colorsAvatar = [
		['B24D4D','FFF'],
		['FF96CE','FFF'],
		['FF9696','FFF'],
		['75BDA4','FFF'],
		['4DB2AE','FFF'],
		['A663BD','FFF'],
		['DD90F2','FFF'],
		['89E6EA','FFF'],
		['F096FF','FFF'],
		['96AFFF','FFF'],
		['9FE8BF','FFF'],
		['FFBE96','FFF'],
		['636BBD','FFF'],
		['96DAEA','FFF'],
		['A5FF96','FFF'],
		['4DB275','FFF'],

	];

    public static function avatar(User $user, $size = 60, $options = [])
    {
        $size = (int)$size;
        unset($options['height'],$options['width']);
        static::addCssClass($options,'ava');
        if ($src = $user->getAvatar($size)) {
            return static::img($src, $options);
        } else {
			$cssStyleName = '';
			foreach (User::$sizesAvatar as $sizeK => $cssStyleName) {
				if($sizeK >= $size  )break;
			}
			mb_internal_encoding("UTF-8");
            $char1 = mb_substr($user->username, 0, 1);
            $char2 = mb_substr($user->username, 1, 1);
			$charList = array_merge(String::$charsEng,String::$charsRus);
            $posCount = count($charList);
            $pos = array_search(mb_strtolower($char1),$charList)?:0;
            $pos2 = array_search(mb_strtolower($char2),$charList)?:0;
			$count = count(static::$colorsAvatar);
            $colorKey = (int)floor(($pos+$pos2)/($posCount*2)*$count);
            list($backgroundCol,$textCol) = isset(static::$colorsAvatar[$colorKey])? static::$colorsAvatar[$colorKey] : current(self::$colorsAvatar);
            static::addCssClass($options,'fake-avatar');
            static::addCssClass($options,'fake-avatar-'.$cssStyleName);
            static::addCssStyle($options,"color:#{$textCol};background:#{$backgroundCol}");
            return static::tag('div',$char1.$char2, $options);
        }
    }

	public static function bb2html($text){
		foreach (static::$bbRulesQueue as $item) {
			list($regexp, $replace) = $item;
			$text = preg_replace("/$regexp/im",$replace,$text);
		}
		return $text;
	}
}