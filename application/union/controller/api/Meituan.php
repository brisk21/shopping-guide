<?php


namespace app\union\controller\api;

/**
 * Class Meituan 美团
 * @package app\union\controller\api
 */
class Meituan extends DgApiBase
{
    public function meituanPrivilege()
    {
        //generateWeApp: true
        //qrcode: true

        $data = \GuzzleHttp\json_decode('{"cache":false,"code":0,"data":{"h5":"https://click.meituan.com/t?t=1&c=2&p=bcqsUr5znioL","shortH5":"https://dpurl.cn/dkiKSlGz","deeplink":"imeituan://www.meituan.com/web?lch=cps:waimai:3:a144a9fa40a42c55af00214bb4bb3993971:5509dingdanxia666666:33:70690&url=https%3A%2F%2Fclick.meituan.com%2Ft%3Ft%3D1%26c%3D2%26p%3DESWsUr5znioL","h5Evoke":"https://w.dianping.com/cube/evoke/zz_cps/meituan.html?lch=cps:waimai:1:a144a9fa40a42c55af00214bb4bb3993971:5509dingdanxia666666:33:70690&url=https%3A%2F%2Fclick.meituan.com%2Ft%3Ft%3D1%26c%3D2%26p%3DRAKsUr5znioL","qrcode":"https://wxqrcode.dingdanxia.com/qrcode/images/meituan/2022-04-29/db0334f612283c7c7963d39004254dc5/db0334f612283c7c7963d39004254dc5.jpg","weAppInfo":{"appId":"wxde8ac0a21135c07d","pagePath":"/index/pages/h5/h5?lch=cps:waimai:5:a144a9fa40a42c55af00214bb4bb3993971:5509dingdanxia666666:33:70690&weburl=https%3A%2F%2Fdpurl.cn%2FU1vL9Bzz&f_userId=1&f_token=1"}},"message":"操作成功"}',true);

        data_return('ok',0,$data['data']);
    }
}