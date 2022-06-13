<?php


namespace app\service;

use app\common\controller\AppCommon;

require EXTEND_PATH . 'getui/GTClient.php';

class GeTuiService
{
    /**
     * 单个CID推送消息
     * @param $cid
     * @param $param = [
     *      'title','content','clickType','url'
     * ]
     * @return array
     */
    public static function pushToSingleByCid($cid, $param)
    {
        $appid = 'F1oay2YFG98Zl3M01PwoV7';
        $appkey = 'rfHsBE7Sum7chWNlJPPj1';
        $masterSecret = '3URbjsw3Rm5peoCpbwoJ96';

        //创建API，APPID等配置参考 环境要求 进行获取
        $api = new \GTClient("https://restapi.getui.com", $appkey, $appid, $masterSecret);

        //设置推送参数
        $push = new \GTPushRequest();
        $push->setRequestId(time());
        $message = new \GTPushMessage();
        $notify = new \GTNotification();
        $notify->setTitle($param['title']);
        $notify->setBody($param['content']);
        //点击通知后续动作，目前支持以下后续动作:
        //1、intent：打开应用内特定页面;url：打开网页地址。2、payload：自定义消息内容启动应用。3、payload_custom：自定义消息内容不启动应用。4、startapp：打开应用首页。5、none：纯通知，无后续动作
        $notify->setClickType($param['clickType']);
        if (!empty($param['url']) && in_array($param['clickType'], ['url', 'intent','payload'])) {
            if ($param['clickType']=='url'){
                $notify->setUrl($param['url']);
            }elseif ($param['clickType']=='intent'){
                $notify->setIntent($param['url']);
            }elseif ($param['clickType']=='payload'){
                $notify->setPayload($param['url']);
            }
        }

        $message->setNotification($notify);
        $push->setPushMessage($message);
        $push->setCid($cid);

        //处理返回结果
        $result = $api->pushApi()->pushToSingleByCid($push);
        if (!empty($result['code'])) {
            //todo 异常日志
            DiyLog::file($result,'getui_err.log');
            return data_return_arr('推送失败', -1, $result);
        }
        return data_return_arr('推送成功');
    }


    /**
     * 通过uid推送
     * @param $uid string|array  用户/商家的uid
     * @param $param array 消息配置
     * @param string|array $uidType 用户类型，1-普通用户，2-商家，3-后台管理
     * @return array
     */
    public static function pushToSingleByUid($uids, $param, $uidType = ['in', '1,2,3'])
    {
        if (!is_array($uids)) {
            $uids = [$uids];
        }
        foreach ($uids as $uid) {
            $cid = AppCommon::data_get_column('getui_cid', ['uid' => $uid, 'uid_type' => $uidType], 'cid');
            if (!$cid) {
                continue;
            }
            $res =self::pushToSingleByCid($cid, $param);
            //DiyLog::file([$res,$cid],'getui.log');
        }
        return data_return_arr('推送完成');
    }
}