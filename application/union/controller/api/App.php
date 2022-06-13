<?php


namespace app\union\controller\api;




use app\service\ConfigService;

class App extends DgApiBase
{
    public function getAPPInfo()
    {
        $conf = ConfigService::get('mobile_shop');
        if (empty($conf)) {
            data_return('未配置',-1);
        }
        unset($conf['reg_gift_credit'],$conf['auto_receive_order_time']);
        $conf['iosExamine'] = false;
        $conf['appName'] = $conf['shop_name'];
        $conf['logo'] = 'https://source.alipay168.cn/bs_shopupload/bsgoods/8b08229a07efc60fa675539205aa74cf.png8b08229a07efc60fa675539205aa74cf.png?v=1652591496';
        data_return('ok', 0, $conf);
    }

    public function appversion()
    {
        $data = json_decode('{"cache":false,"code":0,"data":{"versionNumber":4},"message":"操作成功"}',true);

        data_return('success',0,$data['data']);
    }


}