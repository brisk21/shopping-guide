<?php


namespace app\union\controller\api;


class Message extends DgApiBase
{
    //官方通知
    public function getMessageList()
    {
        $data = [
            [
            'title'=>'通知标题',
            'createTime'=> date('Y-m-d'),
            'content' => '通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容'
        ],
            [
                'title'=>'通知标题2',
                'createTime'=> date('Y-m-d'),
                'content' => '通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容'
            ],
            [
                'title'=>'通知标题3',
                'createTime'=> date('Y-m-d'),
                'content' => '通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容通知内容'
            ],
        ];

        data_return('ok',0,$data );
    }
}