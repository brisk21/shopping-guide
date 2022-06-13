<?php


namespace app\common;


use app\service\DiyLog;
use think\Controller;

class common extends Controller
{
    public static function add_log($title, $content)
    {
        DiyLog::file_trace([
            'title' => $title,
            'content' => $content
        ], 'auto.log','diy');
    }
}