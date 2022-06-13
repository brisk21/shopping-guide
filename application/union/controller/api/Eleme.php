<?php


namespace app\union\controller\api;

/**
 * Class Eleme 饿了么
 * @package app\union\controller\api
 */
class Eleme  extends DgApiBase
{
    //转链
    public function activityLink()
    {
        //promotionSceneId: "1585018034441"
        $data = \GuzzleHttp\json_decode('{"cache":false,"code":0,"data":{"pic":"https://cdn.osjava.cn/elm_shengxian.png","linkmodel":{"click_url":"https://s.click.ele.me/jUTASYu","longTpwd":"57￥dvM628oXHin￥ https://m.tb.cn/h.frxkJqI  在家逛超市 每日抢限量爆款","tpwd":"9￥dvM628oXHin￥/","Tpwd":"9￥dvM628oXHin￥/"}},"message":"操作成功"}',true);

        data_return('ok',0,$data['data']);

    }
}