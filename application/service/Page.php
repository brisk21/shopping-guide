<?php


namespace app\service;


use think\paginator\driver\Bootstrap;

class Page
{
    //返回分页对象
    public static function set($items, $listRows, $currentPage, $total, $query, $path = '')
    {
        return Bootstrap::make($items, $listRows, $currentPage, $total, false, [
            'var_page' => 'page',
            'path' => $path ? $path : url(),
            'query' => $query,
            'fragment' => '',
        ]);
    }
}