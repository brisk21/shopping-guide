<?php


namespace app\admin\controller\shop;


use app\admin\controller\com\Admin;
use app\service\ConfigService;

class Setting extends Admin
{
    public function index()
    {
        $conf = ConfigService::get('mobile_shop', 1);
        if (!empty($conf)) {
            $this->assign('data', $conf);
        }
        return $this->fetch();
    }

    public function config_action()
    {
        $rule = [
            ['type' => 'length', 'key' => 'shop_name', 'rule' => '2,80', 'msg' => '名称未设置',],
            ['type' => 'empty', 'key' => 'shop_tel', 'rule' => '', 'msg' => '联系电话必填',],
            ['type' => 'empty', 'key' => 'reg_type', 'rule' => '', 'msg' => '注册类型未选择',],
        ];
        $check = check_param($this->param, $rule);
        if ($check['code'] <> 0) {
            data_return($check['msg'], $check['code']);
        }
        $data = [
            'reg_type' => intval($this->param['reg_type']),
            'shop_name' => $this->param['shop_name'],
            'shop_tel' => $this->param['shop_tel'],
            'shop_address_tihuo' => $this->param['shop_address_tihuo'],
            'shop_type' => intval($this->param['shop_type']),
            'pay_credit' => !empty($this->param['pay_credit']) ? 1 : 0,
            'pay_alipay' => !empty($this->param['pay_alipay']) ? 1 : 0,
            'pay_wechat' => !empty($this->param['pay_wechat']) ? 1 : 0,
            //是否支持微信登录
            'wx_login' => !empty($this->param['wx_login']) ? 1 : 0,
            //是否支持游客登录
            'login_tmp_user' => !empty($this->param['login_tmp_user']) ? 1 : 0,
            'gift_order_point' => max(0, intval($this->param['gift_order_point'])),
            'auto_receive_order_time' => max(0,intval($this->param['auto_receive_order_time'])),
            //注册赠送金额
            'reg_gift_credit' => max(0, intval($this->param['reg_gift_credit'])),
            'footer_code' => !empty($this->param['footer_code']) ? input('footer_code','',null) : '',
        ];

        if ($data['shop_type'] == 2 && empty($data['shop_address_tihuo'])) {
            data_return('提货类型必填提货地址', -1);
        }

        $key = 'mobile_shop';
        ConfigService::action($key, $data);

        parent::add_admin_log(['title' => '操作网站配置', 'content' => $data]);
        data_return('保存成功');
    }
}