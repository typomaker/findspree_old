<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 09.03.15
 * Time: 14:14
 */

namespace common\helpers;


class String
{
	public static $charsRus = ['а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',];
	public static $charsEng = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
    public static $chars = [
		'a','b','c','d','e','q', 'w',  'r', 't', 'y', 'k', 'i', 'o', 'p',  's',  'f', 'g', 'h', 'j',  'l', 'z', 'x',  'v',  'n','u', 'm',
//        'ё', 'й', 'ц', 'у', 'к', 'е', 'н', 'г', 'ш', 'щ', 'з', 'х', 'ъ', 'ф', 'ы', 'в', 'а', 'п', 'р', 'о', 'л', 'д', 'ж', 'э', 'я', 'ч', 'с', 'м',
//        'и', 'т', 'ь', 'б', 'ю'
    ];
    public static function truncate($str, $length = 50, $ending = '...')
    {
//        //^([\w\s,:]{10,40}[^\s]{0,10})
//        if (preg_match('#^(.{0,' . $length . '}[^\s]{0,10}?)#iu', $str, $matches)) {
//            return $matches[1] !== $str ? $matches[1] . $ending : $matches[1];
//        }
		$str = $str." ";
		$str = substr($str,0,$length);
		$str = substr($str,0,strrpos($str,' '));
		$str = $str.$ending;
		return $str;
    }

	public static function price($value)
	{
		return number_format($value,2,'.',' ');
	}
    /**
     * Строку  helloWorld в hello_world
     * @param $string
     * @return string
     */
    public static function camelToUnderscore($string)
    {
        return strtolower(preg_replace('/([A-Z])/', '_$1', lcfirst($string)));
    }

    /**
     * Строку helloWorld в hello-world
     * @param $string
     * @return string
     */
    public static function camelToDash($string)
    {
        return strtolower(preg_replace('/([A-Z])/', '-$1', lcfirst($string)));
    }

    /**
     * Возвращает имя класса без неймспейса
     * @param $className
     * @return mixed
     */
    public static function onlyClassName($className)
    {
        if (!preg_match("/\\\\?([a-z]+)$/i", $className, $matches))
            return $className;
        return $matches[1];
    }

    /**
     * Склонение числительных
     * @param int $int значение
     * @param  array $expressions Массив состоящий из трех вариантов склонения, пример : [яблоко,яблока,яблок]
     * @param false|string $template Показывать в результате значение+числительное, например: "10 яблок",
     *                                  или только числительное, пример: "яблок"
     * @return string Возращает числительное
     */
    static function declension($int, $expressions, $template = '{value} {text}')
    {
        $int = (int)$int;
        $count = $int % 100;
        $params = ['value' => $int, 'text' => ''];
        if ($count >= 5 && $count <= 20) {
            $params['text'] = $expressions['2'];
        } else {
            $count = $count % 10;
            if ($count == 1) {
                $params['text'] = $expressions['0'];
            } elseif ($count >= 2 && $count <= 4) {
                $params['text'] = $expressions['1'];
            } else {
                $params['text'] = $expressions['2'];
            }
        }

        return $template ? self::stripVal($template, $params) : $int;
    }

    static public function stripVal($string, array $values)
    {
        $callable = function ($match) use ($values) {
            return isset($values[$match[1]]) ? $values[$match[1]] : '';
        };
        return preg_replace_callback('/\{(.*?)\}/u', $callable, $string);
    }
}