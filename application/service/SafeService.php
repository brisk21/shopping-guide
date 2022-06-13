<?php


namespace app\service;


class SafeService
{
    /**
     * 过滤字符串，把黄赌毒的过滤替换
     * @param $str
     * @return string
     */
    public static function filter_str($str)
    {
        $conf = ConfigService::get('web_safe',1);
        if (!empty($conf['sensitive_words']) && file_exists(ROOT_PATH.'extend/safe/sex.php')) {
            $words = include ROOT_PATH.'extend/safe/sex.php';
            $badWord = array_combine($words,array_fill(0,count($words),'***'));
            return  strtr($str, $badWord);
        }
        return  $str;
    }
}